{{-- resources/views/enrollment.blade.php --}}
@extends('layouts.app')

@section('title', 'Enrollment — Digital Future Labs')
@section('meta_description', 'Complete your enrollment in Digital Future Labs programs. Select your courses and provide your information.')

@push('head')
@vite(['resources/css/enrollment.css'])
@endpush

@section('content')
<div class="enroll-page">

    {{-- Hero --}}
    <div class="enroll-hero">
        <div class="enroll-hero__inner">
            <p class="section-eyebrow" style="color: var(--color-green);">Begin Your Journey</p>
            <h1 class="enroll-hero__title">Complete Your Enrollment</h1>
            <p class="enroll-hero__sub">Select your courses and fill in your details to secure your spot in the upcoming cohort.</p>
        </div>
    </div>

    {{-- Body --}}
    <div class="enroll-body">
        <form id="enrollment-form" method="POST" action="{{ route('enrollment.store') }}">
            @csrf

            <div class="enroll-grid">

                {{-- ── LEFT: Personal Info ── --}}
                <div class="enroll-main">
                    <div class="enroll-card">
                        <div class="enroll-card__eyebrow">
                            <span class="material-symbols-outlined">person</span>
                            Personal Information
                        </div>

                        <div class="enroll-fields">

                            <div class="field-row field-row--2">
                                <div class="field-group">
                                    <label for="full_name" class="field-label">Full Name <span class="req">*</span></label>
                                    <input type="text" id="full_name" name="full_name"
                                           class="field-input @error('full_name') is-invalid @enderror"
                                           value="{{ old('full_name') }}" placeholder="e.g. John Banda" required>
                                    @error('full_name')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                                <div class="field-group">
                                    <label for="email" class="field-label">Email Address <span class="req">*</span></label>
                                    <input type="email" id="email" name="email"
                                           class="field-input @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" placeholder="you@example.com" required>
                                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="field-row field-row--2">
                                <div class="field-group">
                                    <label for="phone" class="field-label">Phone Number <span class="req">*</span></label>
                                    <input type="tel" id="phone" name="phone"
                                           class="field-input @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}" placeholder="+260 97X XXX XXX" required>
                                    @error('phone')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                                <div class="field-group">
                                    <label for="nrc" class="field-label">NRC Number <span class="req">*</span></label>
                                    <input type="text" id="nrc" name="nrc"
                                           class="field-input @error('nrc') is-invalid @enderror"
                                           value="{{ old('nrc') }}" placeholder="123456/78/1" required>
                                    @error('nrc')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="field-row field-row--2">
                                <div class="field-group">
                                    <label for="age_range" class="field-label">Age Range <span class="req">*</span></label>
                                    <select id="age_range" name="age_range"
                                            class="field-input @error('age_range') is-invalid @enderror" required>
                                        <option value="">Select age range</option>
                                        <option value="18-24" {{ old('age_range') == '18-24' ? 'selected' : '' }}>18–24 years</option>
                                        <option value="25-34" {{ old('age_range') == '25-34' ? 'selected' : '' }}>25–34 years</option>
                                        <option value="35-44" {{ old('age_range') == '35-44' ? 'selected' : '' }}>35–44 years</option>
                                        <option value="45+"   {{ old('age_range') == '45+'   ? 'selected' : '' }}>45+ years</option>
                                    </select>
                                    @error('age_range')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                                <div class="field-group">
                                    <label for="location" class="field-label">Location <span class="req">*</span></label>
                                    <input type="text" id="location" name="location"
                                           class="field-input @error('location') is-invalid @enderror"
                                           value="{{ old('location') }}" placeholder="City, Province" required>
                                    @error('location')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="field-group">
                                <label for="education_level" class="field-label">Level of Education <span class="req">*</span></label>
                                <select id="education_level" name="education_level"
                                        class="field-input @error('education_level') is-invalid @enderror" required>
                                    <option value="">Select education level</option>
                                    <option value="secondary"   {{ old('education_level') == 'secondary'   ? 'selected' : '' }}>Secondary School</option>
                                    <option value="certificate" {{ old('education_level') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                    <option value="diploma"     {{ old('education_level') == 'diploma'     ? 'selected' : '' }}>Diploma</option>
                                    <option value="bachelor"    {{ old('education_level') == 'bachelor'    ? 'selected' : '' }}>Bachelor's Degree</option>
                                    <option value="master"      {{ old('education_level') == 'master'      ? 'selected' : '' }}>Master's Degree</option>
                                    <option value="other"       {{ old('education_level') == 'other'       ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('education_level')<span class="form-error">{{ $message }}</span>@enderror
                            </div>

                            <div class="field-group">
                                <label class="field-label">Employment Status <span class="req">*</span></label>
                                <div class="pill-group">
                                    @foreach(['student' => 'Student', 'employed' => 'Employed', 'self-employed' => 'Self-employed', 'unemployed' => 'Unemployed'] as $val => $lbl)
                                    <label class="pill">
                                        <input type="radio" name="employment_status" value="{{ $val }}"
                                               {{ old('employment_status') == $val ? 'checked' : '' }} required>
                                        <span>{{ $lbl }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('employment_status')<span class="form-error">{{ $message }}</span>@enderror
                            </div>

                            <div id="workplace-field" class="field-group" style="display:none;">
                                <label for="workplace" class="field-label">Where do you work?</label>
                                <input type="text" id="workplace" name="workplace"
                                       class="field-input @error('workplace') is-invalid @enderror"
                                       value="{{ old('workplace') }}" placeholder="Company / Organization">
                                @error('workplace')<span class="form-error">{{ $message }}</span>@enderror
                            </div>

                            <div class="field-group">
                                <label for="reason" class="field-label">Reason for Enrollment <span class="req">*</span></label>
                                <textarea id="reason" name="reason" rows="4"
                                          class="field-input field-textarea @error('reason') is-invalid @enderror"
                                          placeholder="Share why you're interested in this program…" required>{{ old('reason') }}</textarea>
                                <span class="field-hint">1–2 sentences is enough</span>
                                @error('reason')<span class="form-error">{{ $message }}</span>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── RIGHT: Courses + Summary ── --}}
                <div class="enroll-sidebar">
                    <div class="enroll-sidebar__sticky">

                        <div class="enroll-card">
                            <div class="enroll-card__eyebrow">
                                <span class="material-symbols-outlined">school</span>
                                Select Courses
                            </div>
                            <p class="enroll-card__sub">Choose at least 1 course.</p>

                            <div class="courses-list" id="courses-list">
                                @foreach($courses as $course)
                                <label class="course-card @if(old('courses') && in_array($course->id, old('courses'))) selected @endif"
                                       data-course-id="{{ $course->id }}"
                                       data-course-price="{{ $course->price }}"
                                       data-sponsored="{{ $course->is_sponsored ? 'true' : 'false' }}">
                                    <input type="checkbox" name="courses[]" value="{{ $course->id }}"
                                           class="course-checkbox sr-only"
                                           @if(old('courses') && in_array($course->id, old('courses'))) checked @endif>
                                    <div class="course-check">
                                        <span class="material-symbols-outlined">check</span>
                                    </div>
                                    <div class="course-info">
                                        <span class="course-title">{{ $course->title }}</span>
                                        <div class="course-meta">
                                            <span class="course-meta-item">
                                                <span class="material-symbols-outlined">schedule</span>
                                                {{ $course->duration ?? '10 Days' }}
                                            </span>
                                            <span class="course-meta-item">
                                                <span class="material-symbols-outlined">devices</span>
                                                {{ $course->mode ?? 'Hybrid' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="course-price-wrap">
                                        @if($course->is_sponsored)
                                            <span class="course-price course-price-free">FREE</span>
                                        @else
                                            <span class="course-price">K{{ number_format($course->price) }}</span>
                                        @endif
                                    </div>
                                </label>
                                @endforeach
                            </div>

                            @error('courses')
                                <span class="form-error" style="margin-top:0.5rem; display:block;">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Pricing Summary --}}
                        <div class="pricing-summary" id="pricing-summary">
                            <div class="pricing-row">
                                <span>Courses selected</span>
                                <span id="selected-count" class="pricing-count">0</span>
                            </div>
                            <div class="pricing-divider"></div>
                            <div class="pricing-total-row">
                                <span>Total</span>
                                <span id="total-price" class="pricing-amount">K0</span>
                            </div>
                            <p class="pricing-note">Total is the sum of the courses you select.</p>
                        </div>

                        <button type="submit" class="btn-submit" id="submit-btn">
                            Submit Application
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>

                    </div>
                </div>

            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
@vite(['resources/js/enrollment.js'])
@endpush
