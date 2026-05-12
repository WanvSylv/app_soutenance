<x-app-layout>
@section('header', 'Ajouter une salle')

<a href="{{ route('admin.salles.index') }}" class="form-back">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Retour à la liste
</a>

<div class="form-card">
    <form action="{{ route('admin.salles.store') }}" method="POST">
        @csrf

        <div class="form-section-title">Identification</div>
        <div class="form-grid">
            <div class="form-field">
                <label class="form-label" for="code">Code</label>
                <input id="code" name="code" type="text" class="form-input" value="{{ old('code') }}" placeholder="Ex : CONF-A" required>
                <x-input-error :messages="$errors->get('code')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="nom">Désignation</label>
                <input id="nom" name="nom" type="text" class="form-input" value="{{ old('nom') }}" placeholder="Ex : Salle de Conférence A" required>
                <x-input-error :messages="$errors->get('nom')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="capacite">Capacité (places)</label>
                <input id="capacite" name="capacite" type="number" class="form-input" value="{{ old('capacite') }}" min="1" placeholder="Ex : 30">
                <x-input-error :messages="$errors->get('capacite')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="localisation">Localisation</label>
                <input id="localisation" name="localisation" type="text" class="form-input" value="{{ old('localisation') }}" placeholder="Ex : Bâtiment B, 1er étage">
                <x-input-error :messages="$errors->get('localisation')" />
            </div>
        </div>

        <div class="form-section">
            <div class="form-field">
                <label class="form-label" for="equipements">Équipements</label>
                <textarea id="equipements" name="equipements" rows="3" class="form-input" placeholder="Ex : Vidéoprojecteur, Tableau blanc…" style="resize:vertical;">{{ old('equipements') }}</textarea>
                <x-input-error :messages="$errors->get('equipements')" />
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.salles.index') }}" class="btn-outline">Annuler</a>
            <button type="submit" class="btn-premium">Enregistrer</button>
        </div>
    </form>
</div>

@include('admin._form-styles')
@include('admin._table-styles')
</x-app-layout>
