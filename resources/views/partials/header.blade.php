{{-- resources/views/partials/header.blade.php --}}
<nav id="main-nav" class="glass-nav fixed top-0 w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 lg:h-18">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center group">
                <img src="{{ asset('images/DFL-Logo-Files-02.svg') }}"
                     alt="Digital Future Labs"
                     class="h-10 w-auto" />
            </a>

            {{-- Desktop nav --}}
            <div class="hidden md:flex items-center gap-8">
                <a class="nav-link text-sm font-semibold text-[var(--color-text-muted)] hover:text-[var(--color-primary)] transition-colors duration-200" href="{{ url('/') }}">Home</a>
                <a class="nav-link text-sm font-semibold text-[var(--color-text-muted)] hover:text-[var(--color-primary)] transition-colors duration-200" href="{{ url('/courses') }}">Courses</a>
                <a class="nav-link text-sm font-semibold text-[var(--color-text-muted)] hover:text-[var(--color-primary)] transition-colors duration-200" href="{{ route('about') }}">About Us</a>
<a href="{{ route('enrollment.create') }}" class="btn-primary text-xs py-2.5 px-5">
                    Apply Now
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            {{-- Mobile burger --}}
            <button id="mobile-menu-btn"
                    class="md:hidden p-2 rounded-md transition-colors hover:bg-[var(--color-surface-mid)]"
                    aria-label="Toggle navigation"
                    aria-expanded="false">
                <span class="material-symbols-outlined" style="color: var(--color-primary);">menu</span>
            </button>
        </div>
    </div>

    {{-- Mobile dropdown --}}
    <div id="mobile-menu" aria-hidden="true">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/courses') }}">Courses</a>
        <a href="{{ route('about') }}">About Us</a>
        <a href="{{ route('enrollment.create') }}" class="btn-primary mt-2 self-start">Apply Now</a>
    </div>
</nav>

<style>
#main-nav.scrolled {
    box-shadow: 0 4px 24px rgba(16, 76, 157, 0.10);
}
.nav-link.active {
    color: var(--color-primary);
    font-weight: 700;
    text-decoration: underline;
    text-underline-offset: 4px;
}
</style>
