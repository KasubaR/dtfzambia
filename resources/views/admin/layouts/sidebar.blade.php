<aside class="admin-sidebar" id="adminSidebar">

  {{-- Brand --}}
  <div class="sidebar-brand">
    <a href="{{ route('admin.dashboard') }}">
      <img src="{{ asset('images/DFL-Logo-Files-02.svg') }}" alt="Digital Future Labs" style="height:36px;width:auto;">
    </a>
  </div>

  {{-- Navigation --}}
  <nav class="sidebar-nav">

    {{-- Overview --}}
    <p class="nav-section-label">Overview</p>

    <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
       href="{{ route('admin.dashboard') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
      </svg>
      Dashboard
    </a>

    {{-- Management --}}
    <p class="nav-section-label">Management</p>

    <a class="nav-item {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}"
       href="{{ route('admin.applications.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
        <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
      </svg>
      Applications
      @if(isset($pendingCount) && $pendingCount > 0)
        <span class="nav-badge">{{ $pendingCount }}</span>
      @endif
    </a>

    <a class="nav-item {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}"
       href="{{ route('admin.enrollments.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
      </svg>
      Enrollments
    </a>

    {{-- Curriculum --}}
    <p class="nav-section-label">Curriculum</p>

    <a class="nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}"
       href="{{ route('admin.courses.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
        <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
      </svg>
      Courses
    </a>

    {{-- Analytics --}}
    <p class="nav-section-label">Analytics</p>

    <a class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
       href="{{ route('admin.reports.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="20" x2="18" y2="10"/>
        <line x1="12" y1="20" x2="12" y2="4"/>
        <line x1="6"  y1="20" x2="6"  y2="14"/>
      </svg>
      Reports
    </a>

  </nav>

  {{-- Footer (logged-in admin) --}}
  <div class="sidebar-footer">
    <div class="admin-user">
      <div class="admin-avatar">
        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
      </div>
      <div class="admin-user-info">
        <div class="admin-user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
        <div class="admin-user-role">Super Admin</div>
      </div>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
           style="width:15px;height:15px;color:var(--text-muted)">
        <circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/>
      </svg>
    </div>
  </div>

</aside>
