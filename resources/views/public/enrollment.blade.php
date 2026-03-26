{{-- resources/views/enrollment.blade.php --}}
@extends('layouts.app')

@section('title', 'Enrollment — Digital Future Labs')
@section('meta_description', 'Complete your enrollment in Digital Future Labs programs. Select your courses and provide your information.')

@push('head')
@vite(['resources/css/enrollment.css'])
@endpush

@section('content')
<div class="enrollment-container">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12 lg:py-16">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <p class="section-eyebrow">Begin Your Journey</p>
            <h1 class="section-title text-3xl lg:text-4xl font-extrabold mb-4">
                Complete Your Enrollment
            </h1>
            <p class="text-lg" style="color: var(--color-text-muted); max-width: 600px; margin: 0 auto;">
                Select your courses and provide your information to secure your spot in the upcoming cohort.
            </p>
        </div>

        {{-- Main Form --}}
        <form id="enrollment-form" method="POST" action="{{ route('enrollment.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left Column: Personal Information --}}
                <div class="lg:col-span-2">
                    <div class="form-section">
                        <div class="form-section-header">
                            <span class="material-symbols-outlined">person</span>
                            <h2>Personal Information</h2>
                        </div>
                        
                        <div class="form-section-body">
                            {{-- Full Name --}}
                            <div class="form-group">
                                <label for="full_name" class="form-label required">Full Name</label>
                                <input type="text" 
                                       id="full_name" 
                                       name="full_name" 
                                       class="form-input @error('full_name') is-invalid @enderror" 
                                       value="{{ old('full_name') }}"
                                       required>
                                @error('full_name')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group">
                                <label for="email" class="form-label required">Email Address</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-input @error('email') is-invalid @enderror" 
                                       value="{{ old('email', auth()->user()->email ?? '') }}"
                                       required>
                                @error('email')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone Number --}}
                            <div class="form-group">
                                <label for="phone" class="form-label required">Phone Number</label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       class="form-input @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}"
                                       placeholder="+260 97X XXX XXX"
                                       required>
                                @error('phone')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NRC --}}
                            <div class="form-group">
                                <label for="nrc" class="form-label required">NRC Number</label>
                                <input type="text" 
                                       id="nrc" 
                                       name="nrc" 
                                       class="form-input @error('nrc') is-invalid @enderror" 
                                       value="{{ old('nrc') }}"
                                       placeholder="123456/78/1"
                                       required>
                                @error('nrc')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Age Range --}}
                            <div class="form-group">
                                <label for="age_range" class="form-label required">Age Range</label>
                                <select id="age_range" name="age_range" class="form-select @error('age_range') is-invalid @enderror" required>
                                    <option value="">Select age range</option>
                                    <option value="18-24" {{ old('age_range') == '18-24' ? 'selected' : '' }}>18-24 years</option>
                                    <option value="25-34" {{ old('age_range') == '25-34' ? 'selected' : '' }}>25-34 years</option>
                                    <option value="35-44" {{ old('age_range') == '35-44' ? 'selected' : '' }}>35-44 years</option>
                                    <option value="45+" {{ old('age_range') == '45+' ? 'selected' : '' }}>45+ years</option>
                                </select>
                                @error('age_range')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Location --}}
                            <div class="form-group">
                                <label for="location" class="form-label required">Location</label>
                                <input type="text" 
                                       id="location" 
                                       name="location" 
                                       class="form-input @error('location') is-invalid @enderror" 
                                       value="{{ old('location') }}"
                                       placeholder="City, Province"
                                       required>
                                @error('location')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Level of Education --}}
                            <div class="form-group">
                                <label for="education_level" class="form-label required">Level of Education</label>
                                <select id="education_level" name="education_level" class="form-select @error('education_level') is-invalid @enderror" required>
                                    <option value="">Select education level</option>
                                    <option value="secondary" {{ old('education_level') == 'secondary' ? 'selected' : '' }}>Secondary School</option>
                                    <option value="certificate" {{ old('education_level') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                    <option value="diploma" {{ old('education_level') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                    <option value="bachelor" {{ old('education_level') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                    <option value="master" {{ old('education_level') == 'master' ? 'selected' : '' }}>Master's Degree</option>
                                    <option value="other" {{ old('education_level') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('education_level')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Employment Status --}}
                            <div class="form-group">
                                <label class="form-label required">Employment Status</label>
                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="employment_status" value="student" {{ old('employment_status') == 'student' ? 'checked' : '' }} required>
                                        <span>Student</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="employment_status" value="employed" {{ old('employment_status') == 'employed' ? 'checked' : '' }}>
                                        <span>Employed</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="employment_status" value="self-employed" {{ old('employment_status') == 'self-employed' ? 'checked' : '' }}>
                                        <span>Self-employed</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="employment_status" value="unemployed" {{ old('employment_status') == 'unemployed' ? 'checked' : '' }}>
                                        <span>Unemployed</span>
                                    </label>
                                </div>
                                @error('employment_status')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Conditional: Where do you work? --}}
                            <div id="workplace-field" class="form-group" style="display: none;">
                                <label for="workplace" class="form-label">Where do you work?</label>
                                <input type="text" 
                                       id="workplace" 
                                       name="workplace" 
                                       class="form-input @error('workplace') is-invalid @enderror" 
                                       value="{{ old('workplace') }}"
                                       placeholder="Company/Organization name">
                                @error('workplace')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Reason for Enrollment --}}
                            <div class="form-group">
                                <label for="reason" class="form-label required">Reason for Enrollment</label>
                                <textarea id="reason" 
                                          name="reason" 
                                          rows="4" 
                                          class="form-textarea @error('reason') is-invalid @enderror" 
                                          required>{{ old('reason') }}</textarea>
                                <small class="form-hint">Please share why you're interested in this program (1-2 sentences)</small>
                                @error('reason')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Course Selection & Pricing --}}
                <div class="lg:col-span-1">
                    
                    {{-- Course Selection --}}
                    <div class="form-section">
                        <div class="form-section-header">
                            <span class="material-symbols-outlined">school</span>
                            <h2>Select Courses</h2>
                        </div>
                        
                        <div class="form-section-body">
                            <p class="text-sm mb-4" style="color: var(--color-text-muted);">
                                Choose at least 1 course. You can select up to 3 courses for optimal pricing.
                            </p>
                            
                            <div id="courses-list" class="courses-list">
                                @foreach($courses as $course)
                                <label class="course-card @if(old('courses') && in_array($course->id, old('courses'))) selected @endif" data-course-id="{{ $course->id }}" data-course-price="{{ $course->price ?? 1750 }}">
                                    <input type="checkbox" 
                                           name="courses[]" 
                                           value="{{ $course->id }}" 
                                           class="course-checkbox"
                                           @if(old('courses') && in_array($course->id, old('courses'))) checked @endif>
                                    <div class="course-info">
                                        <h3 class="course-title">{{ $course->title }}</h3>
                                        <div class="course-meta">
                                            <span class="course-meta-item">
                                                <span class="material-symbols-outlined">schedule</span>
                                                {{ $course->duration ?? '10 Days' }}
                                            </span>
                                            <span class="course-meta-item">
                                                <span class="material-symbols-outlined">school</span>
                                                {{ $course->mode ?? 'Hybrid' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="course-price-wrap">
                                        <div class="course-price">K{{ number_format($course->price ?? 1750) }}</div>
                                        <div class="course-sponsored-badge">
                                            <span class="material-symbols-outlined">volunteer_activism</span>
                                            Sponsored
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            
                            @error('courses')
                                <div class="form-error mt-3">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Pricing Summary --}}
                    <div class="pricing-summary" id="pricing-summary">
                        <h3 class="pricing-summary-title">Pricing Summary</h3>
                        <div class="pricing-row">
                            <span>Selected Courses:</span>
                            <span id="selected-count">0</span>
                        </div>
                        <div class="pricing-row pricing-total">
                            <span>Total Price:</span>
                            <span class="pricing-total-wrap">
                                <span id="total-price">K0</span>
                                <span id="total-free-badge">FREE — Sponsored</span>
                            </span>
                        </div>
                        <div class="pricing-note">
                            <span class="material-symbols-outlined">info</span>
                            <small>Pricing: 1 course = K1,750 | 2 courses = K3,000 | 3+ courses = K4,750</small>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn-submit" id="submit-btn">
                        <span class="material-symbols-outlined">check_circle</span>
                        Submit Enrollment
                    </button>
                    
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/enrollment.js'])
@endpush