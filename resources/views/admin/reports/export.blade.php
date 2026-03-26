<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Enrollment Report — Digital Future Labs</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: Georgia, 'Times New Roman', serif;
      font-size: 13px;
      color: #1a1a1a;
      background: #fff;
      padding: 40px;
      max-width: 1000px;
      margin: 0 auto;
    }

    /* ── Header ── */
    .report-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding-bottom: 20px;
      border-bottom: 2px solid #1a1a1a;
      margin-bottom: 24px;
    }
    .report-title { font-size: 22px; font-weight: bold; letter-spacing: -.5px; }
    .report-meta  { font-size: 11px; color: #555; margin-top: 4px; }
    .report-org   { text-align: right; font-size: 11px; color: #555; }
    .report-org strong { font-size: 13px; color: #1a1a1a; display: block; margin-bottom: 2px; }

    /* ── Filters summary ── */
    .filter-summary {
      background: #f5f5f5;
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 10px 14px;
      margin-bottom: 20px;
      font-size: 11px;
      color: #444;
      display: flex;
      flex-wrap: wrap;
      gap: 6px 18px;
    }
    .filter-summary span strong { color: #1a1a1a; }

    /* ── Summary row ── */
    .summary-row {
      display: flex;
      gap: 0;
      border: 1px solid #ddd;
      border-radius: 4px;
      overflow: hidden;
      margin-bottom: 24px;
    }
    .summary-cell {
      flex: 1;
      padding: 12px 16px;
      border-right: 1px solid #ddd;
      text-align: center;
    }
    .summary-cell:last-child { border-right: none; }
    .summary-cell .num  { font-size: 22px; font-weight: bold; line-height: 1; }
    .summary-cell .lbl  { font-size: 10px; color: #666; margin-top: 3px; text-transform: uppercase; letter-spacing: .08em; }

    /* ── Table ── */
    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    thead th {
      background: #1a1a1a;
      color: #fff;
      padding: 8px 10px;
      text-align: left;
      font-size: 10px;
      letter-spacing: .08em;
      text-transform: uppercase;
      font-family: Arial, sans-serif;
    }
    tbody tr:nth-child(even) { background: #f9f9f9; }
    tbody td { padding: 8px 10px; border-bottom: 1px solid #eee; vertical-align: top; }
    tbody td .sub { color: #666; font-size: 11px; margin-top: 2px; }

    .badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 20px;
      font-size: 10px;
      font-family: Arial, sans-serif;
      font-weight: bold;
      letter-spacing: .05em;
      text-transform: uppercase;
    }
    .badge-pending  { background: #fff3cd; color: #856404; }
    .badge-approved { background: #d1fae5; color: #065f46; }
    .badge-partial  { background: #dbeafe; color: #1e40af; }
    .badge-rejected { background: #fee2e2; color: #991b1b; }

    /* ── Controls (hidden on print) ── */
    .print-controls {
      display: flex;
      gap: 10px;
      margin-bottom: 28px;
    }
    .print-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 18px;
      background: #1a1a1a;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 13px;
      cursor: pointer;
      font-family: Arial, sans-serif;
    }
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 18px;
      background: transparent;
      color: #1a1a1a;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 13px;
      text-decoration: none;
      font-family: Arial, sans-serif;
    }

    /* ── Print styles ── */
    @media print {
      body { padding: 20px; }
      .print-controls { display: none; }
      tbody tr { page-break-inside: avoid; }
    }
  </style>
</head>
<body>

  {{-- Controls --}}
  <div class="print-controls">
    <button class="print-btn" onclick="window.print()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
           style="width:14px;height:14px">
        <polyline points="6 9 6 2 18 2 18 9"/>
        <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
        <rect x="6" y="14" width="12" height="8"/>
      </svg>
      Print / Save PDF
    </button>
    <a href="{{ route('admin.reports.index', $filters) }}" class="back-link">← Back to Reports</a>
  </div>

  {{-- Header --}}
  <div class="report-header">
    <div>
      <div class="report-title">
        @if($courseLabel)
          {{ $courseLabel }}
        @else
          Enrollment Report
        @endif
      </div>
      @if($courseLabel)
        <div style="font-size:12px;color:#555;margin-top:2px">Accepted Students Report</div>
      @endif
      <div class="report-meta">
        Generated {{ now()->format('d M Y, H:i') }}
        · {{ $records->count() }} record{{ $records->count() !== 1 ? 's' : '' }}
      </div>
    </div>
    <div class="report-org">
      <strong>Digital Future Labs</strong>
      Enrollment Management System
    </div>
  </div>



  {{-- Table --}}
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Student</th>
        <th>Phone</th>
        @if($courseLabel)
          <th>Email</th>
        @else
          <th>Course(s)</th>
        @endif
        <th>NRC</th>
      </tr>
    </thead>
    <tbody>
      @forelse($records as $record)
        <tr>
          <td style="color:#999">{{ $record->id }}</td>
          <td>
            {{ $record->full_name }}
            @if(!$courseLabel)
              <div class="sub">{{ $record->email }}</div>
            @endif
          </td>
          <td>{{ $record->phone }}</td>
          @if($courseLabel)
            <td>{{ $record->email }}</td>
          @else
            <td>
              @foreach($record->courses as $course)
                {{ $course->title }}@if(!$loop->last), @endif
              @endforeach
            </td>
          @endif
          <td>{{ $record->nrc }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="5" style="text-align:center;padding:24px;color:#999">
            No records match the selected filters.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

</body>
</html>
