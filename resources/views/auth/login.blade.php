<x-guest-layout>

    <div style="margin-bottom:2.5rem;">
        <p style="font-size:0.7rem;font-weight:800;text-transform:uppercase;letter-spacing:0.2em;color:#2D60FF;margin:0 0 0.6rem;">Bienvenue</p>
        <h1 style="font-size:1.75rem;font-weight:900;color:#1B254B;letter-spacing:-0.03em;margin:0 0 0.5rem;line-height:1.1;">Connectez-vous</h1>
        <p style="font-size:0.85rem;font-weight:500;color:#A3AED0;margin:0;">Portail de gestion des soutenances</p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:1.25rem;">
        @csrf

        {{-- Email --}}
        <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
                <label for="email" class="auth-label">Adresse email</label>
            </div>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="auth-input" placeholder="votre.email@exemple.com"
                    required autofocus autocomplete="username">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- Mot de passe --}}
        <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
                <label for="password" class="auth-label">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link">Oublié ?</a>
                @endif
            </div>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input id="password" type="password" name="password"
                    class="auth-input" placeholder="••••••••"
                    required autocomplete="current-password">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        {{-- Rester connecté --}}
        <label style="display:inline-flex;align-items:center;gap:0.6rem;cursor:pointer;">
            <input id="remember_me" type="checkbox" name="remember"
                style="width:16px;height:16px;border-radius:4px;accent-color:#2D60FF;cursor:pointer;">
            <span style="font-size:0.8rem;font-weight:600;color:#A3AED0;">Rester connecté</span>
        </label>

        {{-- Submit --}}
        <button type="submit" class="btn-auth" style="margin-top:0.5rem;">
            Se connecter
        </button>

        <p style="font-size:0.75rem;font-weight:500;color:#A3AED0;text-align:center;margin-top:0.5rem;line-height:1.5;">
            L'accès est réservé aux membres inscrits par l'administration.
        </p>

    </form>

</x-guest-layout>
