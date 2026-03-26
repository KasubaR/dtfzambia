{{-- resources/views/public/enrollment/verify.blade.php --}}
@extends('layouts.app')

@section('title', 'Verify Your Email — Digital Future Labs')
@section('meta_description', 'Enter the verification code sent to your email to complete your enrollment.')

@push('head')
<style>
    .verify-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 1rem;
        background: linear-gradient(135deg, var(--color-surface) 0%, var(--color-primary-light) 100%);
    }

    .verify-card {
        max-width: 460px;
        width: 100%;
        background: var(--color-white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        animation: fadeInUp 0.5s ease;
    }

    .verify-header {
        background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
        padding: 2rem;
        text-align: center;
        color: var(--color-white);
    }

    .verify-icon {
        width: 72px;
        height: 72px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .verify-icon .material-symbols-outlined {
        font-size: 2.5rem;
    }

    .verify-header h1 {
        font-size: 1.5rem;
        margin: 0 0 0.4rem 0;
        color: var(--color-white);
    }

    .verify-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 0.9rem;
    }

    .verify-email-hint {
        display: inline-block;
        margin-top: 0.6rem;
        background: rgba(255,255,255,0.15);
        border-radius: 999px;
        padding: 0.2rem 0.9rem;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    .verify-body {
        padding: 2rem;
    }

    /* OTP boxes */
    .otp-row {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .otp-box {
        width: 52px;
        height: 60px;
        border: 2px solid var(--color-border);
        border-radius: var(--radius-md);
        font-size: 1.75rem;
        font-weight: 800;
        text-align: center;
        color: var(--color-text);
        background: var(--color-surface-low);
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        outline: none;
        caret-color: var(--color-primary);
        font-family: monospace;
    }

    .otp-box:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        background: var(--color-white);
    }

    .otp-box.has-error {
        border-color: var(--color-red, #ef4444);
    }

    .otp-error {
        color: var(--color-red, #ef4444);
        font-size: 0.8rem;
        text-align: center;
        margin: -0.75rem 0 1rem 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
    }

    .otp-error .material-symbols-outlined {
        font-size: 1rem;
    }

    .btn-verify {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.9rem;
        background: var(--color-primary);
        color: var(--color-white);
        border: none;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-verify:hover {
        background: var(--color-primary-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .verify-footer {
        border-top: 1px solid var(--color-border);
        padding: 1.25rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        font-size: 0.8rem;
    }

    .resend-form button {
        background: none;
        border: none;
        color: var(--color-primary);
        font-weight: 600;
        cursor: pointer;
        font-size: 0.8rem;
        padding: 0;
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    .resend-form button:hover {
        color: var(--color-primary-dark);
    }

    .back-link {
        color: var(--color-text-muted);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }

    .back-link:hover {
        color: var(--color-text);
    }

    .back-link .material-symbols-outlined {
        font-size: 1rem;
    }

    .alert-success {
        background: rgba(22, 163, 74, 0.08);
        border: 1px solid rgba(22, 163, 74, 0.3);
        color: var(--color-green-dark, #15803d);
        border-radius: var(--radius-md);
        padding: 0.6rem 0.9rem;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 1.25rem;
    }

    .alert-success .material-symbols-outlined {
        font-size: 1rem;
    }

    .alert-warning {
        background: rgba(234, 179, 8, 0.08);
        border: 1px solid rgba(234, 179, 8, 0.35);
        color: #92400e;
        border-radius: var(--radius-md);
        padding: 0.6rem 0.9rem;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 1.25rem;
    }

    .alert-warning .material-symbols-outlined {
        font-size: 1rem;
    }

    .expires-note {
        text-align: center;
        font-size: 0.75rem;
        color: var(--color-text-muted);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
    }

    .expires-note .material-symbols-outlined {
        font-size: 0.9rem;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 400px) {
        .otp-box { width: 42px; height: 52px; font-size: 1.5rem; }
        .otp-row { gap: 0.35rem; }
    }
</style>
@endpush

@section('content')
<div class="verify-container">
    <div class="verify-card">

        <div class="verify-header">
            <div class="verify-icon">
                <span class="material-symbols-outlined">mark_email_unread</span>
            </div>
            <h1>Check your email</h1>
            <p>We sent a 6-digit code to</p>
            <span class="verify-email-hint">{{ $enrollment->email }}</span>
        </div>

        <div class="verify-body">

            @if(session('resent'))
            <div class="alert-success">
                <span class="material-symbols-outlined">check_circle</span>
                A new code has been sent to your email.
            </div>
            @endif

            @if(session('resend_error'))
            <div class="alert-warning">
                <span class="material-symbols-outlined">schedule</span>
                {{ session('resend_error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('enrollment.verify.submit', $enrollment->id) }}" id="verify-form">
                @csrf

                <input type="hidden" name="code" id="code-input">

                <div class="otp-row">
                    @for ($i = 0; $i < 6; $i++)
                    <input
                        type="text"
                        inputmode="numeric"
                        maxlength="1"
                        class="otp-box @error('code') has-error @enderror"
                        data-index="{{ $i }}"
                        autocomplete="one-time-code"
                        aria-label="Digit {{ $i + 1 }}"
                    >
                    @endfor
                </div>

                @error('code')
                <div class="otp-error">
                    <span class="material-symbols-outlined">error</span>
                    {{ $message }}
                </div>
                @enderror

                <div class="expires-note">
                    <span class="material-symbols-outlined">timer</span>
                    Code expires in 15 minutes
                </div>

                <button type="submit" class="btn-verify">
                    <span class="material-symbols-outlined">verified</span>
                    Verify &amp; Complete Enrollment
                </button>

            </form>
        </div>

        <div class="verify-footer">
            <span style="color: var(--color-text-muted);">Didn't receive it?</span>
            <form method="POST" action="{{ route('enrollment.resend', $enrollment->id) }}" class="resend-form">
                @csrf
                <button type="submit">Resend code</button>
            </form>
            <a href="{{ route('enrollment.create') }}" class="back-link">
                <span class="material-symbols-outlined">arrow_back</span>
                Wrong email? Start over
            </a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const boxes   = Array.from(document.querySelectorAll('.otp-box'));
    const hidden  = document.getElementById('code-input');
    const form    = document.getElementById('verify-form');

    function sync() {
        hidden.value = boxes.map(b => b.value).join('');
    }

    boxes.forEach((box, i) => {
        box.addEventListener('input', e => {
            // Allow paste of full code into first box
            if (box.value.length > 1) {
                const digits = box.value.replace(/\D/g, '').slice(0, 6);
                digits.split('').forEach((d, j) => {
                    if (boxes[j]) boxes[j].value = d;
                });
                (boxes[digits.length - 1] || boxes[5]).focus();
                sync();
                return;
            }
            box.value = box.value.replace(/\D/g, '');
            if (box.value && i < 5) boxes[i + 1].focus();
            sync();
        });

        box.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !box.value && i > 0) {
                boxes[i - 1].value = '';
                boxes[i - 1].focus();
                sync();
            }
        });

        box.addEventListener('paste', e => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text');
            const digits = text.replace(/\D/g, '').slice(0, 6);
            digits.split('').forEach((d, j) => {
                if (boxes[j]) boxes[j].value = d;
            });
            (boxes[digits.length - 1] || boxes[5]).focus();
            sync();
        });
    });

    // Auto-submit when all 6 boxes are filled
    form.addEventListener('input', () => {
        const full = boxes.every(b => b.value !== '');
        if (full) {
            sync();
            form.submit();
        }
    });

    // Focus first empty box on load
    (boxes.find(b => !b.value) || boxes[0]).focus();
})();
</script>
@endpush
