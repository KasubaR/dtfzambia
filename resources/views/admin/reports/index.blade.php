@extends('admin.layouts.app')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')

{{-- ── Stat Cards ──────────────────────────────────────────── --}}
<div class="stats-grid" style="grid-template-columns:repeat(auto-fill,minmax(160px,1fr));margin-bottom:22px">
  <div class="stat-card animate-in delay-1" style="padding:16px">
    <div class="stat-icon blue" style="width:32px;height:32px;margin-bottom:10px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
      </svg>
    </div>
    <div class="stat-value" style="font-size:1.5rem" data-count="{{ $summary['total'] }}">0</div>
    <div class="stat-label">Total Submissions</div>
  </div>
  <div class="stat-card animate-in delay-2" style="padding:16px">
    <div class="stat-icon orange" style="width:32px;height:32px;margin-bottom:10px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
      </svg>
    </div>
    <div class="stat-value" style="font-size:1.5rem" data-count="{{ $summary['pending'] }}">0</div>
    <div class="stat-label">Pending</div>
  </div>
  <div class="stat-card animate-in delay-3" style="padding:16px">
    <div class="stat-icon green" style="width:32px;height:32px;margin-bottom:10px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
        <polyline points="22 4 12 14.01 9 11.01"/>
      </svg>
    </div>
    <div class="stat-value" style="font-size:1.5rem" data-count="{{ $summary['approved'] }}">0</div>
    <div class="stat-label">Accepted</div>
  </div>
  <div class="stat-card animate-in delay-4" style="padding:16px">
    <div class="stat-icon red" style="width:32px;height:32px;margin-bottom:10px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/>
        <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
      </svg>
    </div>
    <div class="stat-value" style="font-size:1.5rem" data-count="{{ $summary['rejected'] }}">0</div>
    <div class="stat-label">Rejected</div>
  </div>
  <div class="stat-card animate-in delay-4" style="padding:16px">
    <div class="stat-icon purple" style="width:32px;height:32px;margin-bottom:10px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="1" x2="12" y2="23"/>
        <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
      </svg>
    </div>
    <div class="stat-value" style="font-size:1.2rem">K{{ number_format($summary['revenue']) }}</div>
    <div class="stat-label">Revenue</div>
  </div>
</div>

{{-- ── Print by Course ─────────────────────────────────────── --}}
<div class="panel animate-in delay-1" style="margin-bottom:22px">
  <div class="panel-header">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:17px;height:17px;color:var(--accent)">
      <polyline points="6 9 6 2 18 2 18 9"/>
      <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
      <rect x="6" y="14" width="12" height="8"/>
    </svg>
    <span class="panel-title">Print Students by Course</span>
  </div>
  <div style="padding:16px 20px;display:flex;flex-wrap:wrap;gap:10px">
    @foreach($courses as $course)
      <a href="{{ route('admin.reports.export', ['course_id' => $course->id]) }}"
         target="_blank"
         class="btn btn-outline btn-sm">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px">
          <polyline points="6 9 6 2 18 2 18 9"/>
          <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
          <rect x="6" y="14" width="12" height="8"/>
        </svg>
        {{ $course->title }}
      </a>
    @endforeach
  </div>
</div>

{{-- ── Main Panel ──────────────────────────────────────────── --}}
<div class="panel animate-in delay-2">

  <div class="panel-header">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:17px;height:17px;color:var(--accent)">
      <line x1="18" y1="20" x2="18" y2="10"/>
      <line x1="12" y1="20" x2="12" y2="4"/>
      <line x1="6"  y1="20" x2="6"  y2="14"/>
    </svg>
    <span class="panel-title">Enrollment Report</span>

    {{-- Export button --}}
    <div style="margin-left:auto;display:flex;gap:8px">
      <a href="{{ route('admin.reports.export', request()->query()) }}"
         target="_blank"
         class="btn btn-outline btn-sm">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
          <polyline points="7 10 12 15 17 10"/>
          <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Export / Print
      </a>
    </div>
  </div>

  {{-- Filters --}}
  <form method="GET" action="{{ route('admin.reports.index') }}"
        style="padding:16px 20px;border-bottom:1px solid var(--border);
               display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end">

    <div style="display:flex;flex-direction:column;gap:5px;min-width:160px;flex:1">
      <label style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                    letter-spacing:.08em;color:var(--text-faint)">Course</label>
      <select name="course_id" class="filter-select">
        <option value="">All Courses</option>
        @foreach($courses as $course)
          <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
            {{ $course->title }}
          </option>
        @endforeach
      </select>
    </div>

    <div style="display:flex;flex-direction:column;gap:5px;min-width:130px">
      <label style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                    letter-spacing:.08em;color:var(--text-faint)">Status</label>
      <select name="status" class="filter-select">
        <option value="">All Statuses</option>
        <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="partial"  {{ request('status') === 'partial'  ? 'selected' : '' }}>Partial</option>
        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
      </select>
    </div>

    <div style="display:flex;flex-direction:column;gap:5px;min-width:130px">
      <label style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                    letter-spacing:.08em;color:var(--text-faint)">Date From</label>
      <input type="date" name="date_from" class="filter-input"
             value="{{ request('date_from') }}">
    </div>

    <div style="display:flex;flex-direction:column;gap:5px;min-width:130px">
      <label style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                    letter-spacing:.08em;color:var(--text-faint)">Date To</label>
      <input type="date" name="date_to" class="filter-input"
             value="{{ request('date_to') }}">
    </div>

    <div style="display:flex;flex-direction:column;gap:5px;flex:2;min-width:160px">
      <label style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                    letter-spacing:.08em;color:var(--text-faint)">Search</label>
      <input type="text" name="search" class="filter-input"
             placeholder="Name, email, phone…"
             value="{{ request('search') }}">
    </div>

    <div style="display:flex;gap:8px;padding-bottom:1px">
      <button type="submit" class="btn btn-primary btn-sm">Apply</button>
      <a href="{{ route('admin.reports.index') }}" class="btn btn-outline btn-sm">Clear</a>
    </div>

  </form>

  {{-- Results info --}}
  <div style="padding:10px 20px;font-size:.78rem;color:var(--text-muted);border-bottom:1px solid var(--border)">
    Showing {{ $records->firstItem() ?? 0 }}–{{ $records->lastItem() ?? 0 }}
    of {{ $records->total() }} result{{ $records->total() !== 1 ? 's' : '' }}
  </div>

  {{-- Table --}}
  <div class="table-wrap">
    <table class="admin-table">
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
            <td style="color:var(--text-muted);font-size:.78rem">{{ $record->id }}</td>
            <td>
              <div class="td-name">{{ $record->full_name }}</div>
              <div class="td-sub">{{ $record->email }}</div>
            </td>
            <td>{{ $record->phone }}</td>
            <td style="font-size:.82rem;color:var(--text-muted)">{{ $record->location }}</td>
            <td>
              @foreach($record->courses as $course)
                <span class="course-pill">{{ $course->title }}</span>
              @endforeach
            </td>
            <td>
              @include('admin.applications.partials.status-badge', ['status' => $record->status])
            </td>
            <td style="font-size:.8rem;color:var(--text-muted);white-space:nowrap">
              {{ $record->created_at->format('d M Y') }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <h3>No results</h3>
                <p>Try adjusting your filters.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($records->hasPages())
    <div class="pagination">
      {{ $records->links() }}
    </div>
  @endif

</div>

@endsection
