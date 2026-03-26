<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends AppController
{
    /**
     * GET /courses
     * Public listing — all active courses.
     */
    public function index()
    {
        $courses = Course::active()->get();

        return view('public.courses', compact('courses'));
    }
}
