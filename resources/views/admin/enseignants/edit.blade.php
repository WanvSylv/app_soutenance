<x-app-layout>
@section('header', 'Modifier le jury')

<a href="{{ route('admin.enseignants.index') }}" class="form-back">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Retour à la liste
</a>

<div class="form-card" x-data="{ photoPreview: null }">
    <form action="{{ route('admin.enseignants.update', $enseignant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="photo-upload">
            <div class="photo-preview">
                <template x-if="!photoPreview">
                    @if($enseignant->user->photo_path)
                        <img src="{{ asset('storage/'.$enseignant->user->photo_path) }}" style="width:100%;height:100%;object-fit:cover;">
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

        <div class="form-section-title">Identité</div>
        <div class="form-grid">
            <div class="form-field">
                <label class="form-label" for="nom">Nom</label>
                <input id="nom" name="nom" type="text" class="form-input" value="{{ old('nom', $enseignant->user->nom) }}" required>
                <x-input-error :messages="$errors->get('nom')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="prenom">Prénom</label>
                <input id="prenom" name="prenom" type="text" class="form-input" value="{{ old('prenom', $enseignant->user->prenom) }}" required>
                <x-input-error :messages="$errors->get('prenom')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="email">Email</label>
                <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $enseignant->user->email) }}" required>
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="telephone">Téléphone</label>
                <input id="telephone" name="telephone" type="text" class="form-input" value="{{ old('telephone', $enseignant->user->telephone) }}">
                <x-input-error :messages="$errors->get('telephone')" />
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Profil académique</div>
            <div class="form-grid">
                <div class="form-field">
                    <label class="form-label" for="grade">Grade</label>
                    <input id="grade" name="grade" type="text" class="form-input" value="{{ old('grade', $enseignant->grade) }}" required>
                    <x-input-error :messages="$errors->get('grade')" />
                </div>
                <div class="form-field">
                    <label class="form-label" for="specialite">Spécialité</label>
                    <select id="specialite" name="specialite" class="form-input select2-field" required>
                        @foreach(['Génie Logiciel','Cybersécurité','Réseaux et Télécommunications','Intelligence Artificielle','Data Science','Systèmes Embarqués','Informatique de Gestion','Développement Web et Mobile','Cloud Computing','Administration Bases de Données','Génie Informatique'] as $sp)
                        <option value="{{ $sp }}" {{ old('specialite', $enseignant->specialite) == $sp ? 'selected' : '' }}>{{ $sp }}</option>
                        @endforeach
                        @if(!in_array(old('specialite',$enseignant->specialite), ['Génie Logiciel','Cybersécurité','Réseaux et Télécommunications','Intelligence Artificielle','Data Science','Systèmes Embarqués','Informatique de Gestion','Développement Web et Mobile','Cloud Computing','Administration Bases de Données','Génie Informatique']) && old('specialite',$enseignant->specialite))
                        <option value="{{ old('specialite',$enseignant->specialite) }}" selected>{{ old('specialite',$enseignant->specialite) }}</option>
                        @endif
                    </select>
                    <x-input-error :messages="$errors->get('specialite')" />
                </div>
                <div class="form-field">
                    <label class="form-label" for="departement">Département</label>
                    <select id="departement" name="departement" class="form-input select2-field">
                        <option value="">—</option>
                        @foreach(['Sciences Informatiques','Génie Électrique et Informatique','Mathématiques Appliquées','Télécommunications','Sciences des Données','Innovation et Recherche'] as $dep)
                        <option value="{{ $dep }}" {{ old('departement', $enseignant->departement) == $dep ? 'selected' : '' }}>{{ $dep }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('departement')" />
                </div>
                <div class="form-field">
                    <label class="form-label" for="bureau">Bureau</label>
                    <input id="bureau" name="bureau" type="text" class="form-input" value="{{ old('bureau', $enseignant->bureau) }}">
                    <x-input-error :messages="$errors->get('bureau')" />
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.enseignants.index') }}" class="btn-outline">Annuler</a>
            <button type="submit" class="btn-premium">Enregistrer les modifications</button>
        </div>
    </form>
</div>

@include('admin._form-styles')
@include('admin._table-styles')
@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>$(document).ready(function(){$('.select2-field').select2({width:'100%',allowClear:true,tags:true});});</script>
@endsection
</x-app-layout>
