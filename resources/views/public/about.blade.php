@extends('layouts.app')

@section('title', 'About Us — Digital Future Labs')
@section('meta_description', 'Learn about Digital Future Labs: our vision, mission, and goals for practical digital skills across Zambia.')

@push('head')
@vite(['resources/css/about.css'])
@endpush

@section('content')
    {{-- HERO --}}
    <section class="about-hero">
        <div class="about-hero-inner max-w-7xl mx-auto px-6 lg:px-8 py-20 lg:py-24 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-7">
                    <p class="section-eyebrow">About Us</p>
                    <h1 class="section-title text-3xl lg:text-5xl font-extrabold mb-6">
                        Digital Future Labs — practical digital skills for real opportunities
                    </h1>
                    <p class="text-lg leading-relaxed text-[var(--color-text-muted)] max-w-2xl">
                        We are a digital skills academy focused on equipping young people, entrepreneurs, and professionals with hands-on training for the modern digital economy.
                        Our programs help participants turn skills into opportunities, businesses, and income.
                    </p>

                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('enrollment.create') }}" class="btn-primary text-sm py-4 px-8">
                            Apply Now
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </a>
                        <a href="{{ route('courses.index') }}" class="btn-outline text-sm py-4 px-8">
                            View Programs
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="card about-side-card">
                        <p class="section-eyebrow mb-3">What we train</p>
                        <h2 class="section-title text-2xl font-extrabold mb-4">Hands-on learning in key areas</h2>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-brand-blue flex-shrink-0">handyman</span>
                                <span class="text-[var(--color-text-muted)]">Digital marketing</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-brand-blue flex-shrink-0">code</span>
                                <span class="text-[var(--color-text-muted)]">Website development</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-brand-blue flex-shrink-0">palette</span>
                                <span class="text-[var(--color-text-muted)]">Graphic design</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-brand-blue flex-shrink-0">psychology_alt</span>
                                <span class="text-[var(--color-text-muted)]">AI for small businesses</span>
                            </li>
                        </ul>

                        <div class="mt-8 about-badge-row">
                            <span class="badge badge-green">Hybrid cohorts</span>
                            <span class="badge badge-blue">Mentorship</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- VISION / MISSION / GOAL --}}
    <section class="about-section">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20">
            <div class="text-center mb-16">
                <p class="section-eyebrow">Our Commitments</p>
                <h2 class="section-title text-4xl font-extrabold">Vision, mission, and goals</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card">
                    <h3 class="font-extrabold text-xl mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-green">insights</span>
                        Vision
                    </h3>
                    <p class="text-[var(--color-text-muted)] leading-relaxed">
                        To shape Africa’s digital future by empowering generations of innovators, creators, and entrepreneurs with the skills to transform their economies and communities.
                    </p>
                </div>

                <div class="card">
                    <h3 class="font-extrabold text-xl mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-green">target</span>
                        Mission
                    </h3>
                    <p class="text-[var(--color-text-muted)] leading-relaxed">
                        Our mission is to bridge the digital skills gap by providing practical training and support that enables individuals to build careers, grow businesses, and participate in the digital economy.
                    </p>
                </div>

                <div class="card">
                    <h3 class="font-extrabold text-xl mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-green">flag</span>
                        Goal
                    </h3>
                    <ul class="space-y-3 text-[var(--color-text-muted)] leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-brand-green flex-shrink-0">info</span>
                            <span>- To provide information</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-brand-green flex-shrink-0">campaign</span>
                            <span>- Advertise our programs</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-brand-green flex-shrink-0">school</span>
                            <span>- A platform for registrations and lessons, grades, and status updates</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- PLATFORM + CTA --}}
    <section class="about-platform">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-6">
                    <p class="section-eyebrow">Platform</p>
                    <h2 class="section-title text-3xl font-extrabold mb-4">
                        Register, learn, and track progress in one place
                    </h2>
                    <p class="text-[var(--color-text-muted)] leading-relaxed mb-8">
                        After you enroll, you get access to structured lesson content and progress tracking—so you always know what’s next, your current status, and how your learning is improving.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('enrollment.create') }}" class="btn-primary text-sm py-4 px-8">
                            Start Enrollment
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </a>
                        <a href="{{ route('courses.index') }}" class="btn-outline text-sm py-4 px-8">
                            Browse Programs
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-6">
                    <div class="card about-steps">
                        <div class="flex items-start gap-4">
                            <div class="about-step-icon">
                                <span class="material-symbols-outlined">person_add</span>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-lg mb-1">Register</h3>
                                <p class="text-[var(--color-text-muted)] leading-relaxed text-sm">
                                    Complete your enrollment details to join the upcoming cohort.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 mt-7">
                            <div class="about-step-icon">
                                <span class="material-symbols-outlined">menu_book</span>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-lg mb-1">Learn</h3>
                                <p class="text-[var(--color-text-muted)] leading-relaxed text-sm">
                                    Follow lessons and practical materials aligned to modern digital roles.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 mt-7">
                            <div class="about-step-icon">
                                <span class="material-symbols-outlined">progress_activity</span>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-lg mb-1">Track</h3>
                                <p class="text-[var(--color-text-muted)] leading-relaxed text-sm">
                                    View grades and status updates so you can stay on course.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

