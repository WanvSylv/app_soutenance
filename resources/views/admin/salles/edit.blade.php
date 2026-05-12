<x-app-layout>
@section('header', 'Modifier la salle')

<a href="{{ route('admin.salles.index') }}" class="form-back">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Retour à la liste
</a>

<div class="form-card">
    <form action="{{ route('admin.salles.update', $salle) }}" method="POST">
        @csrf @method('PATCH')

        <div class="form-section-title">Identification</div>
        <div class="form-grid">
            <div class="form-field">
                <label class="form-label" for="code">Code</label>
                <input id="code" name="code" type="text" class="form-input" value="{{ old('code', $salle->code) }}" required>
                <x-input-error :messages="$errors->get('code')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="nom">Désignation</label>
                <input id="nom" name="nom" type="text" class="form-input" value="{{ old('nom', $salle->nom) }}" required>
                <x-input-error :messages="$errors->get('nom')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="capacite">Capacité (places)</label>
                <input id="capacite" name="capacite" type="number" class="form-input" value="{{ old('capacite', $salle->capacite) }}" min="1">
                <x-input-error :messages="$errors->get('capacite')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="localisation">Localisation</label>
                <input id="localisation" name="localisation" type="text" class="form-input" value="{{ old('localisation', $salle->localisation) }}">
                <x-input-error :messages="$errors->get('localisation')" />
            </div>
        </div>

        <div class="form-section">
            <div class="form-field" style="margin-bottom:1.25rem;">
                <label class="form-label" for="equipements">Équipements</label>
                <textarea id="equipements" name="equipements" rows="3" class="form-input" style="resize:vertical;">{{ old('equipements', $salle->equipements) }}</textarea>
                <x-input-error :messages="$errors->get('equipements')" />
            </div>

            <div class="toggle-row">
                <div>
                    <div class="toggle-label">Salle disponible</div>
                    <div class="toggle-sub">Décocher pour indiquer une salle en maintenance.</div>
                </div>
                <label style="position:relative;display:inline-flex;align-items:center;cursor:pointer;">
                    <input type="hidden" name="disponible" value="0">
                    <input type="checkbox" name="disponible" value="1" class="sr-only peer" {{ old('disponible', $salle->disponible) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#2D60FF]"></div>
                </label>
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
