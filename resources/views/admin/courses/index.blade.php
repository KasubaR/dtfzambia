@extends('admin.layouts.app')

@section('title', 'Courses')
@section('page-title', 'Courses')

@section('content')

{{-- ── Page Header ─────────────────────────────────────────── --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px" class="animate-in">
  <div>
    <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;line-height:1">
      Course Catalogue
    </h2>
    <p style="color:var(--text-muted);font-size:.83rem;margin-top:4px">
      {{ $courses->total() }} course{{ $courses->total() !== 1 ? 's' : '' }} available
    </p>
  </div>
  <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Add New Course
  </a>
</div>

{{-- ── Stats Strip ─────────────────────────────────────────── --}}
<div class="stats-grid" style="grid-template-columns:repeat(auto-fill,minmax(160px,1fr));margin-bottom:22px">
  <div class="stat-card animate-in delay-1" style="padding:16px">
    <div class="stat-icon blue" style="width:32px;height:32px;margin-bottom:10px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
        <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
      </svg>
    </div>
    <div class="stat-value" style="font-size:1.5rem" data-count="{{ $totalCourses }}">0</div>
    <div class="stat-label">Total Courses</div>
  </div>
  <div class="stat-card animate-in delay-2" style="padding:16px">
    <div class="stat-icon green" style="width:32px;height:32px;margin-bottom:10px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/>
        <path d="M10 8l6 4-6 4V8z"/>
      </svg>
    </div>
    <div class="stat-value" style="font-size:1.5rem" data-count="{{ $hybridCount }}">0</div>
    <div class="stat-label">Hybrid Mode</div>
  </div>
  <div class="stat-card animate-in delay-3" style="padding:16px">
    <div class="stat-icon orange" style="width:32px;height:32px;margin-bottom:10px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="1" x2="12" y2="23"/>
        <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
      </svg>
    </div>
    <div class="stat-value" style="font-size:1.5rem">₦{{ number_format($avgPrice) }}</div>
    <div class="stat-label">Avg. Price</div>
  </div>
  <div class="stat-card animate-in delay-4" style="padding:16px">
    <div class="stat-icon purple" style="width:32px;height:32px;margin-bottom:10px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 00-3-3.87"/>
        <path d="M16 3.13a4 4 0 010 7.75"/>
      </svg>
    </div>
    <div class="stat-value" style="font-size:1.5rem" data-count="{{ $totalEnrolled }}">0</div>
    <div class="stat-label">Total Enrolled</div>
  </div>
</div>

{{-- ── Main Panel ──────────────────────────────────────────── --}}
<div class="panel animate-in delay-2">

  {{-- Filters Bar --}}
  <div class="filters-bar" data-filter-group="coursesTable">
    {{-- Mode tabs --}}
    <div style="display:flex;gap:6px;flex-wrap:wrap">
      <button class="btn btn-sm btn-primary"  data-filter-tab="all">All</button>
      <button class="btn btn-sm btn-outline"  data-filter-tab="hybrid">Hybrid</button>
      <button class="btn btn-sm btn-outline"  data-filter-tab="online">Online</button>
      <button class="btn btn-sm btn-outline"  data-filter-tab="physical">Physical</button>
    </div>

    <div style="margin-left:auto;display:flex;gap:8px;align-items:center">
      {{-- Search --}}
      <input type="text"
             class="filter-input"
             placeholder="Search courses…"
             data-table-search="coursesTable"
             style="width:210px">

      {{-- Sort --}}
      <select class="filter-select" id="courseSort" style="min-width:130px">
        <option value="newest">Newest First</option>
        <option value="oldest">Oldest First</option>
        <option value="price-asc">Price: Low→High</option>
        <option value="price-desc">Price: High→Low</option>
        <option value="enrolled">Most Enrolled</option>
      </select>
    </div>
  </div>

  {{-- Table --}}
  <div class="table-wrap">
    <table class="admin-table" id="coursesTable">
      <thead>
        <tr>
          <th style="width:40px">#</th>
          <th>Title</th>
          <th>Description</th>
          <th>Duration</th>
          <th>Mode</th>
          <th>Price</th>
          <th>Enrolled</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($courses as $course)
          <tr data-mode="{{ strtolower($course->mode) }}">
            <td style="color:var(--text-muted);font-size:.78rem;font-weight:600">
              {{ $course->id }}
            </td>
            <td>
              <div class="td-name">{{ $course->title }}</div>
              <div class="td-sub" style="margin-top:3px">
                Added {{ $course->created_at->diffForHumans() }}
              </div>
            </td>
            <td style="max-width:240px">
              <div style="font-size:.82rem;color:var(--text-muted);
                          overflow:hidden;display:-webkit-box;
                          -webkit-line-clamp:2;-webkit-box-orient:vertical">
                {{ $course->description ?? '—' }}
              </div>
            </td>
            <td>
              <div style="display:flex;align-items:center;gap:6px;white-space:nowrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     style="width:14px;height:14px;color:var(--text-muted)">
                  <circle cx="12" cy="12" r="10"/>
                  <polyline points="12 6 12 12 16 14"/>
                </svg>
                <span style="font-size:.84rem">{{ $course->duration }}</span>
              </div>
            </td>
            <td>
              @php
                $modeColors = [
                  'hybrid'   => ['bg' => 'rgba(79,159,255,.12)',  'color' => '#4f9fff'],
                  'online'   => ['bg' => 'rgba(79,255,176,.12)',  'color' => '#4fffb0'],
                  'physical' => ['bg' => 'rgba(255,183,79,.12)',  'color' => '#ffb74f'],
                ];
                $mc = $modeColors[strtolower($course->mode)] ?? ['bg'=>'var(--surface-3)','color'=>'var(--text-muted)'];
              @endphp
              <span style="display:inline-flex;align-items:center;gap:5px;
                           padding:3px 10px;border-radius:20px;font-size:.74rem;font-weight:700;
                           background:{{ $mc['bg'] }};color:{{ $mc['color'] }}">
                <span style="width:6px;height:6px;border-radius:50%;background:currentColor"></span>
                {{ ucfirst($course->mode) }}
              </span>
            </td>
            <td>
              <span style="font-family:'Syne',sans-serif;font-size:.95rem;font-weight:800;
                           color:var(--accent)">
                ₦{{ number_format($course->price) }}
              </span>
            </td>
            <td>
              <div style="display:flex;align-items:center;gap:6px">
                <span style="font-size:.85rem;font-weight:600">
                  {{ $course->enrollments_count ?? 0 }}
                </span>
                <div style="width:40px;height:4px;background:var(--surface-3);border-radius:2px">
                  <div style="width:{{ min(100, (($course->enrollments_count ?? 0) / max(1,$maxEnrolled)) * 100) }}%;
                              height:100%;background:var(--accent);border-radius:2px;
                              transition:width .6s ease"></div>
                </div>
              </div>
            </td>
            <td>
              <div style="display:flex;gap:6px">
                <a href="{{ route('admin.courses.edit', $course) }}"
                   class="btn btn-sm btn-outline"
                   title="Edit">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                  </svg>
                  Edit
                </a>
                <button class="btn btn-sm btn-danger"
                        data-action="delete"
                        data-url="{{ route('admin.courses.destroy', $course) }}"
                        data-name="{{ $course->title }}"
                        title="Delete">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8">
              <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
                  <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
                </svg>
                <h3>No courses yet</h3>
                <p>Get started by adding your first course.</p>
                <a href="{{ route('admin.courses.create') }}"
                   class="btn btn-primary btn-sm" style="margin-top:14px">
                  Add First Course
                </a>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($courses->hasPages())
    <div class="pagination">
      @if($courses->onFirstPage())
        <button class="page-btn" disabled style="opacity:.4">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px">
            <polyline points="15 18 9 12 15 6"/>
          </svg>
        </button>
      @else
        <a href="{{ $courses->previousPageUrl() }}" class="page-btn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px">
            <polyline points="15 18 9 12 15 6"/>
          </svg>
        </a>
      @endif

      @foreach($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
        <a href="{{ $url }}" class="page-btn {{ $courses->currentPage() === $page ? 'active' : '' }}">
          {{ $page }}
        </a>
      @endforeach

      @if($courses->hasMorePages())
        <a href="{{ $courses->nextPageUrl() }}" class="page-btn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </a>
      @else
        <button class="page-btn" disabled style="opacity:.4">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </button>
      @endif

      <div class="pagination-info">
        {{ $courses->firstItem() }}–{{ $courses->lastItem() }} of {{ $courses->total() }}
      </div>
    </div>
  @endif

</div>{{-- /.panel --}}

@endsection

@push('scripts')
<script>
// Mode filter tabs for courses table (filter by data-mode attribute)
document.querySelectorAll('[data-filter-tab]').forEach(tab => {
  tab.addEventListener('click', () => {
    const group = tab.closest('[data-filter-group]');
    group?.querySelectorAll('[data-filter-tab]').forEach(t => {
      t.className = t === tab ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline';
    });
    const mode = tab.dataset.filterTab;
    document.querySelectorAll('#coursesTable tbody tr[data-mode]').forEach(row => {
      row.style.display = (mode === 'all' || row.dataset.mode === mode) ? '' : 'none';
    });
  });
});
</script>
@endpush
