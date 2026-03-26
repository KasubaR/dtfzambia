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

  <div class="table-wrap">
    <table class="admin-table" id="appsTable">
      <thead>
        <tr>
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
            <td colspan="8">
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
