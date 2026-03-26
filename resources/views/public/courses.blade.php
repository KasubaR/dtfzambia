{{-- resources/views/public/courses.blade.php --}}
@extends('layouts.app')

@section('title', 'Our Courses — Digital Future Labs')
@section('meta_description', 'Explore Digital Future Labs practical digital skills programs — designed for real-world impact and built for Zambian entrepreneurs and professionals.')

@push('head')
<style>
    /* ── Hero ─────────────────────────────────────────────────── */
    .courses-hero {
        background-color: var(--color-dark-bg);
        position: relative;
        overflow: hidden;
        padding: 7rem 0 5rem;
    }

    .courses-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 50% at 80% 50%, rgba(172,193,55,.13) 0%, transparent 70%),
            radial-gradient(ellipse 40% 60% at 10% 80%, rgba(16,76,157,.35) 0%, transparent 65%);
        pointer-events: none;
    }

    .courses-hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
        background-size: 48px 48px;
        pointer-events: none;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(172,193,55,.15);
        border: 1px solid rgba(172,193,55,.3);
        color: var(--color-green);
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 0.35rem 0.85rem;
        border-radius: var(--radius-full);
        margin-bottom: 1.25rem;
    }

    /* ── Filter Bar ───────────────────────────────────────────── */
    .filter-bar {
        background: var(--color-white);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: 0.5rem;
        display: inline-flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }

    .filter-btn {
        padding: 0.4rem 1rem;
        border-radius: var(--radius-md);
        font-size: 0.75rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .2s ease;
        background: transparent;
        color: var(--color-text-muted);
    }

    .filter-btn:hover { background: var(--color-surface-mid); color: var(--color-text); }
    .filter-btn.active { background: var(--color-primary); color: white; }

    /* ── Course Cards ─────────────────────────────────────────── */
    .cc-card {
        background: var(--color-white);
        border-radius: var(--radius-xl);
        border: 1px solid rgba(16,76,157,.12);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        position: relative;
    }

    .cc-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(16,76,157,.25);
    }

    .cc-card.selected {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(16,76,157,.12), var(--shadow-md);
    }

    .cc-card-header {
        padding: 1.5rem 1.5rem 1rem;
        position: relative;
    }

    .course-icon {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        background: var(--color-primary-light);
    }

    .course-icon .material-symbols-outlined {
        color: var(--color-primary);
        font-size: 1.25rem;
    }

    .cc-card-body {
        padding: 0 1.5rem 1.25rem;
        flex: 1;
    }

    .cc-card-footer {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid var(--color-surface-high);
        background: var(--color-surface-low);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .course-meta {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 0.75rem;
    }

    .course-meta-item {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .course-meta-item .material-symbols-outlined {
        font-size: 0.9rem;
        color: var(--color-green);
    }

    .course-price {
        font-family: var(--font-headline);
        font-weight: 800;
        font-size: 1.25rem;
        color: var(--color-primary);
    }

    .course-price .currency {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--color-text-muted);
        vertical-align: super;
        margin-right: 1px;
    }

    /* Select checkbox */
    .select-checkbox {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        border: 2px solid var(--color-border);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s ease;
        background: white;
    }

    .cc-card.selected .select-checkbox {
        background: var(--color-primary);
        border-color: var(--color-primary);
    }

    .select-checkbox .material-symbols-outlined {
        font-size: 0.875rem;
        color: white;
        opacity: 0;
        transition: opacity .15s ease;
    }

    .cc-card.selected .select-checkbox .material-symbols-outlined { opacity: 1; }

    /* Expandable modules */
    .modules-toggle {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--color-primary);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        background: none;
        border: none;
        padding: 0;
        margin-top: 0.75rem;
        transition: color .2s;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .modules-toggle:hover { color: var(--color-primary-dark); }

    .modules-toggle .arrow {
        transition: transform .3s ease;
        font-size: 1rem;
    }

    .modules-toggle.open .arrow { transform: rotate(180deg); }

    .modules-list {
        max-height: 0;
        overflow: hidden;
        transition: max-height .35s ease;
    }

    .modules-list.open { max-height: 500px; }

    .module-item {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.4rem 0;
        font-size: 0.78rem;
        color: var(--color-text-muted);
        border-bottom: 1px solid var(--color-surface-mid);
    }

    .module-item:last-child { border-bottom: none; }

    .module-item .material-symbols-outlined {
        font-size: 0.9rem;
        color: var(--color-green);
        margin-top: 1px;
        flex-shrink: 0;
    }


    /* ── Cart / Enrollment Bar ────────────────────────────────── */
    .enrollment-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 100;
        transform: translateY(100%);
        transition: transform .35s cubic-bezier(.4,0,.2,1);
        background: var(--color-dark-bg);
        border-top: 1px solid rgba(255,255,255,.1);
        padding: 1rem 1.5rem;
        box-shadow: 0 -8px 32px rgba(0,0,0,.25);
    }

    .enrollment-bar.visible { transform: translateY(0); }

    /* ── Empty state ──────────────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        color: var(--color-text-muted);
    }

    /* ── Access states ────────────────────────────────────────── */
    .status-banner {
        background: var(--color-primary-light);
        border: 1px solid rgba(16,76,157,.2);
        border-radius: var(--radius-lg);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .status-banner.warning {
        background: #fef9e7;
        border-color: #f0c04b;
    }

    .status-banner .material-symbols-outlined {
        font-size: 1.2rem;
        color: var(--color-primary);
        flex-shrink: 0;
        margin-top: 1px;
    }

    .status-banner.warning .material-symbols-outlined { color: #b45309; }
</style>
@endpush

@section('content')

{{-- ─────────────────────────────────────────────────────────────
     HERO
───────────────────────────────────────────────────────────────── --}}
<section class="courses-hero">
    <div class="courses-hero-grid"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="max-w-2xl">

            <div class="hero-badge">
                <span class="material-symbols-outlined" style="font-size:.9rem;">school</span>
                {{ $courses->count() }} Programs Available
            </div>

            <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4"
                style="font-family: var(--font-headline); letter-spacing: -0.03em; line-height:1.1;">
                Build Skills That<br>
                <span style="color: var(--color-green);">Move Markets.</span>
            </h1>

            <p class="text-base lg:text-lg mb-8" style="color: rgba(255,255,255,.65); line-height:1.7;">
                Explore our practical digital skills programs designed for real-world impact —
                built for Zambian entrepreneurs and the professionals shaping tomorrow.
            </p>

            <div class="flex flex-wrap gap-3">
                <a href="#courses" class="btn-primary">
                    View Courses
                    <span class="material-symbols-outlined text-sm">arrow_downward</span>
                </a>
            </div>

        </div>
    </div>
</section>


{{-- ─────────────────────────────────────────────────────────────
     COURSES LISTING
───────────────────────────────────────────────────────────────── --}}
<section id="courses" class="py-16 lg:py-24" style="background: var(--color-surface);">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Section header + filters --}}
        <div class="text-center mb-16">
            <p class="section-eyebrow">Our Programs</p>
            <h2 class="section-title text-3xl lg:text-4xl mb-8">Choose Your Path</h2>

            {{-- Filter bar --}}
            <div class="filter-bar">
                <button class="filter-btn active" data-filter="all">All Courses</button>
                <button class="filter-btn" data-filter="hybrid">Hybrid</button>
                <button class="filter-btn" data-filter="online">Online</button>
                <button class="filter-btn" data-filter="10-days">10 Days</button>
                <button class="filter-btn" data-filter="30-days">30+ Days</button>
            </div>
        </div>

        {{-- Selected courses summary (shows when courses selected) --}}
        <div id="selection-summary" class="hidden mb-8 p-4 rounded-xl flex flex-wrap items-center justify-between gap-4"
             style="background: var(--color-primary-light); border: 1px solid rgba(16,76,157,.2);">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined" style="color: var(--color-primary);">shopping_bag</span>
                <span class="text-sm font-bold" style="color: var(--color-primary);">
                    <span id="selected-count">0</span> course(s) selected
                </span>
                <span class="text-sm" style="color: var(--color-text-muted);">•</span>
                <span class="text-sm font-bold" style="color: var(--color-primary);">
                    Total: K<span id="selected-total">0</span>
                </span>
                @if(now()->lt(\Carbon\Carbon::parse('2025-12-31')))
                <span class="badge badge-green ml-1">Free This Cohort</span>
                @endif
            </div>
            <button onclick="clearSelection()"
                    class="text-xs font-semibold"
                    style="color: var(--color-text-muted);">
                Clear selection
            </button>
        </div>

        {{-- Grid --}}
        @if ($courses->isEmpty())
            <div class="empty-state">
                <span class="material-symbols-outlined text-5xl mb-4 block" style="color: var(--color-surface-high);">
                    school
                </span>
                <p class="font-bold text-lg mb-1">No courses available yet.</p>
                <p class="text-sm">Check back soon — new programs are on their way.</p>
            </div>
        @else
        <div id="courses-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($courses as $course)
                @include('partials.course-card', ['course' => $course])
            @endforeach

        </div>
        @endif

    </div>
</section>


{{-- ─────────────────────────────────────────────────────────────
     FINAL CTA
───────────────────────────────────────────────────────────────── --}}
<section class="py-24" style="background-color: var(--color-surface);">
    <div class="max-w-5xl mx-auto px-6 lg:px-8" data-animate>
        <div class="relative overflow-hidden rounded-3xl p-12 lg:p-16 text-center text-white"
             style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 60%, #0a2855 100%);
                    box-shadow: var(--shadow-lg);">

            {{-- Decorative blobs --}}
            <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full pointer-events-none"
                 style="background: var(--color-green); opacity: .15; filter: blur(60px);"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 rounded-full pointer-events-none"
                 style="background: rgba(172,193,55,.3); filter: blur(60px);"></div>

            <div class="relative z-10">
                <span class="badge mb-6 inline-block" style="background: rgba(172,193,55,.2); color: var(--color-green);">
                    Limited Spots Available
                </span>
                <h2 class="text-4xl lg:text-5xl font-extrabold font-headline mb-6">
                    Ready to Get Started?
                </h2>
                <p class="mb-10 max-w-xl mx-auto text-lg" style="color: rgba(255,255,255,.75);">
                    Join the next generation of digital entrepreneurs.
                    Apply now — the current cohort is completely free.
                </p>

                <a href="{{ route('enrollment.create') }}"
                   class="inline-flex items-center gap-2 px-10 py-5 rounded-xl font-bold text-sm uppercase tracking-widest transition-all duration-200"
                   style="background: white; color: var(--color-primary);"
                   onmouseover="this.style.background='var(--color-green-light)'; this.style.color='var(--color-green-dark)';"
                   onmouseout="this.style.background='white'; this.style.color='var(--color-primary)';">
                    Apply Now — It's Free
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>

        </div>
    </div>
</section>


{{-- ─────────────────────────────────────────────────────────────
     FAQ
───────────────────────────────────────────────────────────────── --}}
<section class="py-20 lg:py-28" style="background-color: var(--color-surface-low);">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">

        <div class="text-center mb-14">
            <p class="section-eyebrow">Got Questions?</p>
            <h2 class="section-title text-3xl lg:text-4xl font-extrabold mb-3">Frequently Asked Questions</h2>
            <p style="color: var(--color-text-muted);">Everything you need to know about our learning model.</p>
        </div>

        <div class="space-y-3" id="faq-list">

            @foreach ([
                [
                    'q' => 'How does the 10-day hybrid model work?',
                    'a' => 'The hybrid model combines 4 intensive in-person workshop days with 6 days of remote, mentor-guided project work. This allows for high-impact learning while providing the flexibility needed for working professionals.',
                ],
                [
                    'q' => 'What does "Fully Sponsored" mean?',
                    'a' => 'For the current cohort, all tuition fees are covered by our sponsors — meaning you can enrol in any program at absolutely no cost. This offer applies until the end of the current intake.',
                ],
                [
                    'q' => 'Will I receive a certification upon completion?',
                    'a' => 'Yes. Every graduate receives a Digital Future Labs certificate of completion. Our certifications are recognised by partner employers and institutions across Zambia.',
                ],
                [
                    'q' => 'What are the prerequisites for these courses?',
                    'a' => 'No prior experience is required. Our programs are designed to be accessible to total beginners, while still being valuable for professionals looking to deepen their skills.',
                ],
                [
                    'q' => 'Can I enrol in more than one course?',
                    'a' => 'Absolutely. You can select up to 3 courses in a single cohort. Bundle pricing applies for 2 or more courses, giving you greater value.',
                ],
            ] as $i => $faq)
            <div class="faq-item rounded-xl overflow-hidden"
                 style="border: 1px solid var(--color-border);">
                <button class="faq-trigger w-full flex items-center justify-between gap-4 p-6 text-left transition-colors duration-200"
                        style="background: var(--color-surface-low);"
                        onclick="toggleFaq(this)"
                        aria-expanded="false">
                    <h4 class="font-headline font-bold text-base" style="color: var(--color-primary);">
                        {{ $faq['q'] }}
                    </h4>
                    <span class="material-symbols-outlined flex-shrink-0 transition-transform duration-300"
                          style="color: var(--color-green);">expand_more</span>
                </button>
                <div class="faq-body" style="max-height: 0; overflow: hidden; transition: max-height .35s ease;">
                    <p class="px-6 pb-6 pt-1 text-sm leading-relaxed" style="color: var(--color-text-muted);">
                        {{ $faq['a'] }}
                    </p>
                </div>
            </div>
            @endforeach

        </div>

    </div>
</section>

{{-- ─────────────────────────────────────────────────────────────
     NOT SURE WHERE TO START
───────────────────────────────────────────────────────────────── --}}
<section class="py-24" style="background-color: var(--color-surface);">
    <div class="max-w-5xl mx-auto px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl p-12 lg:p-16 text-center text-white"
             style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 60%, #0a2855 100%);
                    box-shadow: var(--shadow-lg);">

            {{-- Decorative blobs --}}
            <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full pointer-events-none"
                 style="background: var(--color-green); opacity: .15; filter: blur(60px);"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 rounded-full pointer-events-none"
                 style="background: rgba(172,193,55,.3); filter: blur(60px);"></div>

            <div class="relative z-10">
                <span class="badge mb-6 inline-block" style="background: rgba(172,193,55,.2); color: var(--color-green);">
                    Free Consultation
                </span>
                <h2 class="text-4xl lg:text-5xl font-extrabold font-headline mb-6">
                    Not Sure Where to Start?
                </h2>
                <p class="mb-10 max-w-xl mx-auto text-lg" style="color: rgba(255,255,255,.75);">
                    Speak with our learning advisors to find the path that aligns with your career goals. Get a free consultation today.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="mailto:info@dflzambia.com"
                       class="inline-flex items-center gap-2 px-10 py-5 rounded-xl font-bold text-sm uppercase tracking-widest transition-all duration-200"
                       style="background: white; color: var(--color-primary);"
                       onmouseover="this.style.background='var(--color-green-light)'; this.style.color='var(--color-green-dark)';"
                       onmouseout="this.style.background='white'; this.style.color='var(--color-primary)';">
                        <span class="material-symbols-outlined">mail</span>
                        Book a Call
                    </a>
                    <a href="https://wa.me/260970000000"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-10 py-5 rounded-xl font-bold text-sm uppercase tracking-widest transition-all duration-200"
                       style="border: 2px solid rgba(255,255,255,.3); color: white;"
                       onmouseover="this.style.borderColor='rgba(255,255,255,.6)';"
                       onmouseout="this.style.borderColor='rgba(255,255,255,.3)';">
                        <span class="material-symbols-outlined">chat</span>
                        Chat on WhatsApp
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ─────────────────────────────────────────────────────────────
     ENROLLMENT BAR (fixed bottom, approved users)
───────────────────────────────────────────────────────────────── --}}
@auth
    @if (auth()->user()->application_status === 'approved')
    <div id="enrollment-bar" class="enrollment-bar">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div>
                    <div class="text-xs font-semibold" style="color: rgba(255,255,255,.5);">Selected Programs</div>
                    <div class="text-white font-bold">
                        <span id="bar-count">0</span> course(s)
                        <span class="mx-2" style="color:rgba(255,255,255,.3);">•</span>
                        Total: K<span id="bar-total">0</span>
                        <span class="badge badge-green ml-2">Free This Cohort</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <button onclick="clearSelection()"
                        class="btn-outline flex-1 sm:flex-none text-xs py-2 px-4"
                        style="border-color: rgba(255,255,255,.2); color: white;">
                    Clear
                </button>
                <form action="{{ route('enrollments.store') }}" method="POST" id="enroll-form" class="flex-1 sm:flex-none">
                    @csrf
                    <input type="hidden" name="course_ids" id="enroll-course-ids">
                    <button type="submit" class="btn-green w-full text-xs py-2 px-5">
                        Enroll Now
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
@endauth

@endsection

@push('scripts')
<script>
/* ── Course selection state ─────────────────────────────────── */
const PRICING = { 1: 1750, 2: 3000, 3: 4750 };
let selectedIds = new Set();

function getPrice(count) {
    if (count <= 0) return 0;
    if (count <= 3) return PRICING[count] ?? PRICING[3] + (count - 3) * 1750;
    return PRICING[3] + (count - 3) * 1750;
}

function toggleCourse(card) {
    const id = card.dataset.courseId;
    if (selectedIds.has(id)) {
        selectedIds.delete(id);
        card.classList.remove('selected');
    } else {
        selectedIds.add(id);
        card.classList.add('selected');
    }
    updateUI();
}

function clearSelection() {
    selectedIds.clear();
    document.querySelectorAll('.cc-card.selected').forEach(c => c.classList.remove('selected'));
    updateUI();
}

function updateUI() {
    const count = selectedIds.size;
    const total = getPrice(count);

    // Summary bar above grid
    const summary = document.getElementById('selection-summary');
    if (summary) {
        summary.classList.toggle('hidden', count === 0);
        const el = document.getElementById('selected-count');
        const tel = document.getElementById('selected-total');
        if (el) el.textContent = count;
        if (tel) tel.textContent = total.toLocaleString();
    }

    // Fixed enrollment bar
    const bar = document.getElementById('enrollment-bar');
    if (bar) {
        bar.classList.toggle('visible', count > 0);
        const bc = document.getElementById('bar-count');
        const bt = document.getElementById('bar-total');
        if (bc) bc.textContent = count;
        if (bt) bt.textContent = total.toLocaleString();
    }

    // Hidden form input
    const input = document.getElementById('enroll-course-ids');
    if (input) input.value = [...selectedIds].join(',');

    // Update button text
    document.querySelectorAll('.course-select-btn').forEach(btn => {
        const card = btn.closest('.cc-card');
        const id = card?.dataset.courseId;
        if (id && selectedIds.has(id)) {
            btn.textContent = '✓ Selected';
            btn.style.backgroundColor = 'var(--color-green)';
        } else {
            btn.textContent = 'Select Course';
            btn.style.backgroundColor = '';
        }
    });
}

/* ── Expandable modules ─────────────────────────────────────── */
function toggleModules(btn) {
    const list = btn.nextElementSibling;
    const isOpen = list.classList.toggle('open');
    btn.classList.toggle('open', isOpen);
    btn.querySelector('[data-label]') && null;
    const label = btn.querySelector('.label-text');
    if (label) label.textContent = isOpen ? 'Hide Modules' : 'View Modules';
}

/* ── Filter logic ───────────────────────────────────────────── */
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const filter = this.dataset.filter;
        document.querySelectorAll('.cc-card').forEach(card => {
            const mode     = card.dataset.mode ?? '';
            const duration = card.dataset.duration ?? '';
            const show =
                filter === 'all' ||
                (filter === 'hybrid'   && mode.includes('hybrid')) ||
                (filter === 'online'   && mode.includes('online')) ||
                (filter === '10-days'  && duration.includes('10')) ||
                (filter === '30-days'  && !duration.includes('10'));
            card.style.display = show ? '' : 'none';
        });
    });
});

/* ── FAQ accordion ──────────────────────────────────────────── */
function toggleFaq(trigger) {
    const body    = trigger.nextElementSibling;
    const icon    = trigger.querySelector('.material-symbols-outlined');
    const isOpen  = trigger.getAttribute('aria-expanded') === 'true';

    // Close all others
    document.querySelectorAll('.faq-trigger[aria-expanded="true"]').forEach(t => {
        if (t !== trigger) {
            t.setAttribute('aria-expanded', 'false');
            t.nextElementSibling.style.maxHeight = '0';
            t.querySelector('.material-symbols-outlined').style.transform = 'rotate(0deg)';
            t.style.background = 'var(--color-surface-low)';
        }
    });

    if (isOpen) {
        trigger.setAttribute('aria-expanded', 'false');
        body.style.maxHeight = '0';
        icon.style.transform = 'rotate(0deg)';
        trigger.style.background = 'var(--color-surface-low)';
    } else {
        trigger.setAttribute('aria-expanded', 'true');
        body.style.maxHeight = body.scrollHeight + 'px';
        icon.style.transform = 'rotate(180deg)';
        trigger.style.background = 'var(--color-primary-light)';
    }
}
</script>
@endpush
