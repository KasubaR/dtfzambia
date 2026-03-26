@extends('admin.layouts.app')

@section('title', 'Enrollments')
@section('page-title', 'Enrollments')

@section('content')

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

    @if($tab === 'rejected')
    <form method="POST" action="{{ route('admin.enrollments.bulk-destroy') }}" id="formEnrollDestroy" class="bulk-form">
      @csrf
      @method('DELETE')
      <input type="hidden" name="tab" value="{{ $tab }}">
      <div id="enrollDestroyIds"></div>
      <button type="submit" class="btn btn-sm btn-danger">Delete Selected</button>
    </form>
    @endif
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
              <a href="{{ route('admin.applications.show', $enrollment) }}" class="btn btn-sm btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                View
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9">
              <div class="empty-state">
                <h3>No {{ $tab }} enrollments</h3>
                <p>No students have been {{ $tab }} yet.</p>
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
})();
</script>
@endpush
