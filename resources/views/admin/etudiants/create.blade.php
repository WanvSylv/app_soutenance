<x-app-layout>
@section('header', 'Inscrire un étudiant')

<a href="{{ route('admin.etudiants.index') }}" class="form-back">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Retour à la liste
</a>

<div class="form-card" x-data="{ photoPreview: null }">
    <form action="{{ route('admin.etudiants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Photo --}}
        <div class="photo-upload">
            <div class="photo-preview">
                <template x-if="!photoPreview">
                    <svg width="28" height="28" fill="none" stroke="#A3AED0" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </template>
                <template x-if="photoPreview">
                    <img :src="photoPreview" style="width:100%;height:100%;object-fit:cover;">
                </template>
            </div>
            <div>
                <label for="photo" class="photo-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Choisir une photo
                    <input type="file" id="photo" name="photo" class="hidden" accept="image/*"
                        @change="const f=$event.target.files[0];if(f){const r=new FileReader();r.onload=e=>photoPreview=e.target.result;r.readAsDataURL(f);}">
                </label>
                <div style="font-size:0.72rem;color:#A3AED0;margin-top:0.4rem;">JPG, PNG — max 2 Mo. Optionnel.</div>
                <x-input-error :messages="$errors->get('photo')" />
            </div>
        </div>

        {{-- Identité --}}
        <div class="form-section-title">Identité</div>
        <div class="form-grid">
            <div class="form-field">
                <label class="form-label" for="nom">Nom de famille</label>
                <input id="nom" name="nom" type="text" class="form-input" value="{{ old('nom') }}" placeholder="Ex : AGBOSSOU" required>
                <x-input-error :messages="$errors->get('nom')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="prenom">Prénom(s)</label>
                <input id="prenom" name="prenom" type="text" class="form-input" value="{{ old('prenom') }}" placeholder="Ex : Kévin" required>
                <x-input-error :messages="$errors->get('prenom')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="email">Email</label>
                <input id="email" name="email" type="email" class="form-input" value="{{ old('email') }}" placeholder="etudiant@universite.bj" required>
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="telephone">Téléphone</label>
                <input id="telephone" name="telephone" type="text" class="form-input" value="{{ old('telephone') }}" placeholder="+229 …">
                <x-input-error :messages="$errors->get('telephone')" />
            </div>
        </div>

        {{-- Infos académiques --}}
        <div class="form-section">
            <div class="form-section-title">Dossier académique</div>
            <div class="form-grid">
                <div class="form-field">
                    <label class="form-label" for="matricule">Matricule</label>
                    <input id="matricule" name="matricule" type="text" class="form-input" value="{{ old('matricule') }}" placeholder="Ex : ETU2026001" required>
                    <x-input-error :messages="$errors->get('matricule')" />
                </div>
                <div class="form-field">
                    <label class="form-label" for="niveau">Niveau</label>
                    <select id="niveau" name="niveau" class="form-input" required>
                        <option value="">Choisir …</option>
                        @foreach(['Licence 1','Licence 2','Licence 3','Master 1','Master 2','Doctorat'] as $n)
                        <option value="{{ $n }}" {{ old('niveau') == $n ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('niveau')" />
                </div>
                <div class="form-field" style="grid-column:1/-1;">
                    <label class="form-label" for="filiere">Filière</label>
                    <select id="filiere" name="filiere" class="form-input select2-field" required>
                        <option value="">Choisir …</option>
                        @foreach(['Génie Logiciel','Cybersécurité','Réseaux et Télécommunications','Intelligence Artificielle','Data Science','Informatique de Gestion','Développement Web et Mobile','Systèmes d\'Information'] as $f)
                        <option value="{{ $f }}" {{ old('filiere') == $f ? 'selected' : '' }}>{{ $f }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('filiere')" />
                </div>
            </div>
        </div>

        <div class="form-info">
            <svg width="16" height="16" fill="none" stroke="#D97706" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Un mot de passe provisoire sera généré et devra être communiqué à l'étudiant.
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.etudiants.index') }}" class="btn-outline">Annuler</a>
            <button type="submit" class="btn-premium">Valider l'inscription</button>
        </div>
    </form>
</div>

@include('admin._form-styles')
@include('admin._table-styles')

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>$(document).ready(function(){$('.select2-field').select2({width:'100%',placeholder:'Rechercher…',allowClear:true,tags:true});});</script>
@endsection
</x-app-layout>
