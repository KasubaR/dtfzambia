<?php
// app/Http/Controllers/EnrollmentController.php

namespace App\Http\Controllers;

use App\Mail\EnrollmentSubmittedMail;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:enrollments,email',
            'phone' => 'required|string|max:20|unique:enrollments,phone',
            'nrc' => 'required|string|max:20|unique:enrollments,nrc',
            'age_range' => 'required|in:18-24,25-34,35-44,45+',
            'location' => 'required|string|max:255',
            'education_level' => 'required|in:secondary,certificate,diploma,bachelor,master,other',
            'employment_status' => 'required|in:student,employed,self-employed,unemployed',
            'workplace' => 'nullable|required_if:employment_status,employed,self-employed|string|max:255',
            'reason' => 'required|string|min:10',
            'courses' => 'required|array|min:1',
            'courses.*' => 'exists:courses,id',
        ]);
        
        $courseIds = array_values(array_unique($validated['courses']));
        $courseCount = count($courseIds);
        $totalPrice = $this->calculatePrice($courseCount);

        $courses = Course::whereIn('id', $courseIds)->get()->keyBy('id');

        $enrollment = Enrollment::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'nrc' => $validated['nrc'],
            'age_range' => $validated['age_range'],
            'location' => $validated['location'],
            'education_level' => $validated['education_level'],
            'employment_status' => $validated['employment_status'],
            'workplace' => $validated['workplace'] ?? null,
            'reason' => $validated['reason'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'enrolled_at' => now(),
        ]);

        $attachPayload = [];
        foreach ($courseIds as $courseId) {
            $course = $courses->get($courseId);
            if ($course === null) {
                continue;
            }
            $attachPayload[$courseId] = [
                'price_at_enrollment' => $course->price,
                'status' => Enrollment::PIVOT_PENDING,
            ];
        }
        $enrollment->courses()->attach($attachPayload);

        $enrollment->load('courses');

        try {
            Mail::to($enrollment->email)->send(new EnrollmentSubmittedMail($enrollment));
        } catch (\Throwable $e) {
            Log::error('Enrollment submission email failed', [
                'enrollment_id' => $enrollment->id,
                'exception' => $e::class,
                'message' => $e->getMessage(),
            ]);
        }

        return redirect()->route('enrollment.success', $enrollment->id)
                         ->with('success', 'Enrollment submitted successfully!');
    }
    
    public function success($id)
    {
        $enrollment = Enrollment::with('courses')->findOrFail($id);
        return view('public.enrollment.success', compact('enrollment'));
    }
    
    private function calculatePrice($count)
    {
        $pricing = [
            1 => 1750,
            2 => 3000,
            3 => 4750,
        ];
        
        if ($count <= 3) {
            return $pricing[$count];
        }
        
        return $pricing[3] + (($count - 3) * 1750);
    }
}