@extends('admin.layouts.app')

@section('title', 'Add New Course')
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
  <span style="color:var(--text)">Add New Course</span>
</div>

{{-- ── Form Panel ──────────────────────────────────────────── --}}
<div class="panel animate-in delay-1">

  <div class="panel-header">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:17px;height:17px;color:var(--accent)">
      <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
      <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
    </svg>
    <span class="panel-title">New Course Details</span>
    <span style="font-size:.78rem;color:var(--text-muted)">
      Fields marked <span style="color:var(--danger)">*</span> are required
    </span>
  </div>

  <div class="panel-body">
    <form method="POST" action="{{ route('admin.courses.store') }}" id="courseForm">
      @csrf

      @include('admin.courses.form')

      {{-- ── Submit Row ────────────────────────────────────── --}}
      <div style="display:flex;justify-content:flex-end;gap:10px;
                  padding-top:24px;margin-top:24px;
                  border-top:1px solid var(--border)">
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline">
          Cancel
        </a>
        <button type="submit" class="btn btn-primary" id="submitBtn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/>
            <polyline points="17 21 17 13 7 13 7 21"/>
            <polyline points="7 3 7 8 15 8"/>
          </svg>
          Save Course
        </button>
      </div>

    </form>
  </div>

</div>{{-- /.panel --}}

@endsection

@push('scripts')
<script>
// Prevent double-submit
document.getElementById('courseForm').addEventListener('submit', function() {
  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.innerHTML = `
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:15px;height:15px;animation:spin .8s linear infinite">
      <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" opacity=".3"/>
      <path d="M21 12a9 9 0 00-9-9"/>
    </svg>
    Saving…`;
});
</script>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush
