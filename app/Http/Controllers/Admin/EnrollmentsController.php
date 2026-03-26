<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'accepted');
        if (! in_array($tab, ['accepted', 'rejected'], true)) {
            $tab = 'accepted';
        }

        $query = Enrollment::with('courses')->latest();

        if ($tab === 'accepted') {
            $query->whereIn('status', ['approved', 'partial']);
        } else {
            $query->where('status', 'rejected');
        }

        $enrollments = $query->paginate(20)->withQueryString();

        return view('admin.enrollments.index', compact('enrollments', 'tab'));
    }
}
