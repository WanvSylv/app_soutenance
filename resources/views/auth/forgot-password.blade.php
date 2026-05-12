<x-guest-layout>

    <div style="margin-bottom:2rem;">
        <h1 style="font-size:1.5rem;font-weight:900;color:#1B254B;letter-spacing:-0.03em;margin:0 0 0.5rem;">Mot de passe oublié</h1>
        <p style="font-size:0.825rem;font-weight:500;color:#A3AED0;margin:0;line-height:1.6;">Renseignez votre email et nous vous enverrons un lien de réinitialisation.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" style="display:flex;flex-direction:column;gap:1.25rem;">
        @csrf
        <div>
            <label class="auth-label" for="email">Adresse email</label>
            <div class="input-wrap">
                <span class="input-icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></span>
                <input id="email" name="email" type="email" class="auth-input" value="{{ old('email') }}" placeholder="votre.email@exemple.com" required autofocus>
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <button type="submit" class="btn-auth">Envoyer le lien</button>
        <p style="text-align:center;"><a href="{{ route('login') }}" class="auth-link">Retour à la connexion</a></p>
    </form>

</x-guest-layout>
