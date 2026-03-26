@extends('admin.layouts.app')

@section('title', 'Application #' . $enrollment->id)
@section('page-title', 'Application #' . $enrollment->id)

@section('content')

@include('admin.applications.partials.validation-errors')

<div class="app-show-toolbar">
  <a href="{{ route('admin.applications.index') }}" class="btn btn-outline btn-sm">← Applications</a>
  @php
    $pendingCourses = $enrollment->courses->filter(fn ($c) => ($c->pivot->status ?? \App\Models\Enrollment::PIVOT_PENDING) === \App\Models\Enrollment::PIVOT_PENDING);
  @endphp
  @if($pendingCourses->isNotEmpty())
    <form method="post" action="{{ route('admin.applications.update', $enrollment) }}" class="app-action-form">
      @csrf
      @method('PATCH')
      @foreach($pendingCourses as $c)
        <input type="hidden" name="courses[{{ $c->id }}]" value="accepted">
      @endforeach
      <button type="submit" class="btn btn-sm btn-success">Accept all pending</button>
    </form>
    <form method="post" action="{{ route('admin.applications.update', $enrollment) }}" class="app-action-form">
      @csrf
      @method('PATCH')
      @foreach($pendingCourses as $c)
        <input type="hidden" name="courses[{{ $c->id }}]" value="rejected">
      @endforeach
      <button type="submit" class="btn btn-sm btn-danger">Reject all pending</button>
    </form>
  @endif
</div>

<div class="panel animate-in">
  <div class="panel-header">
    <span class="panel-title">Applicant</span>
    @include('admin.applications.partials.status-badge', ['status' => $enrollment->status])
  </div>
  <div class="panel-body">
    <div class="detail-grid">
      <div><span class="detail-label">Name</span><div class="detail-value">{{ $enrollment->full_name }}</div></div>
      <div><span class="detail-label">Email</span><div class="detail-value">{{ $enrollment->email }}</div></div>
      <div><span class="detail-label">Phone</span><div class="detail-value">{{ $enrollment->phone }}</div></div>
      <div><span class="detail-label">NRC</span><div class="detail-value">{{ $enrollment->nrc }}</div></div>
      <div><span class="detail-label">Location</span><div class="detail-value">{{ $enrollment->location }}</div></div>
      <div><span class="detail-label">Age range</span><div class="detail-value">{{ $enrollment->age_range }}</div></div>
      <div><span class="detail-label">Education</span><div class="detail-value">{{ $enrollment->education_level }}</div></div>
      <div><span class="detail-label">Employment</span><div class="detail-value">{{ $enrollment->employment_status }}</div></div>
      @if($enrollment->workplace)
        <div class="detail-grid-span-full"><span class="detail-label">Workplace</span><div class="detail-value">{{ $enrollment->workplace }}</div></div>
      @endif
      <div class="detail-grid-span-full"><span class="detail-label">Reason</span><div class="detail-value detail-value-pre">{{ $enrollment->reason }}</div></div>
      <div><span class="detail-label">Total (tiered)</span><div class="detail-value">K{{ number_format($enrollment->total_price, 0) }}</div></div>
      <div><span class="detail-label">Submitted</span><div class="detail-value">{{ $enrollment->created_at->format('d M Y H:i') }}</div></div>
    </div>
  </div>
</div>

<div class="panel animate-in app-courses-panel">
  <div class="panel-header">
    <span class="panel-title">Courses</span>
  </div>
  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Course</th>
          <th>Pivot status</th>
          <th>Price at enrollment</th>
          <th>Reviewed</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($enrollment->courses as $course)
          @php
            $pivotStatus = $course->pivot->status ?? \App\Models\Enrollment::PIVOT_PENDING;
          @endphp
          <tr>
            <td class="td-name">{{ $course->title }}</td>
            <td>@include('admin.applications.partials.pivot-status-badge', ['status' => $pivotStatus])</td>
            <td>K{{ number_format($course->pivot->price_at_enrollment, 0) }}</td>
            <td class="td-muted-sm">
              {{ $course->pivot->reviewed_at ? \Illuminate\Support\Carbon::parse($course->pivot->reviewed_at)->format('d M Y H:i') : '—' }}
            </td>
            <td>
              @if($pivotStatus === \App\Models\Enrollment::PIVOT_PENDING)
                <div class="course-actions">
                  <form method="post" action="{{ route('admin.applications.update', $enrollment) }}" class="app-action-form">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="courses[{{ $course->id }}]" value="accepted">
                    <button type="submit" class="btn btn-sm btn-success">Accept</button>
                  </form>
                  <form method="post" action="{{ route('admin.applications.update', $enrollment) }}" class="app-action-form">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="courses[{{ $course->id }}]" value="rejected">
                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                  </form>
                </div>
              @else
                <span class="td-muted-sm">Decided</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
