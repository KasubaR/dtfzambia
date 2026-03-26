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

  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
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
            <td colspan="8">
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
