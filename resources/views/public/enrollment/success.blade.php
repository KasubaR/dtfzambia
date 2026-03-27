{{-- resources/views/enrollment/success.blade.php --}}
@extends('layouts.app')

@section('title', 'Enrollment Successful — Digital Future Labs')
@section('meta_description', 'Your enrollment has been successfully submitted. We\'ll contact you soon.')

@push('head')
<style>
    /* ── Hero Banner ── */
    .success-hero {
        background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%);
        padding: 3.5rem 2rem;
        padding-top: calc(3.5rem + 70px);
        text-align: center;
        color: var(--color-white);
        animation: fadeInDown 0.5s ease;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .success-icon .material-symbols-outlined {
        font-size: 3rem;
    }

    .success-hero h1 {
        font-size: 2rem;
        margin: 0 0 0.5rem 0;
        color: var(--color-white);
    }

    .success-hero p {
        margin: 0;
        opacity: 0.9;
        font-size: 1rem;
    }

    /* ── Page Body ── */
    .success-page {
        background: var(--color-surface);
        padding: 3rem 2rem;
        min-height: 50vh;
    }

    .success-grid {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.75rem;
        animation: fadeInUp 0.5s ease 0.1s both;
    }

    /* ── Cards ── */
    .info-card {
        background: var(--color-white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .info-card-header {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--color-border);
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--color-green);
    }

    .info-card-header .material-symbols-outlined {
        font-size: 1rem;
    }

    .info-card-body {
        padding: 1.25rem 1.5rem;
        flex: 1;
    }

    /* ── Summary Rows ── */
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        border-bottom: 1px solid var(--color-border);
        font-size: 0.875rem;
        gap: 1rem;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .summary-label {
        color: var(--color-text-muted);
        font-weight: 500;
        white-space: nowrap;
    }

    .summary-value {
        font-weight: 600;
        color: var(--color-text);
        text-align: right;
    }

    /* ── Courses List ── */
    .courses-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .courses-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        border-bottom: 1px solid var(--color-border);
        font-size: 0.875rem;
        gap: 1rem;
    }

    .courses-list li:last-child {
        border-bottom: none;
    }

    .course-price-col {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.2rem;
        flex-shrink: 0;
    }

    .course-price-struck {
        font-weight: 700;
        color: var(--color-text-muted);
        text-decoration: line-through;
        opacity: 0.6;
    }

    .sponsored-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--color-green);
        background: rgba(22, 163, 74, 0.1);
        border: 1px solid rgba(22, 163, 74, 0.3);
        border-radius: 999px;
        padding: 0.1rem 0.5rem 0.1rem 0.25rem;
        white-space: nowrap;
    }

    .sponsored-badge .material-symbols-outlined {
        font-size: 0.7rem;
    }

    .total-free-badge {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--color-green);
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid var(--color-border);
        gap: 1rem;
    }

    /* ── Next Steps ── */
    .next-steps-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .next-steps-list li {
        display: flex;
        gap: 0.75rem;
        font-size: 0.875rem;
        color: var(--color-text-muted);
        align-items: flex-start;
    }

    .next-steps-list li .step-num {
        flex-shrink: 0;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--color-primary-light);
        color: var(--color-primary);
        font-size: 0.7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 0.1rem;
    }

    /* ── Action Buttons ── */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.875rem;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-action-primary {
        background: var(--color-green);
        color: var(--color-white);
    }

    .btn-action-secondary {
        background: var(--color-surface-mid);
        color: var(--color-text);
    }

    .btn-action-secondary:hover {
        background: var(--color-border);
    }

    .actions-col {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .success-grid {
            grid-template-columns: 1fr;
        }

        .success-page {
            padding: 2rem 1rem;
        }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')

{{-- Hero Banner --}}
<div class="success-hero">
    <div class="success-icon">
        <span class="material-symbols-outlined">check_circle</span>
    </div>
    <h1>Enrollment Successful!</h1>
    <p>Your application has been received — we'll be in touch soon.</p>
</div>

{{-- Content Grid --}}
<div class="success-page">
    <div class="success-grid">

        {{-- Left Column: Enrollment Summary + Next Steps --}}
        <div style="display: flex; flex-direction: column; gap: 1.75rem;">

            {{-- Enrollment Summary --}}
            <div class="info-card">
                <div class="info-card-header">
                    <span class="material-symbols-outlined">person</span>
                    Enrollment Summary
                </div>
                <div class="info-card-body">
                    <div class="summary-item">
                        <span class="summary-label">Name</span>
                        <span class="summary-value">{{ $enrollment->full_name }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Email</span>
                        <span class="summary-value">{{ $enrollment->email }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Phone</span>
                        <span class="summary-value">{{ $enrollment->phone }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Location</span>
                        <span class="summary-value">{{ $enrollment->location }}</span>
                    </div>
                </div>
            </div>

            {{-- What's Next --}}
            <div class="info-card">
                <div class="info-card-header">
                    <span class="material-symbols-outlined">schedule</span>
                    What's Next?
                </div>
                <div class="info-card-body">
                    <ol class="next-steps-list">
                        <li>
                            <span class="step-num">1</span>
                            <span>You will receive a confirmation email shortly.</span>
                        </li>
                        <li>
                            <span class="step-num">2</span>
                            <span>Our admissions team will review your application within 2–3 business days.</span>
                        </li>
                        <li>
                            <span class="step-num">3</span>
                            <span>You'll be notified via email about next steps and orientation details.</span>
                        </li>
                        <li>
                            <span class="step-num">4</span>
                            <span>Questions? Reach us at <strong>info@dflzambia.com</strong></span>
                        </li>
                    </ol>
                </div>
            </div>

        </div>

        {{-- Right Column: Courses Selected + Actions --}}
        <div style="display: flex; flex-direction: column; gap: 1.75rem;">

            {{-- Courses Selected --}}
            <div class="info-card">
                <div class="info-card-header">
                    <span class="material-symbols-outlined">school</span>
                    Courses Selected
                </div>
                <div class="info-card-body">
                    <ul class="courses-list">
                        @foreach($enrollment->courses as $course)
                        <li>
                            <span>{{ $course->title }}</span>
                            <div class="course-price-col">
                                <span class="course-price-struck">K{{ number_format($course->price ?? 1750) }}</span>
                                <span class="sponsored-badge">
                                    <span class="material-symbols-outlined">volunteer_activism</span>
                                    Sponsored
                                </span>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <div class="total-row">
                        <span class="summary-label" style="font-weight: 600;">Total Price</span>
                        <div class="course-price-col">
                            <span class="summary-value" style="font-size: 1.125rem; text-decoration: line-through; opacity: 0.55; color: var(--color-text-muted);">
                                K{{ number_format($enrollment->total_price) }}
                            </span>
                            <span class="total-free-badge">FREE — Sponsored</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="actions-col">
                <a href="{{ route('home') }}" class="btn-action btn-action-primary">
                    <span class="material-symbols-outlined">home</span>
                    Back to Home
                </a>
                <a href="{{ route('courses.index') }}" class="btn-action btn-action-secondary">
                    <span class="material-symbols-outlined">school</span>
                    Browse More Courses
                </a>
            </div>

        </div>

    </div>
</div>

@endsection
