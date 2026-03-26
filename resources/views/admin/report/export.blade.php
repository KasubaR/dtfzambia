{{--
  Print-Friendly Export View
  Rendered server-side for PDF/Print output.
  Used by: GET /admin/reports/export?format=print
--}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DFL Enrolment Report — {{ now()->format('d M Y') }}</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: Georgia, 'Times New Roman', serif;
      font-size: 12px;
      color: #111;
      background: #fff;
      padding: 32px 40px;
    }

    /* Header */
    .report-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      border-bottom: 2px solid #111;
      padding-bottom: 14px;
      margin-bottom: 20px;
    }
    .report-logo {
      font-family: Arial Black, Arial, sans-serif;
      font-size: 18px;
      font-weight: 900;
      letter-spacing: -.02em;
    }
    .report-logo span { color: #16a34a; }
    .report-meta { text-align: right; font-size: 11px; color: #555; line-height: 1.6; }

    /* Filters applied */
    .filters-applied {
      background: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 4px;
      padding: 10px 14px;
      margin-bottom: 16px;
      font-size: 11px;
      color: #555;
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
    }
    .filters-applied strong { color: #111; }

    /* Summary */
    .summary-row {
      display: flex;
      gap: 0;
      border: 1px solid #e5e7eb;
      border-radius: 4px;
      overflow: hidden;
      margin-bottom: 20px;
    }
    .summary-cell {
      flex: 1;
      padding: 12px 16px;
      border-right: 1px solid #e5e7eb;
      text-align: center;
    }
    .summary-cell:last-child { border-right: none; }
    .summary-cell .val { font-size: 20px; font-weight: 700; font-family: Arial, sans-serif; }
    .summary-cell .lbl { font-size: 10px; color: #888; text-transform: uppercase; letter-spacing: .06em; margin-top: 3px; }
    .summary-cell.green .val { color: #15803d; }
    .summary-cell.orange .val { color: #b45309; }
    .summary-cell.red .val { color: #dc2626; }

    /* Table */
    table { width: 100%; border-collapse: collapse; font-size: 11.5px; }
    thead th {
      background: #f3f4f6;
      padding: 9px 10px;
      text-align: left;
      font-family: Arial, sans-serif;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      border-bottom: 2px solid #d1d5db;
      color: #374151;
    }
    tbody tr { border-bottom: 1px solid #e5e7eb; }
    tbody tr:nth-child(even) { background: #f9fafb; }
    tbody tr:last-child { border-bottom: none; }
    tbody td { padding: 9px 10px; vertical-align: top; color: #1f2937; }
    .td-name { font-weight: 700; font-family: Arial, sans-serif; }
    .td-sub  { font-size: 10px; color: #9ca3af; margin-top: 2px; }

    /* Badges */
    .badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 12px;
      font-size: 10px;
      font-weight: 700;
      font-family: Arial, sans-serif;
      text-transform: uppercase;
      letter-spacing: .04em;
    }
    .badge-approved { background: #dcfce7; color: #15803d; }
    .badge-pending  { background: #fef9c3; color: #a16207; }
    .badge-rejected { background: #fee2e2; color: #dc2626; }

    /* Course chips */
    .chip {
      display: inline-block;
      background: #f3f4f6;
      border: 1px solid #e5e7eb;
      padding: 1px 7px;
      border-radius: 3px;
      font-size: 10px;
      margin: 1px 1px 0 0;
    }

    /* Footer */
    .report-footer {
      margin-top: 24px;
      padding-top: 12px;
      border-top: 1px solid #e5e7eb;
      font-size: 10px;
      color: #9ca3af;
      display: flex;
      justify-content: space-between;
    }

    /* Print controls (screen only) */
    .print-controls {
      position: fixed;
      top: 20px;
      right: 20px;
      display: flex;
      gap: 8px;
      z-index: 100;
    }
    .print-btn {
      padding: 9px 18px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      border: 2px solid;
      font-family: Arial, sans-serif;
    }
    .print-btn.primary {
      background: #111;
      color: #fff;
      border-color: #111;
    }
    .print-btn.secondary {
      background: #fff;
      color: #374151;
      border-color: #d1d5db;
    }

    @media print {
      .print-controls { display: none !important; }
      body { padding: 16px; }
      @page { margin: 16mm; }
    }
  </style>
</head>
<body>

  {{-- Print controls (screen only) --}}
  <div class="print-controls">
    <button class="print-btn secondary" onclick="window.close()">✕ Close</button>
    <button class="print-btn primary" onclick="window.print()">🖨 Print / Save PDF</button>
  </div>

  {{-- Report Header --}}
  <div class="report-header">
    <div>
      <div class="report-logo">Digital<span>Future</span>Labs</div>
      <div style="font-size:11px;color:#555;margin-top:3px">
        Enrolment Report
      </div>
    </div>
    <div class="report-meta">
      Generated: {{ now()->format('d M Y, H:i') }}<br>
      Generated by: {{ auth()->user()->name ?? 'Administrator' }}<br>
      @if(request()->hasAny(['course_id','status','date_from','date_to']))
        Filtered view
      @else
        All records
      @endif
    </div>
  </div>

  {{-- Applied Filters --}}
  @if(request()->hasAny(['course_id','status','date_from','date_to','search']))
    <div class="filters-applied">
      <strong>Filters applied:</strong>
      @if(request('course_id'))
        Course: <strong>{{ $courses->find(request('course_id'))?->title ?? '—' }}</strong>
      @endif
      @if(request('status'))
        Status: <strong>{{ ucfirst(request('status')) }}</strong>
      @endif
      @if(request('date_from'))
        From: <strong>{{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}</strong>
      @endif
      @if(request('date_to'))
        To: <strong>{{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}</strong>
      @endif
      @if(request('search'))
        Search: <strong>"{{ request('search') }}"</strong>
      @endif
    </div>
  @endif

  {{-- Summary --}}
  <div class="summary-row">
    <div class="summary-cell">
      <div class="val">{{ $summary['total'] }}</div>
      <div class="lbl">Total</div>
    </div>
    <div class="summary-cell orange">
      <div class="val">{{ $summary['pending'] }}</div>
      <div class="lbl">Pending</div>
    </div>
    <div class="summary-cell green">
      <div class="val">{{ $summary['approved'] }}</div>
      <div class="lbl">Approved</div>
    </div>
    <div class="summary-cell red">
      <div class="val">{{ $summary['rejected'] }}</div>
      <div class="lbl">Rejected</div>
    </div>
    <div class="summary-cell">
      <div class="val">K{{ number_format($summary['revenue']) }}</div>
      <div class="lbl">Revenue</div>
    </div>
  </div>

  {{-- Data Table --}}
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Full Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Course(s)</th>
        <th>Status</th>
        <th>Date Applied</th>
      </tr>
    </thead>
    <tbody>
      @forelse($records as $record)
        <tr>
          <td style="color:#9ca3af">{{ $loop->iteration }}</td>
          <td>
            <div class="td-name">{{ $record->full_name }}</div>
          </td>
          <td>{{ $record->phone }}</td>
          <td style="color:#6b7280">{{ $record->email }}</td>
          <td>
            @foreach($record->courses as $c)
              <span class="chip">{{ $c->name }}</span>
            @endforeach
          </td>
          <td>
            @php
              $badgeMap = [
                'pending'  => 'badge-pending',
                'approved' => 'badge-approved',
                'rejected' => 'badge-rejected',
              ];
            @endphp
            <span class="badge {{ $badgeMap[$record->status] ?? 'badge-pending' }}">
              {{ ucfirst($record->status) }}
            </span>
          </td>
          <td>{{ $record->created_at->format('d M Y') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="7" style="text-align:center;padding:24px;color:#9ca3af">
            No records match the selected filters.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{-- Footer --}}
  <div class="report-footer">
    <span>Digital Future Labs Admin Panel — Confidential</span>
    <span>Total: {{ $records->count() }} record{{ $records->count() !== 1 ? 's' : '' }} on this page</span>
  </div>

</body>
</html>
