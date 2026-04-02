<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EnrollmentDecisionMail;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ApplicationsController extends Controller
{
    public function index()
    {
        $applications = Enrollment::with('courses')
            ->whereHas(
                'courses',
                fn ($q) => $q->where('course_enrollment.status', Enrollment::PIVOT_PENDING)
            )
            ->latest()
            ->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load('courses');

        return view('admin.applications.show', compact('enrollment'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $payload = $this->normalizeCoursesPayload($request, $enrollment);

        $enrollment->load('courses');
        $allowedIds = $enrollment->courses->pluck('id')->map(fn ($id) => (int) $id)->all();

        $updated = 0;
        $skippedDecided = false;

        foreach ($payload as $courseId => $decision) {
            $courseId = (int) $courseId;

            if (! in_array($courseId, $allowedIds, true)) {
                throw ValidationException::withMessages([
                    'courses' => 'One or more course IDs do not belong to this enrollment.',
                ]);
            }

            $course = $enrollment->courses->first(fn ($c) => (int) $c->id === $courseId);
            $current = $course->pivot->status ?? Enrollment::PIVOT_PENDING;

            if ($current !== Enrollment::PIVOT_PENDING) {
                $skippedDecided = true;

                continue;
            }

            $newStatus = match ($decision) {
                'accepted'   => Enrollment::PIVOT_ACCEPTED,
                'waitlisted' => Enrollment::PIVOT_WAITLISTED,
                default      => Enrollment::PIVOT_REJECTED,
            };

            $enrollment->courses()->updateExistingPivot($courseId, [
                'status' => $newStatus,
                'reviewed_at' => now(),
            ]);
            $updated++;
        }

        if ($updated === 0 && $skippedDecided) {
            return redirect()
                ->back()
                ->with('warning', 'No changes applied — selected course(s) were already decided.');
        }

        if ($updated === 0) {
            return redirect()
                ->back()
                ->with('warning', 'No pending course decisions to apply.');
        }

        $enrollment->refresh();
        $enrollment->load('courses');
        $enrollment->status = $enrollment->rollupStatus();
        $enrollment->save();

        $this->maybeSendDecisionEmail($enrollment);

        $message = 'Application updated.';
        if ($skippedDecided) {
            $message .= ' Some courses were already decided and were skipped.';
        }

        return redirect()
            ->back()
            ->with('success', $message);
    }

    public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:enrollments,id',
        ]);

        $count = 0;
        $skipped = 0;

        foreach ($validated['ids'] as $id) {
            $enrollment = Enrollment::with('courses')->find($id);
            if (! $enrollment) {
                continue;
            }

            $updated = 0;
            foreach ($enrollment->courses as $course) {
                if ($course->pivot->status !== Enrollment::PIVOT_PENDING) {
                    $skipped++;
                    continue;
                }
                $enrollment->courses()->updateExistingPivot($course->id, [
                    'status'      => Enrollment::PIVOT_ACCEPTED,
                    'reviewed_at' => now(),
                ]);
                $updated++;
            }

            if ($updated > 0) {
                $enrollment->refresh()->load('courses');
                $enrollment->status = $enrollment->rollupStatus();
                $enrollment->save();
                $this->maybeSendDecisionEmail($enrollment);
                $count++;
            }
        }

        if ($count === 0) {
            return redirect()->route('admin.applications.index')
                ->with('warning', 'No changes applied — selected application(s) were already decided.');
        }

        $message = "Approved {$count} application(s).";
        if ($skipped > 0) {
            $message .= " {$skipped} course decision(s) were already set and skipped.";
        }

        return redirect()->route('admin.applications.index')->with('success', $message);
    }

    public function bulkReject(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:enrollments,id',
        ]);

        $count = 0;
        $skipped = 0;

        foreach ($validated['ids'] as $id) {
            $enrollment = Enrollment::with('courses')->find($id);
            if (! $enrollment) {
                continue;
            }

            $updated = 0;
            foreach ($enrollment->courses as $course) {
                if ($course->pivot->status !== Enrollment::PIVOT_PENDING) {
                    $skipped++;
                    continue;
                }
                $enrollment->courses()->updateExistingPivot($course->id, [
                    'status'      => Enrollment::PIVOT_REJECTED,
                    'reviewed_at' => now(),
                ]);
                $updated++;
            }

            if ($updated > 0) {
                $enrollment->refresh()->load('courses');
                $enrollment->status = $enrollment->rollupStatus();
                $enrollment->save();
                $this->maybeSendDecisionEmail($enrollment);
                $count++;
            }
        }

        if ($count === 0) {
            return redirect()->route('admin.applications.index')
                ->with('warning', 'No changes applied — selected application(s) were already decided.');
        }

        $message = "Rejected {$count} application(s).";
        if ($skipped > 0) {
            $message .= " {$skipped} course decision(s) were already set and skipped.";
        }

        return redirect()->route('admin.applications.index')->with('warning', $message);
    }

    public function bulkWaitlist(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:enrollments,id',
        ]);

        $count = 0;
        $skipped = 0;

        foreach ($validated['ids'] as $id) {
            $enrollment = Enrollment::with('courses')->find($id);
            if (! $enrollment) {
                continue;
            }

            $updated = 0;
            foreach ($enrollment->courses as $course) {
                if ($course->pivot->status !== Enrollment::PIVOT_PENDING) {
                    $skipped++;
                    continue;
                }
                $enrollment->courses()->updateExistingPivot($course->id, [
                    'status'      => Enrollment::PIVOT_WAITLISTED,
                    'reviewed_at' => now(),
                ]);
                $updated++;
            }

            if ($updated > 0) {
                $enrollment->refresh()->load('courses');
                $enrollment->status = $enrollment->rollupStatus();
                $enrollment->save();
                $this->maybeSendDecisionEmail($enrollment);
                $count++;
            }
        }

        if ($count === 0) {
            return redirect()->route('admin.applications.index')
                ->with('warning', 'No changes applied — selected application(s) were already decided.');
        }

        $message = "Added {$count} application(s) to the waiting list.";
        if ($skipped > 0) {
            $message .= " {$skipped} course decision(s) were already set and skipped.";
        }

        return redirect()->route('admin.applications.index')->with('success', $message);
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:enrollments,id',
        ]);

        $ids = $validated['ids'];

        DB::transaction(function () use ($ids): void {
            DB::table('course_enrollment')->whereIn('enrollment_id', $ids)->delete();
            Enrollment::whereIn('id', $ids)->delete();
        });

        return redirect()->route('admin.applications.index')
            ->with('success', count($ids) . ' application(s) permanently deleted.');
    }

    /**
     * @return array<int, string> course_id => accepted|rejected
     */
    protected function normalizeCoursesPayload(Request $request, Enrollment $enrollment): array
    {
        $enrollment->loadMissing('courses');
        $allowed = $enrollment->courses->pluck('id')->map(fn ($id) => (int) $id)->all();

        if ($request->has('courses') && is_array($request->input('courses'))) {
            $raw = $request->input('courses');
            $out = [];

            foreach ($raw as $courseId => $decision) {
                $courseId = (int) $courseId;

                if (! in_array($courseId, $allowed, true)) {
                    throw ValidationException::withMessages([
                        'courses' => 'Invalid course ID for this enrollment.',
                    ]);
                }

                if (! is_string($decision) || ! in_array($decision, ['accepted', 'rejected', 'waitlisted'], true)) {
                    throw ValidationException::withMessages([
                        'courses' => 'Each decision must be "accepted", "rejected", or "waitlisted".',
                    ]);
                }

                $out[$courseId] = $decision;
            }

            if ($out === []) {
                throw ValidationException::withMessages([
                    'courses' => 'Provide at least one course decision.',
                ]);
            }

            return $out;
        }

        if ($request->filled('course_id')) {
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'decision'  => 'required|in:accept,reject,waitlist',
            ]);

            $courseId = (int) $validated['course_id'];

            if (! in_array($courseId, $allowed, true)) {
                abort(404);
            }

            $decision = match ($validated['decision']) {
                'accept'    => 'accepted',
                'waitlist'  => 'waitlisted',
                default     => 'rejected',
            };

            return [$courseId => $decision];
        }

        throw ValidationException::withMessages([
            'courses' => 'Provide a courses map (course_id => accepted|rejected) or course_id with decision.',
        ]);
    }

    protected function maybeSendDecisionEmail(Enrollment $enrollment): void
    {
        DB::transaction(function () use ($enrollment): void {
            $locked = Enrollment::query()
                ->whereKey($enrollment->getKey())
                ->lockForUpdate()
                ->first();

            if ($locked === null) {
                return;
            }

            $locked->load('courses');

            if (! $locked->allCoursesDecided()) {
                return;
            }

            if ($locked->decision_email_sent_at !== null) {
                return;
            }

            try {
                Mail::to($locked->email)->send(new EnrollmentDecisionMail($locked));
                $locked->forceFill(['decision_email_sent_at' => now()])->save();
            } catch (\Throwable $e) {
                Log::error('Enrollment decision email failed', [
                    'enrollment_id' => $locked->id,
                    'exception' => $e::class,
                    'message' => $e->getMessage(),
                ]);
            }
        });
    }
}
