<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        /* ── Stats ───────────────────────────────────────────── */
        $totalEnrollments  = Enrollment::count();
        $enrollmentsToday  = Enrollment::whereDate('created_at', today())->count();
        /* Pending = at least one selected course still awaiting a pivot decision */
        $pending = Enrollment::whereHas(
            'courses',
            fn ($q) => $q->where('course_enrollment.status', Enrollment::PIVOT_PENDING)
        )->count();
        $approved          = Enrollment::where('status', 'approved')->count();
        $rejected          = Enrollment::where('status', 'rejected')->count();
        $totalCourses      = Course::where('is_active', true)->count();

        $approvalRate  = $totalEnrollments > 0 ? round($approved  / $totalEnrollments * 100) : 0;
        $rejectionRate = $totalEnrollments > 0 ? round($rejected  / $totalEnrollments * 100) : 0;

        $stats = compact(
            'totalEnrollments', 'enrollmentsToday', 'pending',
            'approved', 'rejected', 'approvalRate', 'rejectionRate', 'totalCourses'
        );

        // Map to the keys the view expects (snake_case)
        $stats = [
            'total_enrollments'  => $totalEnrollments,
            'enrollments_today'  => $enrollmentsToday,
            'pending'            => $pending,
            'approved'           => $approved,
            'rejected'           => $rejected,
            'approval_rate'      => $approvalRate,
            'rejection_rate'     => $rejectionRate,
            'total_courses'      => $totalCourses,
        ];

        /* ── Popular Courses ─────────────────────────────────── */
        $colors = ['green', 'blue', 'orange', 'red', 'purple'];
        $maxCount = 1;

        $popularCourses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get()
            ->map(function ($course, $i) use (&$maxCount, $colors) {
                if ($i === 0) {
                    $maxCount = max(1, $course->enrollments_count);
                }
                return [
                    'name'  => $course->title,
                    'count' => $course->enrollments_count,
                    'pct'   => round($course->enrollments_count / $maxCount * 100),
                    'color' => $colors[$i % count($colors)],
                ];
            });

        /* ── Recent Activity ─────────────────────────────────── */
        $recentActivity = Enrollment::withCount('courses')
            ->latest()
            ->take(8)
            ->get()
            ->map(fn ($e) => [
                'text'  => "<strong>{$e->full_name}</strong> submitted an application ({$e->courses_count} course(s))",
                'time'  => $e->created_at->diffForHumans(),
                'color' => match ($e->status) {
                    'approved' => 'green',
                    'rejected' => 'red',
                    'partial'  => 'blue',
                    default    => 'orange',
                },
            ]);

        /* ── Alerts ──────────────────────────────────────────── */
        $alerts = collect();

        if ($pending > 0) {
            $alerts->push([
                'type'    => 'warn',
                'message' => "{$pending} enrollment(s) have at least one course still pending review.",
            ]);
        }

        $recentApplications = Enrollment::with('courses')
            ->latest()
            ->paginate(10, ['*'], 'applications_page');

        return view('admin.dashboard.index', compact(
            'stats',
            'popularCourses',
            'recentActivity',
            'alerts',
            'recentApplications',
        ));
    }
}
