{{-- resources/views/partials/course-card.blade.php
     Usage: @include('partials.course-card', ['course' => $course])
--}}
<div class="cc-card"
     data-course-id="{{ $course->id }}"
     data-price="{{ $course->price }}"
     data-mode="{{ $course->mode !== null ? strtolower($course->mode) : '' }}"
     data-duration="{{ $course->duration !== null ? strtolower(str_replace(' ', '-', $course->duration)) : '' }}">

    {{-- ── Image ──────────────────────────────────────────── --}}
    @php
        $titleLower = strtolower($course->title ?? '');
        $fallbackImage = match(true) {
            str_contains($titleLower, 'ai') || str_contains($titleLower, 'artificial') => 'AI.jpg.jpeg',
            str_contains($titleLower, 'entrepreneur')                                   => 'Entrepreneurship.jpg.jpeg',
            str_contains($titleLower, 'graphic') || str_contains($titleLower, 'design') => 'Graphic Design.jpg.jpeg',
            str_contains($titleLower, 'marketing')                                      => 'digital marketing.jpg.jpeg',
            str_contains($titleLower, 'web')                                            => 'web-design-website-coding-concept.jpg.jpeg',
            default                                                                     => null,
        };
    @endphp
    <div class="cc-image">
        @if (!empty($course->image))
            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" />
        @elseif ($fallbackImage)
            <img src="{{ asset('images/courses/' . $fallbackImage) }}" alt="{{ $course->title }}" />
        @else
            <div class="cc-image-placeholder">
                <span class="material-symbols-outlined">{{ $course->icon ?? 'menu_book' }}</span>
            </div>
        @endif

        @if($course->is_sponsored ?? false)
        <span class="cc-sponsored-badge">Sponsored</span>
        @endif
    </div>

    {{-- ── Body ───────────────────────────────────────────── --}}
    <div class="cc-body">

        {{-- Meta --}}
        <div class="cc-meta">
            <span class="material-symbols-outlined">schedule</span>
            <span>{{ $course->duration ?? '10 Days' }} &bull; {{ $course->mode ?? 'Hybrid' }}</span>
        </div>


        <h3 class="cc-title">{{ $course->title }}</h3>
        <p class="cc-desc">{{ $course->description }}</p>

        {{-- ── Footer ──────────────────────────────────────── --}}
        <div class="cc-footer">

            <div class="cc-price-row">
                <div>
                    <p class="cc-price-label">Fee</p>
                    <p class="cc-price-amount">K{{ number_format($course->price ?? 1750) }}</p>
                </div>
                <div>
                    <p class="cc-status-label">Current Status</p>
                    <p class="cc-status-value">FULLY SPONSORED</p>
                </div>
            </div>

            <div class="cc-actions">

                {{-- CTA depends on auth state --}}
                <a href="{{ route('enrollment.create') }}" class="cc-btn-apply">
                    Apply Now
                    <span class="material-symbols-outlined" style="font-size:.95rem;">arrow_forward</span>
                </a>

            </div>
        </div>

    </div>
</div>
