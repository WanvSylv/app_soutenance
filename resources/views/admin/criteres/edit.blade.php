<x-app-layout>
@section('header', 'Modifier le critère')

<a href="{{ route('admin.criteres.index') }}" class="form-back">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Retour à la liste
</a>

<div class="form-card">
    <form action="{{ route('admin.criteres.update', $critere->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-section-title">Définition</div>
        <div class="form-field" style="margin-bottom:1.25rem;">
            <label class="form-label" for="libelle">Libellé du critère</label>
            <input id="libelle" name="libelle" type="text" class="form-input" value="{{ old('libelle', $critere->libelle) }}" required>
            <x-input-error :messages="$errors->get('libelle')" />
        </div>

        <div class="form-grid">
            <div class="form-field">
                <label class="form-label" for="coefficient">Coefficient</label>
                <input id="coefficient" name="coefficient" type="number" step="0.1" min="0.1" class="form-input" value="{{ old('coefficient', $critere->coefficient) }}" required>
                <x-input-error :messages="$errors->get('coefficient')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="ordre">Ordre d'affichage</label>
                <input id="ordre" name="ordre" type="number" min="1" class="form-input" value="{{ old('ordre', $critere->ordre) }}" required>
                <x-input-error :messages="$errors->get('ordre')" />
            </div>
        </div>

        <div class="form-section">
            <div class="form-field">
                <label class="form-label" for="description">Description <span style="font-weight:400;text-transform:none;">(optionnel)</span></label>
                <textarea id="description" name="description" rows="3" class="form-input" style="resize:vertical;">{{ old('description', $critere->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>
        </div>

        <div class="form-actions" style="justify-content:space-between;">
            <label style="display:inline-flex;align-items:center;gap:0.6rem;cursor:pointer;">
                <input type="hidden" name="actif" value="0">
                <input type="checkbox" id="actif" name="actif" value="1" {{ old('actif', $critere->actif) ? 'checked' : '' }} style="width:16px;height:16px;border-radius:4px;accent-color:#2D60FF;cursor:pointer;">
                <div>
                    <span style="font-size:0.8rem;font-weight:700;color:#1B254B;">Critère actif</span>
                    <div style="font-size:0.7rem;color:#A3AED0;">Les critères inactifs ne sont pas utilisés lors des évaluations.</div>
                </div>
            </label>
            <div style="display:flex;gap:0.75rem;">
                <a href="{{ route('admin.criteres.index') }}" class="btn-outline">Annuler</a>
                <button type="submit" class="btn-premium">Enregistrer</button>
            </div>
        </div>
    </form>
</div>

@include('admin._form-styles')
@include('admin._table-styles')
</x-app-layout>
