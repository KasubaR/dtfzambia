@extends('admin.layouts.app')

@section('title', 'Applications')
@section('page-title', 'Applications')

@section('content')

<div class="panel animate-in">
  <div class="panel-header">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:17px;height:17px;color:var(--accent)">
      <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
      <polyline points="14 2 14 8 20 8"/>
    </svg>
    <span class="panel-title">Pending applications</span>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline btn-sm">
      Dashboard
    </a>
  </div>

  {{-- Bulk Action Toolbar --}}
  <div id="appsBulkBar" class="bulk-bar" style="display:none">
    <span id="appsBulkCount" class="bulk-count">0 selected</span>

    <form method="POST" action="{{ route('admin.applications.bulk-approve') }}" id="formBulkApprove" class="bulk-form">
      @csrf
      <div id="approveIds"></div>
      <button type="submit" class="btn btn-sm btn-success">Approve Selected</button>
    </form>

    <form method="POST" action="{{ route('admin.applications.bulk-waitlist') }}" id="formBulkWaitlist" class="bulk-form">
      @csrf
      <div id="waitlistIds"></div>
      <button type="submit" class="btn btn-sm btn-waitlist">Waitlist Selected</button>
    </form>

    <form method="POST" action="{{ route('admin.applications.bulk-reject') }}" id="formBulkReject" class="bulk-form">
      @csrf
      <div id="rejectIds"></div>
      <button type="submit" class="btn btn-sm btn-danger">Reject Selected</button>
    </form>

    <form method="POST" action="{{ route('admin.applications.bulk-destroy') }}" id="formBulkDestroy" class="bulk-form">
      @csrf
      @method('DELETE')
      <div id="destroyIds"></div>
      <button type="submit" class="btn btn-sm btn-danger">Delete Selected</button>
    </form>
  </div>

  <div class="table-wrap">
    <table class="admin-table" id="appsTable">
      <thead>
        <tr>
          <th style="width:36px;text-align:center">
            <input type="checkbox" class="bulk-checkbox" id="selectAllApps">
          </th>
          <th>#</th>
          <th>Applicant</th>
          <th>Phone</th>
          <th>NRC</th>
          <th>Course(s)</th>
          <th>Status</th>
          <th>Date</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($applications as $app)
          <tr>
            <td style="text-align:center">
              <input type="checkbox" class="bulk-checkbox app-checkbox" value="{{ $app->id }}">
            </td>
            <td style="color:var(--text-muted);font-size:.78rem">{{ $app->id }}</td>
            <td>
              <div class="td-name">{{ $app->full_name }}</div>
              <div class="td-sub">{{ $app->email }}</div>
            </td>
            <td>{{ $app->phone }}</td>
            <td style="font-size:.83rem">{{ $app->nrc }}</td>
            <td>
              @foreach($app->courses as $course)
                <span class="course-pill">{{ $course->title }}</span>
              @endforeach
            </td>
            <td>
              @include('admin.applications.partials.status-badge', ['status' => $app->status])
            </td>
            <td style="font-size:.8rem;color:var(--text-muted);white-space:nowrap">
              {{ $app->created_at->format('d M Y') }}
            </td>
            <td>
              <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-sm btn-outline">
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
                <h3>No pending applications</h3>
                <p>All applications have been reviewed.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($applications->hasPages())
    <div class="pagination">
      {{ $applications->links() }}
    </div>
  @endif
</div>

@endsection

@push('scripts')
<script>
(function () {
  const selected = new Set();
  const bulkBar   = document.getElementById('appsBulkBar');
  const countEl   = document.getElementById('appsBulkCount');
  const selectAll = document.getElementById('selectAllApps');
  const idContainers = {
    approve:  document.getElementById('approveIds'),
    waitlist: document.getElementById('waitlistIds'),
    reject:   document.getElementById('rejectIds'),
    destroy:  document.getElementById('destroyIds'),
  };

  function syncBulkBar() {
    if (selected.size === 0) {
      bulkBar.style.display = 'none';
      return;
    }
    bulkBar.style.display = 'flex';
    countEl.textContent = selected.size + ' selected';

    Object.values(idContainers).forEach(container => {
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

  document.querySelectorAll('.app-checkbox').forEach(cb => {
    cb.addEventListener('change', function () {
      this.checked ? selected.add(this.value) : selected.delete(this.value);
      syncBulkBar();
    });
  });

  selectAll.addEventListener('change', function () {
    document.querySelectorAll('.app-checkbox').forEach(cb => {
      cb.checked = this.checked;
      this.checked ? selected.add(cb.value) : selected.delete(cb.value);
    });
    syncBulkBar();
  });

  document.getElementById('formBulkApprove').addEventListener('submit', function (e) {
    e.preventDefault();
    if (confirm('Approve ' + selected.size + ' application(s)?')) this.submit();
  });

  document.getElementById('formBulkWaitlist').addEventListener('submit', function (e) {
    e.preventDefault();
    if (confirm('Add ' + selected.size + ' application(s) to the waiting list?')) this.submit();
  });

  document.getElementById('formBulkReject').addEventListener('submit', function (e) {
    e.preventDefault();
    if (confirm('Reject ' + selected.size + ' application(s)?')) this.submit();
  });

  document.getElementById('formBulkDestroy').addEventListener('submit', function (e) {
    e.preventDefault();
    if (confirm('Permanently delete ' + selected.size + ' application(s)? This cannot be undone.')) this.submit();
  });
})();
</script>
@endpush
