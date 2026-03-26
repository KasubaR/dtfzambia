<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard') — DFL Admin</title>

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

  {{-- Admin CSS + JS --}}
  @vite(['resources/css/admin.css', 'resources/js/admin.js'])

  @stack('styles')
</head>
<body
  @if(session('success')) data-flash-success="{{ session('success') }}" @endif
  @if(session('error'))   data-flash-error="{{ session('error') }}"     @endif
  @if(session('warning')) data-flash-warn="{{ session('warning') }}"    @endif
  @if(session('info'))    data-flash-info="{{ session('info') }}"       @endif
>

  {{-- ── Sidebar ──────────────────────────────────────────── --}}
  @include('admin.layouts.sidebar')

  {{-- ── Main Area ─────────────────────────────────────────── --}}
  <div class="admin-main">

    {{-- Top Bar --}}
    <header class="admin-topbar">
      {{-- Mobile menu toggle --}}
      <button class="topbar-icon-btn" data-sidebar-toggle aria-label="Toggle sidebar" style="display:none;margin-right:8px">
        @svg('menu')
      </button>

      <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>

      {{-- Search --}}
      <div class="topbar-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
        </svg>
        <input type="text" placeholder="Search…" id="globalSearch" autocomplete="off">
      </div>

      {{-- Notifications --}}
      <div class="dropdown">
        <button class="topbar-icon-btn" data-dropdown aria-label="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
          </svg>
          @if(isset($pendingCount) && $pendingCount > 0)
            <span class="notif-dot"></span>
          @endif
        </button>
        <div class="dropdown-menu" style="min-width:280px">
          <div style="padding:10px 14px;border-bottom:1px solid var(--border)">
            <span style="font-size:.8rem;font-weight:700;font-family:'Syne',sans-serif">Notifications</span>
          </div>
          @if(isset($pendingCount) && $pendingCount > 0)
            <div class="dropdown-item">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--warn)">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
              </svg>
              <span>{{ $pendingCount }} pending application{{ $pendingCount !== 1 ? 's' : '' }}</span>
            </div>
          @else
            <div style="padding:18px 14px;text-align:center;color:var(--text-muted);font-size:.83rem">
              No new notifications
            </div>
          @endif
        </div>
      </div>

      {{-- Admin Avatar Dropdown --}}
      <div class="dropdown">
        <button class="admin-avatar" data-dropdown style="cursor:pointer;border:none;background:var(--accent-dim)">
          {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
        </button>
        <div class="dropdown-menu">
          <div style="padding:10px 14px;border-bottom:1px solid var(--border)">
            <div style="font-size:.83rem;font-weight:700">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div style="font-size:.73rem;color:var(--text-muted)">{{ auth()->user()->email ?? '' }}</div>
          </div>
          <a class="dropdown-item" href="{{ route('admin.profile') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            Profile
          </a>
          <div class="dropdown-sep"></div>
          <form method="POST" action="{{ route('admin.logout') }}" style="all:unset">
            @csrf
            <button type="submit" class="dropdown-item danger" style="width:100%;text-align:left">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
              </svg>
              Sign Out
            </button>
          </form>
        </div>
      </div>
    </header>

    {{-- Page Content --}}
    <main class="admin-content">
      @yield('content')
    </main>

  </div>{{-- /.admin-main --}}

  {{-- Toast container (JS will append toasts here) --}}
  <div class="toast-container" id="toastContainer"></div>

  @stack('scripts')

</body>
</html>
