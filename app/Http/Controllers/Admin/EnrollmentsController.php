<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'accepted');
        if (! in_array($tab, ['accepted', 'waitlisted', 'rejected'], true)) {
            $tab = 'accepted';
        }

        $query = Enrollment::with('courses')->latest();

        if ($tab === 'accepted') {
            $query->whereIn('status', ['approved', 'partial']);
        } elseif ($tab === 'waitlisted') {
            $query->where('status', 'waitlisted');
        } else {
            $query->where('status', 'rejected');
        }

        $enrollments = $query->paginate(20)->withQueryString();

        return view('admin.enrollments.index', compact('enrollments', 'tab'));
    }

    public function bulkExport(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:enrollments,id',
        ]);

        $enrollments = Enrollment::with('courses')
            ->whereIn('id', $validated['ids'])
            ->get();

        $filename = 'enrollments-export-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($enrollments): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID', 'Full Name', 'Email', 'Phone', 'NRC',
                'Status', 'Courses', 'Submitted At',
            ]);
            foreach ($enrollments as $e) {
                fputcsv($handle, [
                    $e->id,
                    $e->full_name,
                    $e->email,
                    $e->phone,
                    $e->nrc,
                    $e->status,
                    $e->courses->pluck('title')->implode('; '),
                    $e->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function destroy(Enrollment $enrollment)
    {
        DB::transaction(function () use ($enrollment): void {
            DB::table('course_enrollment')->where('enrollment_id', $enrollment->id)->delete();
            $enrollment->delete();
        });

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment for ' . $enrollment->full_name . ' has been deleted.');
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

        return redirect()->route('admin.enrollments.index')
            ->with('success', count($ids) . ' enrollment(s) permanently deleted.');
    }
}
