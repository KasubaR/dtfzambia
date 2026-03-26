{{-- resources/views/enrollment/success.blade.php --}}
@extends('layouts.app')

@section('title', 'Enrollment Successful — Digital Future Labs')
@section('meta_description', 'Your enrollment has been successfully submitted. We\'ll contact you soon.')

@push('head')
<style>
    .success-container {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 1rem;
        background: linear-gradient(135deg, var(--color-surface) 0%, var(--color-primary-light) 100%);
    }
    
    .success-card {
        max-width: 600px;
        width: 100%;
        background: var(--color-white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
    }
    
    .success-header {
        background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%);
        padding: 2rem;
        text-align: center;
        color: var(--color-white);
    }
    
    .success-icon {
        font-size: 4rem;
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
    
    .success-header h1 {
        font-size: 1.75rem;
        margin: 0 0 0.5rem 0;
        color: var(--color-white);
    }
    
    .success-header p {
        margin: 0;
        opacity: 0.9;
    }
    
    .success-body {
        padding: 2rem;
    }
    
    .summary-section {
        background: var(--color-surface-low);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .summary-section h3 {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--color-green);
        margin: 0 0 1rem 0;
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--color-border);
        font-size: 0.875rem;
    }
    
    .summary-item:last-child {
        border-bottom: none;
    }
    
    .summary-label {
        color: var(--color-text-muted);
        font-weight: 500;
    }
    
    .summary-value {
        font-weight: 600;
        color: var(--color-text);
    }
    
    .courses-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .courses-list li {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--color-border);
        font-size: 0.875rem;
    }
    
    .courses-list li:last-child {
        border-bottom: none;
    }
    
    .next-steps {
        background: var(--color-primary-light);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .next-steps h3 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
        margin: 0 0 1rem 0;
        color: var(--color-primary);
    }
    
    .next-steps ul {
        margin: 0;
        padding-left: 1.5rem;
    }
    
    .next-steps li {
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        color: var(--color-text-muted);
    }
    
    .btn-dashboard {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.875rem;
        background: var(--color-primary);
        color: var(--color-white);
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
    
    .btn-dashboard:hover {
        background: var(--color-primary-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <div class="success-card">
        
        <div class="success-header">
            <div class="success-icon">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <h1>Enrollment Successful!</h1>
            <p>Your application has been received</p>
        </div>
        
        <div class="success-body">
            
            {{-- Summary Section --}}
            <div class="summary-section">
                <h3>Enrollment Summary</h3>
                
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
            
            {{-- Courses Selected --}}
            <div class="summary-section">
                <h3>Courses Selected</h3>
                <ul class="courses-list">
                    @foreach($enrollment->courses as $course)
                    <li>
                        <span>{{ $course->title }}</span>
                        <span class="summary-value">K{{ number_format($course->price ?? 1750) }}</span>
                    </li>
                    @endforeach
                </ul>
                
                <div class="summary-item" style="margin-top: 1rem; padding-top: 1rem; border-top: 2px solid var(--color-border);">
                    <span class="summary-label">Total Price</span>
                    <span class="summary-value" style="font-size: 1.125rem; color: var(--color-primary);">
                        K{{ number_format($enrollment->total_price) }}
                    </span>
                </div>
            </div>
            
            {{-- Next Steps --}}
            <div class="next-steps">
                <h3>
                    <span class="material-symbols-outlined">schedule</span>
                    What's Next?
                </h3>
                <ul>
                    <li>You will receive a confirmation email shortly</li>
                    <li>Our admissions team will review your application within 2-3 business days</li>
                    <li>You'll be notified via email about the next steps and orientation details</li>
                    <li>If you have any questions, please contact us at info@digitalfuturelabs.co.zm</li>
                </ul>
            </div>
            
            {{-- Action Buttons --}}
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('home') }}" class="btn-dashboard" style="background: var(--color-green);">
                    <span class="material-symbols-outlined">home</span>
                    Back to Home
                </a>
                <a href="{{ route('courses.index') }}" class="btn-dashboard" style="background: var(--color-surface-mid); color: var(--color-text);">
                    <span class="material-symbols-outlined">school</span>
                    Browse More Courses
                </a>
            </div>
            
        </div>
        
    </div>
</div>
@endsection