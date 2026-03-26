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
      <div class="report-title">Enrollment Report</div>
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

  {{-- Active filters summary --}}
  @if(collect($filters)->filter()->isNotEmpty())
    <div class="filter-summary">
      <span>Filters applied:</span>
      @if($courseLabel)
        <span><strong>Course:</strong> {{ $courseLabel }}</span>
      @endif
      @if(!empty($filters['status']))
        <span><strong>Status:</strong> {{ ucfirst($filters['status']) }}</span>
      @endif
      @if(!empty($filters['date_from']))
        <span><strong>From:</strong> {{ \Carbon\Carbon::parse($filters['date_from'])->format('d M Y') }}</span>
      @endif
      @if(!empty($filters['date_to']))
        <span><strong>To:</strong> {{ \Carbon\Carbon::parse($filters['date_to'])->format('d M Y') }}</span>
      @endif
      @if(!empty($filters['search']))
        <span><strong>Search:</strong> "{{ $filters['search'] }}"</span>
      @endif
    </div>
  @endif

  {{-- Summary counts --}}
  @php
    $pending  = $records->where('status', 'pending')->count();
    $approved = $records->whereIn('status', ['approved', 'partial'])->count();
    $rejected = $records->where('status', 'rejected')->count();
  @endphp
  <div class="summary-row">
    <div class="summary-cell">
      <div class="num">{{ $records->count() }}</div>
      <div class="lbl">Total</div>
    </div>
    <div class="summary-cell">
      <div class="num">{{ $pending }}</div>
      <div class="lbl">Pending</div>
    </div>
    <div class="summary-cell">
      <div class="num">{{ $approved }}</div>
      <div class="lbl">Accepted</div>
    </div>
    <div class="summary-cell">
      <div class="num">{{ $rejected }}</div>
      <div class="lbl">Rejected</div>
    </div>
  </div>

  {{-- Table --}}
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Student</th>
        <th>Phone</th>
        <th>Location</th>
        <th>Course(s)</th>
        <th>Status</th>
        <th>Submitted</th>
      </tr>
    </thead>
    <tbody>
      @forelse($records as $record)
        <tr>
          <td style="color:#999">{{ $record->id }}</td>
          <td>
            {{ $record->full_name }}
            <div class="sub">{{ $record->email }}</div>
          </td>
          <td>{{ $record->phone }}</td>
          <td>{{ $record->location }}</td>
          <td>
            @foreach($record->courses as $course)
              {{ $course->title }}@if(!$loop->last), @endif
            @endforeach
          </td>
          <td>
            @php
              $badgeMap = [
                'pending'  => 'badge-pending',
                'approved' => 'badge-approved',
                'partial'  => 'badge-partial',
                'rejected' => 'badge-rejected',
              ];
              $badgeClass = $badgeMap[$record->status] ?? 'badge-pending';
            @endphp
            <span class="badge {{ $badgeClass }}">{{ ucfirst($record->status) }}</span>
          </td>
          <td style="white-space:nowrap">{{ $record->created_at->format('d M Y') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="7" style="text-align:center;padding:24px;color:#999">
            No records match the selected filters.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

</body>
</html>
