<x-layouts.guest>
    <x-slot:title>Login — {{ config('app.name', 'Admin Panel') }}</x-slot:title>

    <div class="min-h-screen flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-950 relative overflow-hidden">
        {{-- Background blobs for modern glassmorphism aesthetic --}}
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-500/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-purple-500/10 dark:bg-purple-500/5 rounded-full blur-3xl"></div>

        <div class="w-full max-w-md z-10">
            {{-- Logo & Brand --}}
            <div class="flex flex-col items-center mb-8">
                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30 mb-3">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 009 11V7a2 2 0 00-2-2H6a2 2 0 00-2 2v2.5M14 20.354A10.97 10.97 0 0017 13V9a2 2 0 012-2h.5m-3.5 13V11M4 4h16.5"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Selamat Datang Kembali</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Silakan masuk ke akun admin Anda</p>
            </div>

            {{-- Form Card --}}
            <div class="bg-white dark:bg-gray-900/80 backdrop-blur-md border border-gray-200 dark:border-gray-800 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none p-8">
                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <x-form.input
                        name="email"
                        type="email"
                        label="Alamat Email"
                        placeholder="nama@email.com"
                        value=""
                        :required="true"
                        :error="$errors->first('email')"
                    />

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition-colors">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <x-form.input
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            value=""
                            :required="true"
                            :error="$errors->first('password')"
                        />
                    </div>

                    <x-form.checkbox
                        name="remember"
                        label="Ingat saya di perangkat ini"
                    />

                    <x-form.button
                        type="submit"
                        variant="primary"
                        class="w-full justify-center py-3 shadow-lg shadow-indigo-500/20"
                    >
                        Masuk
                    </x-form.button>
                </form>
            </div>

            {{-- Footer Info --}}
            <div class="text-center mt-8">
                <p class="text-xs text-gray-400 dark:text-gray-500">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Admin Panel') }}. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>

        {{-- Dark Mode Toggle --}}
        <button
            @click="darkMode = !darkMode"
            class="fixed bottom-5 right-5 p-2.5 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition-all z-20"
            title="Toggle Dark Mode"
        >
            <svg x-show="!darkMode" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
            <svg x-show="darkMode" class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </button>
    </div>
</x-layouts.guest>
