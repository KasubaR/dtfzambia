@extends('layouts.app')

@section('title', 'Register — Digital Future Labs')

@section('content')
<div class="min-h-screen flex items-center justify-center py-16 px-6" style="background: var(--color-surface);">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold mb-2" style="font-family: var(--font-headline); color: var(--color-text);">Create Account</h1>
            <p style="color: var(--color-text-muted);">Join Digital Future Labs and start learning.</p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-sm border" style="border-color: var(--color-border);">

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg text-sm" style="background:#fef2f2; color:#b91c1c; border:1px solid #fecaca;">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color: var(--color-text);">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-lg border text-sm outline-none focus:ring-2"
                           style="border-color: var(--color-border); focus:ring-color: var(--color-primary);">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color: var(--color-text);">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2.5 rounded-lg border text-sm outline-none"
                           style="border-color: var(--color-border);">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color: var(--color-text);">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 rounded-lg border text-sm outline-none"
                           style="border-color: var(--color-border);">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color: var(--color-text);">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2.5 rounded-lg border text-sm outline-none"
                           style="border-color: var(--color-border);">
                </div>

                <button type="submit" class="btn-primary w-full justify-center">
                    Create Account
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </form>

            <p class="text-center text-sm mt-6" style="color: var(--color-text-muted);">
                Already have an account?
                <a href="{{ route('login') }}" style="color: var(--color-primary); font-weight:700;">Sign in</a>
            </p>

        </div>
    </div>
</div>
@endsection
