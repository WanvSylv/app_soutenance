<x-guest-layout>

    <div style="margin-bottom:2rem;">
        <h1 style="font-size:1.5rem;font-weight:900;color:#1B254B;letter-spacing:-0.03em;margin:0 0 0.5rem;">Nouveau mot de passe</h1>
        <p style="font-size:0.825rem;font-weight:500;color:#A3AED0;margin:0;">Choisissez un nouveau mot de passe sécurisé.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" style="display:flex;flex-direction:column;gap:1.25rem;">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="auth-label" for="email">Email</label>
            <div class="input-wrap">
                <span class="input-icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></span>
                <input id="email" name="email" type="email" class="auth-input" value="{{ old('email', $request->email) }}" required autofocus>
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <label class="auth-label" for="password">Nouveau mot de passe</label>
            <div class="input-wrap">
                <span class="input-icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></span>
                <input id="password" name="password" type="password" class="auth-input" placeholder="••••••••" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <label class="auth-label" for="password_confirmation">Confirmer</label>
            <div class="input-wrap">
                <span class="input-icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></span>
                <input id="password_confirmation" name="password_confirmation" type="password" class="auth-input" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn-auth">Réinitialiser le mot de passe</button>
    </form>

</x-guest-layout>
