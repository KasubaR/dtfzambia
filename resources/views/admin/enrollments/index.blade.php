@extends('admin.layouts.app')

@section('title', 'Enrollments')
@section('page-title', 'Enrollments')

@section('content')

@if(session('success'))
  <div class="alert-chip success" style="margin-bottom:12px">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert-chip warn" style="margin-bottom:12px">{{ session('error') }}</div>
@endif

<div class="panel animate-in">
  <div class="panel-header">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:17px;height:17px;color:var(--accent)">
      <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
      <circle cx="9" cy="7" r="4"/>
      <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
    </svg>
    <span class="panel-title">Enrollments</span>
  </div>

  <div class="filters-bar">
    <a href="{{ route('admin.enrollments.index', ['tab' => 'accepted']) }}"
       class="btn btn-sm {{ $tab === 'accepted' ? 'btn-primary' : 'btn-outline' }}">Accepted</a>
    <a href="{{ route('admin.enrollments.index', ['tab' => 'waitlisted']) }}"
       class="btn btn-sm {{ $tab === 'waitlisted' ? 'btn-primary' : 'btn-outline' }}">Waiting List</a>
    <a href="{{ route('admin.enrollments.index', ['tab' => 'rejected']) }}"
       class="btn btn-sm {{ $tab === 'rejected' ? 'btn-primary' : 'btn-outline' }}">Rejected</a>
  </div>

  {{-- Bulk Action Toolbar --}}
  <div id="enrollBulkBar" class="bulk-bar" style="display:none">
    <span id="enrollBulkCount" class="bulk-count">0 selected</span>

    <form method="POST" action="{{ route('admin.enrollments.bulk-export') }}" id="formBulkExport" class="bulk-form">
      @csrf
      <div id="exportIds"></div>
      <button type="submit" class="btn btn-sm btn-outline">Export CSV</button>
    </form>

    <form method="POST" action="{{ route('admin.enrollments.bulk-destroy') }}" id="formEnrollDestroy" class="bulk-form">
      @csrf
      @method('DELETE')
      <div id="enrollDestroyIds"></div>
      <button type="submit" class="btn btn-sm btn-danger">Delete Selected</button>
    </form>
  </div>

  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width:36px;text-align:center">
            <input type="checkbox" class="bulk-checkbox" id="selectAllEnroll">
          </th>
          <th>#</th>
          <th>Student</th>
          <th>Phone</th>
          <th>NRC</th>
          <th>Course(s)</th>
          <th>Status</th>
          <th>Date</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($enrollments as $enrollment)
          <tr>
            <td style="text-align:center">
              <input type="checkbox" class="bulk-checkbox enroll-checkbox" value="{{ $enrollment->id }}">
            </td>
            <td style="color:var(--text-muted);font-size:.78rem">{{ $enrollment->id }}</td>
            <td>
              <div class="td-name">{{ $enrollment->full_name }}</div>
              <div class="td-sub">{{ $enrollment->email }}</div>
            </td>
            <td>{{ $enrollment->phone }}</td>
            <td style="font-size:.83rem">{{ $enrollment->nrc }}</td>
            <td>
              @foreach($enrollment->courses as $course)
                <span class="course-pill">{{ $course->title }}</span>
              @endforeach
            </td>
            <td>
              @include('admin.applications.partials.status-badge', ['status' => $enrollment->status])
            </td>
            <td style="font-size:.8rem;color:var(--text-muted);white-space:nowrap">
              {{ $enrollment->created_at->format('d M Y') }}
            </td>
            <td>
              <div class="dropdown">
                <button class="btn btn-sm btn-outline dropdown-toggle" type="button">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px">
                    <circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/>
                  </svg>
                </button>
                <div class="dropdown-menu" style="right:0;left:auto;min-width:140px">
                  <a href="{{ route('admin.applications.show', $enrollment) }}" class="dropdown-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                    View
                  </a>
                  <div class="dropdown-sep"></div>
                  <form method="POST" action="{{ route('admin.enrollments.destroy', $enrollment) }}"
                        onsubmit="return confirm('Delete enrollment for {{ addslashes($enrollment->full_name) }}? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item danger" style="width:100%;background:none;border:none;cursor:pointer;text-align:left">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                      </svg>
                      Delete
                    </button>
                  </form>
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9">
              @php
                $emptyLabel = ['accepted' => 'accepted', 'waitlisted' => 'on the waiting list', 'rejected' => 'rejected'][$tab] ?? $tab;
              @endphp
              <div class="empty-state">
                <h3>No enrollments</h3>
                <p>No students have been {{ $emptyLabel }} yet.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($enrollments->hasPages())
    <div class="pagination">
      {{ $enrollments->links() }}
    </div>
  @endif
</div>

@endsection

@push('scripts')
<script>
(function () {
  const selected   = new Set();
  const bulkBar    = document.getElementById('enrollBulkBar');
  const countEl    = document.getElementById('enrollBulkCount');
  const selectAll  = document.getElementById('selectAllEnroll');
  const exportIds  = document.getElementById('exportIds');
  const destroyIds = document.getElementById('enrollDestroyIds');

  function syncBulkBar() {
    if (selected.size === 0) {
      bulkBar.style.display = 'none';
      return;
    }
    bulkBar.style.display = 'flex';
    countEl.textContent = selected.size + ' selected';

    [exportIds, destroyIds].forEach(container => {
      if (! container) return;
      container.innerHTML = '';
      selected.forEach(id => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'ids[]';
        input.value = id;
        container.appendChild(input);
      });
    });
  }

  document.querySelectorAll('.enroll-checkbox').forEach(cb => {
    cb.addEventListener('change', function () {
      this.checked ? selected.add(this.value) : selected.delete(this.value);
      syncBulkBar();
    });
  });

  selectAll.addEventListener('change', function () {
    document.querySelectorAll('.enroll-checkbox').forEach(cb => {
      cb.checked = this.checked;
      this.checked ? selected.add(cb.value) : selected.delete(cb.value);
    });
    syncBulkBar();
  });

  const destroyForm = document.getElementById('formEnrollDestroy');
  if (destroyForm) {
    destroyForm.addEventListener('submit', function (e) {
      e.preventDefault();
      if (confirm('Permanently delete ' + selected.size + ' enrollment(s)? This cannot be undone.')) this.submit();
    });
  }

  // Dropdown toggles
  document.querySelectorAll('.dropdown-toggle').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      const dropdown = this.closest('.dropdown');
      const isOpen = dropdown.classList.contains('open');
      document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
      if (!isOpen) dropdown.classList.add('open');
    });
  });
  document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
  });
})();
</script>
@endpush
