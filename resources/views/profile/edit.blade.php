<x-app-layout>
@section('header', 'Mon profil')

<div style="display:flex;flex-direction:column;gap:1.5rem;max-width:720px;">

    {{-- Carte photo + infos --}}
    <div class="form-card" x-data="{ photoPreview: null }">
        <div class="form-section-title">Informations personnelles</div>

        @if(session('status') === 'profile-updated')
            <div style="display:flex;align-items:center;gap:0.6rem;background:#ECFDF5;border:1px solid #6EE7B7;border-radius:8px;padding:0.75rem 1rem;margin-bottom:1.25rem;font-size:0.8rem;font-weight:600;color:#065F46;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Profil mis à jour avec succès.
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            {{-- Photo --}}
            <div class="photo-upload" style="margin-bottom:1.5rem;">
                <div class="photo-preview">
                    <template x-if="!photoPreview">
                        @if(auth()->user()->photo_path)
                            <img src="{{ asset(auth()->user()->photo_path) }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <svg width="28" height="28" fill="none" stroke="#A3AED0" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @endif
                    </template>
                    <template x-if="photoPreview">
                        <img :src="photoPreview" style="width:100%;height:100%;object-fit:cover;">
                    </template>
                </div>
                <div>
                    <label for="photo" class="photo-label">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Changer la photo
                        <input type="file" id="photo" name="photo" class="hidden" accept="image/*"
                            @change="const f=$event.target.files[0];if(f){const r=new FileReader();r.onload=e=>photoPreview=e.target.result;r.readAsDataURL(f);}">
                    </label>
                    <div style="font-size:0.72rem;color:#A3AED0;margin-top:0.4rem;">JPG, PNG — max 2 Mo</div>
                    <x-input-error :messages="$errors->get('photo')" />
                </div>
            </div>

            {{-- Champs --}}
            <div class="form-grid">
                <div class="form-field">
                    <label class="form-label" for="nom">Nom</label>
                    <input id="nom" name="nom" type="text" class="form-input" value="{{ old('nom', auth()->user()->nom) }}" required>
                    <x-input-error :messages="$errors->get('nom')" />
                </div>
                <div class="form-field">
                    <label class="form-label" for="prenom">Prénom(s)</label>
                    <input id="prenom" name="prenom" type="text" class="form-input" value="{{ old('prenom', auth()->user()->prenom) }}" required>
                    <x-input-error :messages="$errors->get('prenom')" />
                </div>
                <div class="form-field">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
                    <x-input-error :messages="$errors->get('email')" />
                </div>
                <div class="form-field">
                    <label class="form-label" for="telephone">Téléphone</label>
                    <input id="telephone" name="telephone" type="text" class="form-input" value="{{ old('telephone', auth()->user()->telephone) }}" placeholder="+229 …">
                    <x-input-error :messages="$errors->get('telephone')" />
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-premium">Enregistrer</button>
            </div>
        </form>
    </div>

    {{-- Mot de passe --}}
    <div class="form-card">
        <div class="form-section-title">Changer le mot de passe</div>

        @if(session('status') === 'password-updated')
            <div style="display:flex;align-items:center;gap:0.6rem;background:#ECFDF5;border:1px solid #6EE7B7;border-radius:8px;padding:0.75rem 1rem;margin-bottom:1.25rem;font-size:0.8rem;font-weight:600;color:#065F46;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Mot de passe mis à jour avec succès.
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="form-grid">
                <div class="form-field" style="grid-column:1/-1;">
                    <label class="form-label" for="current_password">Mot de passe actuel</label>
                    <input id="current_password" name="current_password" type="password" class="form-input" placeholder="••••••••">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" />
                </div>
                <div class="form-field">
                    <label class="form-label" for="password">Nouveau mot de passe</label>
                    <input id="password" name="password" type="password" class="form-input" placeholder="••••••••">
                    <x-input-error :messages="$errors->updatePassword->get('password')" />
                </div>
                <div class="form-field">
                    <label class="form-label" for="password_confirmation">Confirmer</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-input" placeholder="••••••••">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-premium">Mettre à jour</button>
            </div>
        </form>
    </div>

    {{-- Supprimer le compte --}}
    <div class="form-card" style="border-color:#FECACA;" x-data="{ open: false }">
        <div class="form-section-title" style="color:#DC2626;">Zone dangereuse</div>
        <p style="font-size:0.82rem;color:#A3AED0;font-weight:500;margin:0 0 1.25rem;">
            La suppression de votre compte est irréversible. Toutes vos données seront définitivement effacées.
        </p>

        <button type="button" @click="open=true"
            style="background:#FEF2F2;color:#DC2626;border:1px solid #FECACA;font-weight:700;font-size:0.78rem;padding:0.65rem 1.4rem;border-radius:6px;cursor:pointer;text-transform:uppercase;letter-spacing:0.04em;">
            Supprimer mon compte
        </button>

        {{-- Modal confirmation --}}
        <div x-show="open" x-cloak style="position:fixed;inset:0;z-index:999;display:flex;align-items:center;justify-content:center;background:rgba(27,37,75,0.45);backdrop-filter:blur(4px);">
            <div style="background:#fff;border-radius:1.25rem;padding:2rem;max-width:420px;width:90%;box-shadow:0 30px 80px rgba(27,37,75,0.2);">
                <h3 style="font-size:1rem;font-weight:900;color:#1B254B;margin:0 0 0.5rem;">Confirmer la suppression</h3>
                <p style="font-size:0.82rem;color:#A3AED0;font-weight:500;margin:0 0 1.5rem;">Entrez votre mot de passe pour confirmer la suppression définitive de votre compte.</p>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="form-field" style="margin-bottom:1.25rem;">
                        <label class="form-label" for="del_password">Mot de passe</label>
                        <input id="del_password" name="password" type="password" class="form-input" placeholder="••••••••" required>
                        <x-input-error :messages="$errors->userDeletion->get('password')" />
                    </div>

                    <div style="display:flex;gap:0.75rem;justify-content:flex-end;">
                        <button type="button" @click="open=false" class="btn-outline">Annuler</button>
                        <button type="submit" style="background:#DC2626;color:#fff;font-weight:700;font-size:0.78rem;padding:0.65rem 1.4rem;border-radius:6px;cursor:pointer;border:none;text-transform:uppercase;letter-spacing:0.04em;">
                            Supprimer définitivement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@include('admin._form-styles')
@include('admin._table-styles')
</x-app-layout>
