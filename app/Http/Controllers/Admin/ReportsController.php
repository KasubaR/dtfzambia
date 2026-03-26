<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::orderBy('title')->get();

        $records = Enrollment::with('courses')
            ->when($request->course_id, fn ($q) => $q->whereHas('courses', fn ($q) => $q->where('id', $request->course_id)))
            ->when($request->status,    fn ($q) => $q->where('status', $request->status))
            ->when($request->date_from, fn ($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to,   fn ($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->when($request->search,    fn ($q) => $q->where('full_name', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $summary = [
            'total'    => Enrollment::count(),
            'pending'  => Enrollment::where('status', 'pending')->count(),
            'approved' => Enrollment::whereIn('status', ['approved', 'partial'])->count(),
            'rejected' => Enrollment::where('status', 'rejected')->count(),
            'revenue'  => Enrollment::whereIn('status', ['approved', 'partial'])->sum('total_price'),
        ];

        return view('admin.reports.index', compact('records', 'courses', 'summary'));
    }

    public function export(Request $request)
    {
        $courses = Course::orderBy('title')->get();

        $records = Enrollment::with(['courses' => fn ($q) => $q->wherePivot('status', 'accepted')])
            ->whereIn('status', ['approved', 'partial'])
            ->when($request->course_id, fn ($q) => $q->whereHas('courses', fn ($q) => $q->where('courses.id', $request->course_id)->where('course_enrollment.status', 'accepted')))
            ->when($request->date_from, fn ($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to,   fn ($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->when($request->search,    fn ($q) => $q->where('full_name', 'like', '%' . $request->search . '%'))
            ->oldest()
            ->get();

        $filters = $request->only(['course_id', 'status', 'date_from', 'date_to', 'search']);
        $courseLabel = $request->filled('course_id')
            ? $courses->firstWhere('id', $request->course_id)?->title
            : null;

        return view('admin.reports.export', compact('records', 'filters', 'courseLabel'));
    }
}
