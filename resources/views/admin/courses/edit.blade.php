@extends('admin.layouts.app')

@section('title', 'Edit Course')
@section('page-title', 'Courses')

@section('content')

{{-- ── Breadcrumb ──────────────────────────────────────────── --}}
<div style="display:flex;align-items:center;gap:8px;margin-bottom:22px;
            font-size:.82rem;color:var(--text-muted)" class="animate-in">
  <a href="{{ route('admin.courses.index') }}"
     style="color:var(--text-muted);transition:color .2s"
     onmouseover="this.style.color='var(--accent)'"
     onmouseout="this.style.color='var(--text-muted)'">
    Courses
  </a>
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
       style="width:13px;height:13px">
    <polyline points="9 18 15 12 9 6"/>
  </svg>
  <span style="color:var(--text)">Edit: {{ $course->title }}</span>
</div>

{{-- ── Two-col header ─────────────────────────────────────── --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;
            gap:16px;margin-bottom:20px" class="animate-in">
  <div>
    <h2 style="font-family:'Syne',sans-serif;font-size:1.25rem;font-weight:800">
      {{ $course->title }}
    </h2>
    <p style="color:var(--text-muted);font-size:.82rem;margin-top:3px">
      Last updated {{ $course->updated_at->diffForHumans() }}
      · {{ $course->enrollments_count ?? 0 }} student{{ ($course->enrollments_count ?? 0) !== 1 ? 's' : '' }} enrolled
    </p>
  </div>

  {{-- Danger zone: Delete button --}}
  <button class="btn btn-danger btn-sm"
          data-action="delete"
          data-url="{{ route('admin.courses.destroy', $course) }}"
          data-name="{{ $course->title }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <polyline points="3 6 5 6 21 6"/>
      <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
      <path d="M10 11v6M14 11v6M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
    </svg>
    Delete Course
  </button>
</div>

{{-- ── Enrolled students warning ──────────────────────────── --}}
@if(($course->enrollments_count ?? 0) > 0)
  <div class="alert-chip warn animate-in" style="margin-bottom:20px;border-radius:var(--radius);
              padding:12px 16px;width:100%;max-width:100%;border-radius:var(--radius-sm)">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
      <line x1="12" y1="9" x2="12" y2="13"/>
      <line x1="12" y1="17" x2="12.01" y2="17"/>
    </svg>
    This course has <strong>{{ $course->enrollments_count }} enrolled student{{ $course->enrollments_count !== 1 ? 's' : '' }}</strong>.
    Price changes won't affect existing enrollments.
  </div>
@endif

{{-- ── Form Panel ──────────────────────────────────────────── --}}
<div class="panel animate-in delay-1">

  <div class="panel-header">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:17px;height:17px;color:var(--accent)">
      <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
      <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
    </svg>
    <span class="panel-title">Edit Course Details</span>
    <span style="font-size:.78rem;color:var(--text-muted)">
      Fields marked <span style="color:var(--danger)">*</span> are required
    </span>
  </div>

  <div class="panel-body">
    <form method="POST"
          action="{{ route('admin.courses.update', $course) }}"
          id="courseForm">
      @csrf
      @method('PUT')

      @include('admin.courses.form', ['course' => $course])

      {{-- ── Submit Row ────────────────────────────────────── --}}
      <div style="display:flex;justify-content:space-between;align-items:center;
                  padding-top:24px;margin-top:24px;
                  border-top:1px solid var(--border)">

        {{-- Last saved --}}
        <span style="font-size:.78rem;color:var(--text-faint)">
          Created {{ $course->created_at->format('d M Y') }}
        </span>

        <div style="display:flex;gap:10px">
          <a href="{{ route('admin.courses.index') }}" class="btn btn-outline">
            Discard Changes
          </a>
          <button type="submit" class="btn btn-primary" id="submitBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M20 6L9 17l-5-5"/>
            </svg>
            Update Course
          </button>
        </div>
      </div>

    </form>
  </div>

</div>{{-- /.panel --}}

@endsection

@push('scripts')
<script>
document.getElementById('courseForm').addEventListener('submit', function() {
  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.innerHTML = `
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:15px;height:15px;animation:spin .8s linear infinite">
      <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" opacity=".3"/>
      <path d="M21 12a9 9 0 00-9-9"/>
    </svg>
    Updating…`;
});
</script>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush
