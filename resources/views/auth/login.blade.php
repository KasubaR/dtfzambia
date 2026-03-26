@extends('layouts.app')

@section('title', 'Sign In — Digital Future Labs')

@section('content')
<div class="min-h-screen flex items-center justify-center py-16 px-6" style="background: var(--color-surface);">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold mb-2" style="font-family: var(--font-headline); color: var(--color-text);">Welcome Back</h1>
            <p style="color: var(--color-text-muted);">Sign in to your Digital Future Labs account.</p>
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

            @if (session('status'))
                <div class="mb-4 p-3 rounded-lg text-sm" style="background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color: var(--color-text);">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-lg border text-sm outline-none"
                           style="border-color: var(--color-border);">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color: var(--color-text);">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 rounded-lg border text-sm outline-none"
                           style="border-color: var(--color-border);">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm" style="color: var(--color-text-muted);">
                        <input type="checkbox" name="remember" class="rounded">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full justify-center">
                    Sign In
                    <span class="material-symbols-outlined text-sm">login</span>
                </button>
            </form>


        </div>
    </div>
</div>
@endsection
