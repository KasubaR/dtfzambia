@extends('admin.layouts.app')

@section('title', 'Reports & Export')
@section('page-title', 'Reports')

@section('content')

{{-- ── Page Header ─────────────────────────────────────────── --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;
            gap:16px;margin-bottom:24px" class="animate-in">
  <div>
    <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;line-height:1">
      Reports & Export
    </h2>
    <p style="color:var(--text-muted);font-size:.83rem;margin-top:4px">
      Filter, analyse, and export enrolment data
    </p>
  </div>

  {{-- Quick export buttons --}}
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <button class="btn btn-outline btn-sm export-btn"
            data-format="csv"
            data-export-url="{{ route('admin.reports.export') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
      </svg>
      CSV
    </button>
    <button class="btn btn-outline btn-sm export-btn"
            data-format="excel"
            data-export-url="{{ route('admin.reports.export') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="18" height="18" rx="2"/>
        <path d="M3 9h18M9 21V9"/>
      </svg>
      Excel
    </button>
    <button class="btn btn-outline btn-sm export-btn"
            data-format="pdf"
            data-export-url="{{ route('admin.reports.export') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
      </svg>
      PDF
    </button>
    <button class="btn btn-primary btn-sm" id="printBtn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="6 9 6 2 18 2 18 9"/>
        <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
        <rect x="6" y="14" width="12" height="8"/>
      </svg>
      Print
    </button>
  </div>
</div>

{{-- ── Summary Cards ───────────────────────────────────────── --}}
<div class="stats-grid" style="margin-bottom:22px">
  <div class="stat-card animate-in delay-1" style="padding:18px">
    <div class="stat-icon green" style="margin-bottom:12px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
      </svg>
    </div>
    <div class="stat-value" data-count="{{ $summary['total'] }}">0</div>
    <div class="stat-label">Total Records</div>
  </div>
  <div class="stat-card animate-in delay-2" style="padding:18px">
    <div class="stat-icon orange" style="margin-bottom:12px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/>
        <path d="M12 8v4m0 4h.01"/>
      </svg>
    </div>
    <div class="stat-value" data-count="{{ $summary['pending'] }}">0</div>
    <div class="stat-label">Pending</div>
  </div>
  <div class="stat-card animate-in delay-3" style="padding:18px">
    <div class="stat-icon green" style="margin-bottom:12px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
        <polyline points="22 4 12 14.01 9 11.01"/>
      </svg>
    </div>
    <div class="stat-value" data-count="{{ $summary['approved'] }}">0</div>
    <div class="stat-label">Approved</div>
  </div>
  <div class="stat-card animate-in delay-4" style="padding:18px">
    <div class="stat-icon red" style="margin-bottom:12px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/>
        <path d="M15 9l-6 6M9 9l6 6"/>
      </svg>
    </div>
    <div class="stat-value" data-count="{{ $summary['rejected'] }}">0</div>
    <div class="stat-label">Rejected</div>
  </div>
  <div class="stat-card animate-in delay-5" style="padding:18px">
    <div class="stat-icon blue" style="margin-bottom:12px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="1" x2="12" y2="23"/>
        <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
      </svg>
    </div>
    <div class="stat-value" style="font-size:1.5rem">
      K{{ number_format($summary['revenue']) }}
    </div>
    <div class="stat-label">Total Revenue</div>
  </div>
</div>

{{-- ── Filter Panel ─────────────────────────────────────────── --}}
<div class="panel animate-in delay-1" style="margin-bottom:20px">
  <div class="panel-header">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:17px;height:17px;color:var(--accent)">
      <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
    </svg>
    <span class="panel-title">Filter & Search</span>
    <button class="btn btn-outline btn-sm" id="clearFilters">Clear Filters</button>
  </div>
  <div class="panel-body">
    <form method="GET" action="{{ route('admin.reports.index') }}" id="filterForm">

      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px">

        {{-- Course --}}
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label" for="course_id">Course</label>
          <select name="course_id" id="course_id" class="form-control">
            <option value="">All Courses</option>
            @foreach($courses as $course)
              <option value="{{ $course->id }}"
                {{ request('course_id') == $course->id ? 'selected' : '' }}>
                {{ $course->title }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Status --}}
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label" for="status">Status</label>
          <select name="status" id="status" class="form-control">
            <option value="">All Statuses</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
          </select>
        </div>

        {{-- Date From --}}
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label" for="date_from">Date From</label>
          <input type="date"
                 name="date_from"
                 id="date_from"
                 class="form-control"
                 value="{{ request('date_from') }}">
        </div>

        {{-- Date To --}}
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label" for="date_to">Date To</label>
          <input type="date"
                 name="date_to"
                 id="date_to"
                 class="form-control"
                 value="{{ request('date_to') }}">
        </div>

        {{-- Search --}}
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label" for="search">Search</label>
          <input type="text"
                 name="search"
                 id="search"
                 class="form-control"
                 placeholder="Name, phone, email…"
                 value="{{ request('search') }}">
        </div>

      </div>

      <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:18px">
        <button type="submit" class="btn btn-primary btn-sm">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
          </svg>
          Apply Filters
        </button>
      </div>

    </form>
  </div>
</div>

{{-- ── Results Table ────────────────────────────────────────── --}}
<div class="panel animate-in delay-2" id="reportPanel">

  <div class="panel-header">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:17px;height:17px;color:var(--accent)">
      <path d="M9 17H7A5 5 0 017 7h10a5 5 0 014.9 6"/>
      <path d="M13 21l3-3-3-3"/><path d="M16 18H9"/>
    </svg>
    <span class="panel-title">
      Results
      <span style="font-size:.78rem;font-weight:500;color:var(--text-muted);margin-left:6px">
        {{ $records->total() }} record{{ $records->total() !== 1 ? 's' : '' }}
        @if(request()->hasAny(['course_id','status','date_from','date_to','search']))
          <span style="color:var(--warn)">(filtered)</span>
        @endif
      </span>
    </span>

    {{-- Inline export strip --}}
    <div style="display:flex;gap:6px;margin-left:auto">
      @foreach([
        ['csv',   'CSV',   '#4fffb0'],
        ['excel', 'Excel', '#4f9fff'],
        ['pdf',   'PDF',   '#ff4f6d'],
      ] as [$fmt, $lbl, $clr])
        <button class="btn btn-sm export-btn"
                data-format="{{ $fmt }}"
                data-export-url="{{ route('admin.reports.export') }}"
                style="border-color:{{ $clr }}33;color:{{ $clr }};
                       background:{{ $clr }}14">
          {{ $lbl }}
        </button>
      @endforeach
      <button class="btn btn-sm btn-outline" id="printBtn2">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="6 9 6 2 18 2 18 9"/>
          <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
          <rect x="6" y="14" width="12" height="8"/>
        </svg>
        Print
      </button>
    </div>
  </div>

  <div class="table-wrap" id="printArea">
    <table class="admin-table" id="reportTable">
      <thead>
        <tr>
          <th>#</th>
          <th>Full Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Course(s)</th>
          <th>Mode</th>
          <th>Status</th>
          <th>Date Applied</th>
        </tr>
      </thead>
      <tbody>
        @forelse($records as $record)
          <tr>
            <td style="color:var(--text-muted);font-size:.78rem">{{ $record->id }}</td>
            <td>
              <div class="td-name">{{ $record->full_name }}</div>
            </td>
            <td style="font-size:.83rem">{{ $record->phone }}</td>
            <td style="font-size:.8rem;color:var(--text-muted)">{{ $record->email }}</td>
            <td>
              @foreach($record->courses as $c)
                <span style="display:inline-block;font-size:.73rem;background:var(--surface-3);
                             padding:2px 8px;border-radius:4px;margin:2px 2px 0 0;white-space:nowrap">
                  {{ $c->name }}
                </span>
              @endforeach
            </td>
            <td>
              @php
                $modeColors = ['hybrid'=>'#4f9fff','online'=>'#4fffb0','physical'=>'#ffb74f'];
                $mc = $modeColors[$record->courses->first()?->mode ?? ''] ?? 'var(--text-muted)';
              @endphp
              <span style="font-size:.78rem;font-weight:600;color:{{ $mc }}">
                {{ ucfirst($record->courses->first()?->mode ?? '—') }}
              </span>
            </td>
            <td>
              @include('admin.applications.partials.status-badge', ['status' => $record->status])
            </td>
            <td style="font-size:.8rem;color:var(--text-muted);white-space:nowrap">
              {{ $record->created_at->format('d M Y') }}<br>
              <span style="font-size:.72rem;opacity:.7">
                {{ $record->created_at->format('H:i') }}
              </span>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8">
              <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <h3>No records found</h3>
                <p>Try adjusting your filters above.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination (preserves filters) --}}
  @if($records->hasPages())
    <div class="pagination">
      @if($records->onFirstPage())
        <button class="page-btn" disabled style="opacity:.4">‹</button>
      @else
        <a href="{{ $records->previousPageUrl() }}" class="page-btn">‹</a>
      @endif

      @foreach($records->getUrlRange(1, $records->lastPage()) as $page => $url)
        <a href="{{ $url }}" class="page-btn {{ $records->currentPage() === $page ? 'active' : '' }}">
          {{ $page }}
        </a>
      @endforeach

      @if($records->hasMorePages())
        <a href="{{ $records->nextPageUrl() }}" class="page-btn">›</a>
      @else
        <button class="page-btn" disabled style="opacity:.4">›</button>
      @endif

      <div class="pagination-info">
        Showing {{ $records->firstItem() }}–{{ $records->lastItem() }}
        of {{ $records->total() }}
      </div>
    </div>
  @endif

</div>{{-- /.panel --}}

@endsection

@push('scripts')
<script>
/* ── Export buttons ─────────────────────────────────────────── */
document.querySelectorAll('.export-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const format = btn.dataset.format;
    const base   = btn.dataset.exportUrl;

    // Pass current filter params too
    const form   = document.getElementById('filterForm');
    const params = new URLSearchParams(new FormData(form));
    params.set('format', format);

    // Trigger download
    const a = document.createElement('a');
    a.href = `${base}?${params.toString()}`;
    a.download = '';
    document.body.appendChild(a);
    a.click();
    a.remove();

    showToast('info', 'Export started',
      `Your ${format.toUpperCase()} is being prepared…`);
  });
});

/* ── Print ──────────────────────────────────────────────────── */
['printBtn', 'printBtn2'].forEach(id => {
  document.getElementById(id)?.addEventListener('click', () => {
    window.print();
  });
});

/* ── Clear filters ──────────────────────────────────────────── */
document.getElementById('clearFilters')?.addEventListener('click', () => {
  window.location.href = '{{ route("admin.reports.index") }}';
});

/* ── Date range guard ───────────────────────────────────────── */
document.getElementById('date_from')?.addEventListener('change', function() {
  document.getElementById('date_to').min = this.value;
});
document.getElementById('date_to')?.addEventListener('change', function() {
  document.getElementById('date_from').max = this.value;
});
</script>
@endpush

@push('styles')
<style>
/* ── Print stylesheet ─────────────────────────────────────── */
@media print {
  .admin-sidebar,
  .admin-topbar,
  .panel-header .btn,
  #filterForm,
  .pagination,
  .alerts-strip,
  .stats-grid,
  [id^="printBtn"] { display: none !important; }

  body, .admin-main { background: #fff !important; color: #000 !important; }
  .admin-main { margin: 0 !important; }
  .panel { border: none !important; box-shadow: none !important; }

  .admin-table thead th { background: #f5f5f5 !important; color: #333 !important; }
  .admin-table tbody tr { border-color: #ddd !important; }
  .admin-table tbody td { color: #222 !important; }

  .badge-approved { background: #dcfce7 !important; color: #166534 !important; }
  .badge-pending  { background: #fef9c3 !important; color: #854d0e !important; }
  .badge-rejected { background: #fee2e2 !important; color: #991b1b !important; }

  #printArea { display: block !important; }
}
</style>
@endpush
