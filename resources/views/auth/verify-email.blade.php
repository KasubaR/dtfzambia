@extends('layouts.app')

@section('title', 'Verify Email — Digital Future Labs')

@section('content')
<div class="min-h-screen flex items-center justify-center py-16 px-6" style="background: var(--color-surface);">
    <div class="w-full max-w-md text-center">

        <span class="material-symbols-outlined text-5xl mb-4 block" style="color: var(--color-primary);">mark_email_unread</span>
        <h1 class="text-2xl font-extrabold mb-2" style="font-family: var(--font-headline); color: var(--color-text);">Verify Your Email</h1>
        <p class="mb-6" style="color: var(--color-text-muted);">
            Please check your inbox and click the verification link we sent you before continuing.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="mb-4 p-3 rounded-lg text-sm" style="background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                A new verification link has been sent to your email.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary">
                Resend Verification Email
                <span class="material-symbols-outlined text-sm">send</span>
            </button>
        </form>

    </div>
</div>
@endsection
