<x-guest-layout>

    <div style="margin-bottom:2rem;">
        <p style="font-size:0.7rem;font-weight:800;text-transform:uppercase;letter-spacing:0.2em;color:#2D60FF;margin:0 0 0.5rem;">Inscription</p>
        <h1 style="font-size:1.5rem;font-weight:900;color:#1B254B;letter-spacing:-0.03em;margin:0 0 0.4rem;line-height:1.1;">Créer un compte</h1>
        <p style="font-size:0.825rem;font-weight:500;color:#A3AED0;margin:0;">Rejoignez la promotion 2026</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:1rem;">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div>
                <label class="auth-label" for="nom">Nom</label>
                <div class="input-wrap">
                    <input id="nom" name="nom" type="text" class="auth-input" value="{{ old('nom') }}" placeholder="AGBOSSOU" required autofocus>
                </div>
                <x-input-error :messages="$errors->get('nom')" />
            </div>
            <div>
                <label class="auth-label" for="prenom">Prénom</label>
                <div class="input-wrap">
                    <input id="prenom" name="prenom" type="text" class="auth-input" value="{{ old('prenom') }}" placeholder="Kévin" required>
                </div>
                <x-input-error :messages="$errors->get('prenom')" />
            </div>
        </div>

        <div>
            <label class="auth-label" for="email">Email</label>
            <div class="input-wrap">
                <span class="input-icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></span>
                <input id="email" name="email" type="email" class="auth-input" value="{{ old('email') }}" placeholder="etudiant@universite.bj" required>
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div>
                <label class="auth-label" for="matricule">Matricule</label>
                <div class="input-wrap">
                    <input id="matricule" name="matricule" type="text" class="auth-input" value="{{ old('matricule') }}" placeholder="ETU2026001" required>
                </div>
                <x-input-error :messages="$errors->get('matricule')" />
            </div>
            <div>
                <label class="auth-label" for="niveau">Niveau</label>
                <select id="niveau" name="niveau" class="auth-input">
                    <option value="Licence 3">Licence 3</option>
                    <option value="Master 1">Master 1</option>
                    <option value="Master 2">Master 2</option>
                </select>
                <x-input-error :messages="$errors->get('niveau')" />
            </div>
        </div>

        <div>
            <label class="auth-label" for="filiere">Filière</label>
            <div class="input-wrap">
                <input id="filiere" name="filiere" type="text" class="auth-input" value="{{ old('filiere') }}" placeholder="Ex : Intelligence Artificielle" required>
            </div>
            <x-input-error :messages="$errors->get('filiere')" />
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div>
                <label class="auth-label" for="password">Mot de passe</label>
                <div class="input-wrap">
                    <span class="input-icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></span>
                    <input id="password" name="password" type="password" class="auth-input" placeholder="••••••••" required autocomplete="new-password">
                </div>
                <x-input-error :messages="$errors->get('password')" />
            </div>
            <div>
                <label class="auth-label" for="password_confirmation">Confirmation</label>
                <div class="input-wrap">
                    <span class="input-icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></span>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="auth-input" placeholder="••••••••" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-auth" style="margin-top:0.5rem;">Créer mon compte</button>

        <p style="font-size:0.78rem;font-weight:500;color:#A3AED0;text-align:center;">
            Déjà membre ?
            <a href="{{ route('login') }}" class="auth-link">Se connecter</a>
        </p>
    </form>

</x-guest-layout>
