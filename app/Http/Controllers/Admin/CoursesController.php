<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('enrollments')->latest()->paginate(20);

        $totalCourses  = Course::count();
        $hybridCount   = Course::where('mode', 'hybrid')->count();
        $avgPrice      = Course::avg('price') ?? 0;
        $totalEnrolled = Course::withCount('enrollments')->get()->sum('enrollments_count');
        $maxEnrolled   = Course::withCount('enrollments')->get()->max('enrollments_count') ?: 1;

        return view('admin.courses.index', compact(
            'courses', 'totalCourses', 'hybridCount', 'avgPrice', 'totalEnrolled', 'maxEnrolled'
        ));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'duration'    => 'required|string|max:100',
            'mode'        => 'required|in:hybrid,online,physical',
            'price'       => 'required|numeric|min:0',
        ]);

        Course::create(array_merge($data, ['is_active' => true]));

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $course->loadCount('enrollments');

        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'duration'    => 'required|string|max:100',
            'mode'        => 'required|in:hybrid,online,physical',
            'price'       => 'required|numeric|min:0',
        ]);

        $course->update($data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted.');
    }
}
