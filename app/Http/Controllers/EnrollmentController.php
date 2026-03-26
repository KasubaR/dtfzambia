<?php
// app/Http/Controllers/EnrollmentController.php

namespace App\Http\Controllers;

use App\Mail\EnrollmentOtpMail;
use App\Mail\EnrollmentSubmittedMail;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class EnrollmentController extends Controller
{
    public function create()
    {
        $courses = Course::all();
        return view('public.enrollment', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'         => 'required|string|max:255',
            'email'             => ['required', 'email', 'max:255',
                                    Rule::unique('enrollments', 'email')->whereNot('status', 'pending_verification')],
            'phone'             => ['required', 'string', 'max:20',
                                    Rule::unique('enrollments', 'phone')->whereNot('status', 'pending_verification')],
            'nrc'               => ['required', 'string', 'max:20',
                                    Rule::unique('enrollments', 'nrc')->whereNot('status', 'pending_verification')],
            'age_range'         => 'required|in:18-24,25-34,35-44,45+',
            'location'          => 'required|string|max:255',
            'education_level'   => 'required|in:secondary,certificate,diploma,bachelor,master,other',
            'employment_status' => 'required|in:student,employed,self-employed,unemployed',
            'workplace'         => 'nullable|required_if:employment_status,employed,self-employed|string|max:255',
            'reason'            => 'required|string|min:10',
            'courses'           => 'required|array|min:1',
            'courses.*'         => 'exists:courses,id',
        ]);

        // Remove any stale pending_verification records for the same identity
        Enrollment::where('status', 'pending_verification')
            ->where(function ($q) use ($validated) {
                $q->where('email', $validated['email'])
                  ->orWhere('phone', $validated['phone'])
                  ->orWhere('nrc', $validated['nrc']);
            })->delete();

        $courseIds   = array_values(array_unique($validated['courses']));
        $totalPrice  = $this->calculatePrice(count($courseIds));
        $courses     = Course::whereIn('id', $courseIds)->get()->keyBy('id');
        $code        = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $enrollment = Enrollment::create([
            'full_name'               => $validated['full_name'],
            'email'                   => $validated['email'],
            'phone'                   => $validated['phone'],
            'nrc'                     => $validated['nrc'],
            'age_range'               => $validated['age_range'],
            'location'                => $validated['location'],
            'education_level'         => $validated['education_level'],
            'employment_status'       => $validated['employment_status'],
            'workplace'               => $validated['workplace'] ?? null,
            'reason'                  => $validated['reason'],
            'total_price'             => $totalPrice,
            'status'                  => 'pending_verification',
            'verification_code'       => $code,
            'verification_expires_at' => now()->addMinutes(15),
            'enrolled_at'             => now(),
        ]);

        $attachPayload = [];
        foreach ($courseIds as $courseId) {
            $course = $courses->get($courseId);
            if ($course === null) {
                continue;
            }
            $attachPayload[$courseId] = [
                'price_at_enrollment' => $course->price,
                'status'              => Enrollment::PIVOT_PENDING,
            ];
        }
        $enrollment->courses()->attach($attachPayload);

        try {
            Mail::to($enrollment->email)->send(new EnrollmentOtpMail($enrollment, $code));
        } catch (\Throwable $e) {
            Log::error('OTP email failed', [
                'enrollment_id' => $enrollment->id,
                'exception'     => $e::class,
                'message'       => $e->getMessage(),
            ]);
        }

        return redirect()->route('enrollment.verify', $enrollment->id);
    }

    public function showVerify($id)
    {
        $enrollment = Enrollment::findOrFail($id);

        if ($enrollment->status !== 'pending_verification') {
            return redirect()->route('enrollment.success', $id);
        }

        return view('public.enrollment.verify', compact('enrollment'));
    }

    public function verify(Request $request, $id)
    {
        $enrollment = Enrollment::with('courses')->findOrFail($id);

        if ($enrollment->status !== 'pending_verification') {
            return redirect()->route('enrollment.success', $id);
        }

        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $entered = $request->input('code');

        if ($enrollment->verification_expires_at->isPast()) {
            return back()->withErrors(['code' => 'This code has expired. Use the link below to request a new one.']);
        }

        if ($entered !== $enrollment->verification_code) {
            return back()->withErrors(['code' => 'Incorrect code. Please check your email and try again.']);
        }

        $enrollment->update([
            'status'                  => 'pending',
            'verification_code'       => null,
            'verification_expires_at' => null,
        ]);

        try {
            Mail::to($enrollment->email)->send(new EnrollmentSubmittedMail($enrollment));
        } catch (\Throwable $e) {
            Log::error('Enrollment submission email failed', [
                'enrollment_id' => $enrollment->id,
                'exception'     => $e::class,
                'message'       => $e->getMessage(),
            ]);
        }

        return redirect()->route('enrollment.success', $enrollment->id)
                         ->with('success', 'Enrollment submitted successfully!');
    }

    public function resend($id)
    {
        $enrollment = Enrollment::findOrFail($id);

        if ($enrollment->status !== 'pending_verification') {
            return redirect()->route('enrollment.success', $id);
        }

        // Rate limit: block if a code was issued less than 60 seconds ago
        if ($enrollment->verification_expires_at) {
            $issuedAt = $enrollment->verification_expires_at->subMinutes(15);
            if ($issuedAt->isAfter(now()->subMinute())) {
                return back()->with('resend_error', 'Please wait a moment before requesting a new code.');
            }
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $enrollment->update([
            'verification_code'       => $code,
            'verification_expires_at' => now()->addMinutes(15),
        ]);

        try {
            Mail::to($enrollment->email)->send(new EnrollmentOtpMail($enrollment, $code));
        } catch (\Throwable $e) {
            Log::error('OTP resend email failed', [
                'enrollment_id' => $enrollment->id,
                'exception'     => $e::class,
                'message'       => $e->getMessage(),
            ]);
        }

        return back()->with('resent', true);
    }

    public function success($id)
    {
        $enrollment = Enrollment::with('courses')->findOrFail($id);
        return view('public.enrollment.success', compact('enrollment'));
    }

    private function calculatePrice(int $count): int
    {
        $pricing = [1 => 1750, 2 => 3000, 3 => 4750];

        if ($count <= 3) {
            return $pricing[$count];
        }

        return $pricing[3] + (($count - 3) * 1750);
    }
}
