<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-white tracking-tight mb-3">Connexion</h2>
        <div class="h-1.5 w-16 bg-blue-500 mx-auto rounded-full"></div>
        <p class="text-slate-400 mt-4 font-medium">Portail de gestion des soutenances</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" :value="__('Adresse Email')" class="text-slate-300 font-bold mb-2 block group-focus-within:text-blue-400 transition-colors" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-400 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus class="block w-full pl-12 pr-4 py-4 bg-slate-900/50 border border-slate-700 rounded-2xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300" placeholder="votre.email@horebip.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="group">
            <div class="flex items-center justify-between mb-2">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-slate-300 font-bold group-focus-within:text-blue-400 transition-colors" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-blue-400 hover:text-blue-300 transition" href="{{ route('password.request') }}">
                        {{ __('Oublié ?') }}
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-400 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" type="password" name="password" required class="block w-full pl-12 pr-4 py-4 bg-slate-900/50 border border-slate-700 rounded-2xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-5 h-5 rounded-md bg-slate-900 border-slate-700 text-blue-500 focus:ring-blue-500/50 focus:ring-offset-slate-900 transition" name="remember">
                <span class="ms-3 text-sm font-medium text-slate-400 hover:text-slate-300 transition">{{ __('Rester connecté') }}</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full btn-premium py-4 text-lg">
                {{ __('Se connecter au portail') }}
            </button>
        </div>

        <div class="text-center mt-8">
            <p class="text-slate-500 font-medium italic">
                L'accès est réservé aux membres inscrits par l'administration.
            </p>
        </div>
    </form>
</x-guest-layout>
