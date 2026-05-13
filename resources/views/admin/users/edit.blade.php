<x-app-layout>
@section('header', 'Modifier le compte')

<a href="{{ route('admin.users.index') }}" class="form-back">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Retour à la liste
</a>

<div class="form-card" x-data="{ photoPreview: null }">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="photo-upload">
            <div class="photo-preview">
                <template x-if="!photoPreview">
                    @if($user->photo_path)
                        <img src="{{ asset($user->photo_path) }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <svg width="28" height="28" fill="none" stroke="#A3AED0" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    @endif
                </template>
                <template x-if="photoPreview"><img :src="photoPreview" style="width:100%;height:100%;object-fit:cover;"></template>
            </div>
            <div>
                <label for="photo" class="photo-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Changer la photo
                    <input type="file" id="photo" name="photo" class="hidden" accept="image/*" @change="const f=$event.target.files[0];if(f){const r=new FileReader();r.onload=e=>photoPreview=e.target.result;r.readAsDataURL(f);}">
                </label>
                <div style="font-size:0.72rem;color:#A3AED0;margin-top:0.4rem;">Laisser vide pour conserver la photo actuelle.</div>
                <x-input-error :messages="$errors->get('photo')" />
            </div>
        </div>

        <div class="form-section-title">Informations</div>
        <div class="form-grid">
            <div class="form-field">
                <label class="form-label" for="nom">Nom</label>
                <input id="nom" name="nom" type="text" class="form-input" value="{{ old('nom', $user->nom) }}" required>
                <x-input-error :messages="$errors->get('nom')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="prenom">Prénom(s)</label>
                <input id="prenom" name="prenom" type="text" class="form-input" value="{{ old('prenom', $user->prenom) }}" required>
                <x-input-error :messages="$errors->get('prenom')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="email">Email</label>
                <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="telephone">Téléphone</label>
                <input id="telephone" name="telephone" type="text" class="form-input" value="{{ old('telephone', $user->telephone) }}">
                <x-input-error :messages="$errors->get('telephone')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="role">Rôle</label>
                <select id="role" name="role" class="form-input" required>
                    <option value="admin"       {{ old('role', $user->role) == 'admin'       ? 'selected' : '' }}>Administrateur</option>
                    <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="enseignant"  {{ old('role', $user->role) == 'enseignant'  ? 'selected' : '' }}>Jury</option>
                    <option value="etudiant"    {{ old('role', $user->role) == 'etudiant'    ? 'selected' : '' }}>Étudiant</option>
                </select>
                <x-input-error :messages="$errors->get('role')" />
            </div>
            <div class="form-field" style="justify-content:flex-end;">
                <div class="toggle-row" style="height:100%;">
                    <div>
                        <div class="toggle-label">Compte actif</div>
                        <div class="toggle-sub">Désactiver bloque tout accès.</div>
                    </div>
                    <label style="position:relative;display:inline-flex;align-items:center;cursor:pointer;margin-left:1rem;">
                        <input type="hidden" name="actif" value="0">
                        <input type="checkbox" name="actif" value="1" class="sr-only peer" {{ old('actif', $user->actif) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#2D60FF]"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Changer le mot de passe <span style="font-weight:500;text-transform:none;letter-spacing:0;">(optionnel)</span></div>
            <div class="form-grid">
                <div class="form-field">
                    <label class="form-label" for="password">Nouveau mot de passe</label>
                    <input id="password" name="password" type="password" class="form-input" placeholder="Laisser vide pour ne pas changer">
                    <x-input-error :messages="$errors->get('password')" />
                </div>
                <div class="form-field">
                    <label class="form-label" for="password_confirmation">Confirmer</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-input">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.users.index') }}" class="btn-outline">Annuler</a>
            <button type="submit" class="btn-premium">Enregistrer</button>
        </div>
    </form>
</div>

@include('admin._form-styles')
@include('admin._table-styles')
</x-app-layout>
