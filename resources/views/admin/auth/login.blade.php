<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Digital Future Labs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-sm">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/DFL-Logo-Files-02.svg') }}" alt="Digital Future Labs" class="h-10 mx-auto mb-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-4"
                 style="background:#ede9fe; color:#6d28d9;">
                <span class="material-symbols-outlined" style="font-size:14px;">admin_panel_settings</span>
                Admin Access
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900">Sign in to Dashboard</h1>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            @if ($errors->any())
                <div class="mb-5 p-3 rounded-lg text-sm" style="background:#fef2f2; color:#b91c1c; border:1px solid #fecaca;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm outline-none focus:border-violet-400 focus:ring-2 focus:ring-violet-100 transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="w-full px-4 py-2.5 pr-11 rounded-lg border border-gray-200 text-sm outline-none focus:border-violet-400 focus:ring-2 focus:ring-violet-100 transition">
                        <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 transition">
                            <span class="material-symbols-outlined" id="toggle-icon" style="font-size:18px;">visibility</span>
                        </button>
                    </div>
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-500 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    Keep me signed in
                </label>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg text-sm font-semibold text-white transition"
                        style="background:#6d28d9;"
                        onmouseover="this.style.background='#5b21b6'"
                        onmouseout="this.style.background='#6d28d9'">
                    <span class="material-symbols-outlined" style="font-size:16px;">login</span>
                    Sign In
                </button>
            </form>

        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            This page is restricted to authorised personnel only.
        </p>

    </div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('toggle-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>
</body>
</html>
