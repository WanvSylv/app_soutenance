<x-app-layout>
@section('header', 'Créer un compte')

<a href="{{ route('admin.users.index') }}" class="form-back">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Retour à la liste
</a>

<div class="form-card" x-data="{ photoPreview: null }">
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="photo-upload">
            <div class="photo-preview">
                <template x-if="!photoPreview">
                    <svg width="28" height="28" fill="none" stroke="#A3AED0" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </template>
                <template x-if="photoPreview"><img :src="photoPreview" style="width:100%;height:100%;object-fit:cover;"></template>
            </div>
            <div>
                <label for="photo" class="photo-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Choisir une photo
                    <input type="file" id="photo" name="photo" class="hidden" accept="image/*" @change="const f=$event.target.files[0];if(f){const r=new FileReader();r.onload=e=>photoPreview=e.target.result;r.readAsDataURL(f);}">
                </label>
                <div style="font-size:0.72rem;color:#A3AED0;margin-top:0.4rem;">JPG, PNG — max 2 Mo. Optionnel.</div>
                <x-input-error :messages="$errors->get('photo')" />
            </div>
        </div>

        <div class="form-section-title">Informations</div>
        <div class="form-grid">
            <div class="form-field">
                <label class="form-label" for="nom">Nom</label>
                <input id="nom" name="nom" type="text" class="form-input" value="{{ old('nom') }}" placeholder="Ex : WANVOEGBE" required>
                <x-input-error :messages="$errors->get('nom')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="prenom">Prénom(s)</label>
                <input id="prenom" name="prenom" type="text" class="form-input" value="{{ old('prenom') }}" placeholder="Ex : Sylvain" required>
                <x-input-error :messages="$errors->get('prenom')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="email">Email</label>
                <input id="email" name="email" type="email" class="form-input" value="{{ old('email') }}" placeholder="contact@universite.bj" required>
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="telephone">Téléphone</label>
                <input id="telephone" name="telephone" type="text" class="form-input" value="{{ old('telephone') }}" placeholder="+229 …">
                <x-input-error :messages="$errors->get('telephone')" />
            </div>
            <div class="form-field" style="grid-column:1/-1;">
                <label class="form-label" for="role">Rôle</label>
                <select id="role" name="role" class="form-input" required>
                    <option value="">Choisir un rôle …</option>
                    <option value="admin"      {{ old('role') == 'admin'      ? 'selected' : '' }}>Administrateur</option>
                    <option value="enseignant" {{ old('role') == 'enseignant' ? 'selected' : '' }}>Jury</option>
                    <option value="etudiant"   {{ old('role') == 'etudiant'   ? 'selected' : '' }}>Étudiant</option>
                </select>
                <x-input-error :messages="$errors->get('role')" />
            </div>
        </div>

        <div class="form-info">
            <svg width="16" height="16" fill="none" stroke="#D97706" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Un mot de passe sécurisé sera généré et envoyé par email à l'utilisateur.
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.users.index') }}" class="btn-outline">Annuler</a>
            <button type="submit" class="btn-premium">Créer le compte</button>
        </div>
    </form>
</div>

@include('admin._form-styles')
@include('admin._table-styles')
</x-app-layout>
