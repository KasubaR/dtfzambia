<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer as XlsxWriter;

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
            'total'      => Enrollment::count(),
            'pending'    => Enrollment::where('status', 'pending')->count(),
            'approved'   => Enrollment::whereIn('status', ['approved', 'partial'])->count(),
            'waitlisted' => Enrollment::where('status', 'waitlisted')->count(),
            'rejected'   => Enrollment::where('status', 'rejected')->count(),
            'revenue'    => Enrollment::whereIn('status', ['approved', 'partial'])->sum('total_price'),
        ];

        return view('admin.reports.index', compact('records', 'courses', 'summary'));
    }

    public function export(Request $request)
    {
        $courses = Course::orderBy('title')->get();
        $format = strtolower((string) $request->query('format', 'print'));

        $isWaitlist = $request->query('status') === 'waitlisted';

        if ($isWaitlist) {
            $pivotStatus    = 'waitlisted';
            $enrollStatuses = ['waitlisted'];
        } else {
            $pivotStatus    = 'accepted';
            $enrollStatuses = ['approved', 'partial'];
        }

        $records = Enrollment::with(['courses' => fn ($q) => $q->wherePivot('status', $pivotStatus)])
            ->whereIn('status', $enrollStatuses)
            ->when($request->course_id, fn ($q) => $q->whereHas('courses', fn ($q) => $q->where('courses.id', $request->course_id)->where('course_enrollment.status', $pivotStatus)))
            ->when($request->date_from, fn ($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to,   fn ($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->when($request->search,    fn ($q) => $q->where('full_name', 'like', '%' . $request->search . '%'))
            ->oldest()
            ->get();

        $filters = $request->only(['course_id', 'status', 'date_from', 'date_to', 'search']);
        $courseLabel = $request->filled('course_id')
            ? $courses->firstWhere('id', $request->course_id)?->title
            : null;

        if ($format === 'excel') {
            return $this->downloadXlsxExport(
                $records,
                $courseLabel,
                $isWaitlist,
                'xlsx'
            );
        }

        if ($format === 'word') {
            return $this->downloadHtmlExport(
                $records,
                $courseLabel,
                $isWaitlist,
                'application/msword',
                'doc'
            );
        }

        return view('admin.reports.export', compact('records', 'filters', 'courseLabel', 'isWaitlist'));
    }

    private function downloadHtmlExport($records, ?string $courseLabel, bool $isWaitlist, string $contentType, string $extension)
    {
        $title = $courseLabel
            ? ($isWaitlist ? $courseLabel . ' - Waiting List Report' : $courseLabel . ' - Accepted Students Report')
            : ($isWaitlist ? 'Waiting List Report' : 'Enrollment Report');

        $rows = '';
        foreach ($records as $record) {
            $courseTitles = $record->courses
                ->pluck('title')
                ->filter()
                ->implode(', ');

            $rows .= '<tr>'
                . '<td>' . e((string) $record->id) . '</td>'
                . '<td>' . e((string) $record->full_name) . '</td>'
                . '<td>' . e((string) $record->phone) . '</td>'
                . '<td>' . e((string) $record->email) . '</td>'
                . '<td>' . e($courseTitles) . '</td>'
                . '<td>' . e((string) $record->nrc) . '</td>'
                . '</tr>';
        }

        if ($rows === '') {
            $rows = '<tr><td colspan="6">No records match the selected filters.</td></tr>';
        }

        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>' . e($title) . '</title>'
            . '<style>body{font-family:Arial,sans-serif;font-size:12px}h2{margin-bottom:6px}p{margin:0 0 12px;color:#555}'
            . 'table{width:100%;border-collapse:collapse}th,td{border:1px solid #d1d5db;padding:7px;text-align:left}'
            . 'th{background:#f3f4f6;font-weight:700}td{vertical-align:top}</style></head><body>'
            . '<h2>' . e($title) . '</h2>'
            . '<p>Generated: ' . e(now()->format('d M Y, H:i')) . '</p>'
            . '<table><thead><tr><th>No</th><th>Student</th><th>Phone</th><th>Email</th><th>Course(s)</th><th>NRC</th></tr></thead><tbody>'
            . $rows
            . '</tbody></table></body></html>';

        $filename = Str::slug($title) . '-' . now()->format('Ymd-Hi') . '.' . $extension;

        return response($html, 200, [
            'Content-Type' => $contentType . '; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function downloadXlsxExport($records, ?string $courseLabel, bool $isWaitlist, string $extension)
    {
        $title = $courseLabel
            ? ($isWaitlist ? $courseLabel . ' - Waiting List Report' : $courseLabel . ' - Accepted Students Report')
            : ($isWaitlist ? 'Waiting List Report' : 'Enrollment Report');

        $filename = Str::slug($title) . '-' . now()->format('Ymd-Hi') . '.' . $extension;
        $tempPath = storage_path('app/tmp-' . Str::uuid() . '.xlsx');

        $writer = new XlsxWriter();
        $writer->openToFile($tempPath);
        $writer->addRow(Row::fromValues(['No', 'Student', 'Phone', 'Email', 'Course(s)', 'NRC']));

        foreach ($records as $record) {
            $courseTitles = $record->courses
                ->pluck('title')
                ->filter()
                ->implode(', ');

            $writer->addRow(Row::fromValues([
                (string) $record->id,
                (string) $record->full_name,
                (string) $record->phone,
                (string) $record->email,
                $courseTitles,
                (string) $record->nrc,
            ]));
        }

        $writer->close();

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }
}
