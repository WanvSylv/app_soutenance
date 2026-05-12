<x-app-layout>
@section('header', 'Nouvelle session académique')

<a href="{{ route('admin.annees-academiques.index') }}" class="form-back">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Retour à la liste
</a>

<div class="form-card">
    <form action="{{ route('admin.annees-academiques.store') }}" method="POST">
        @csrf

        <div class="form-section-title">Informations</div>
        <div class="form-field" style="margin-bottom:1.25rem;">
            <label class="form-label" for="libelle">Libellé</label>
            <input id="libelle" name="libelle" type="text" class="form-input" value="{{ old('libelle') }}" placeholder="Ex : 2025-2026" required>
            <x-input-error :messages="$errors->get('libelle')" />
        </div>

        <div class="form-grid">
            <div class="form-field">
                <label class="form-label" for="date_debut">Date de début</label>
                <input id="date_debut" name="date_debut" type="date" class="form-input" value="{{ old('date_debut') }}" required>
                <x-input-error :messages="$errors->get('date_debut')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="date_fin">Date de fin</label>
                <input id="date_fin" name="date_fin" type="date" class="form-input" value="{{ old('date_fin') }}" required>
                <x-input-error :messages="$errors->get('date_fin')" />
            </div>
        </div>

        <div class="form-section">
            <div class="toggle-row">
                <div>
                    <div class="toggle-label">Définir comme session active</div>
                    <div class="toggle-sub">Toutes les autres sessions seront désactivées.</div>
                </div>
                <label style="position:relative;display:inline-flex;align-items:center;cursor:pointer;">
                    <input type="checkbox" name="active" value="1" class="sr-only peer" {{ old('active') ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#2D60FF]"></div>
                </label>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.annees-academiques.index') }}" class="btn-outline">Annuler</a>
            <button type="submit" class="btn-premium">Enregistrer la session</button>
        </div>
    </form>
</div>

@include('admin._form-styles')
@include('admin._table-styles')
</x-app-layout>
