<x-app-layout>
@section('header', 'Planifier une soutenance')

<a href="{{ route('planification.index') }}" class="form-back">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Retour au planning
</a>

@if(session('error'))
    <div style="display:flex;align-items:center;gap:0.6rem;background:#FFF5F5;border:1px solid #FECACA;border-radius:8px;padding:0.75rem 1.25rem;font-size:0.825rem;font-weight:600;color:#DC2626;margin-bottom:1.25rem;">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        {{ session('error') }}
    </div>
@endif

<div class="form-card">
    <form action="{{ route('admin.planification.store') }}" method="POST">
        @csrf

        {{-- Candidat & sujet --}}
        <div class="form-section-title">Candidat & sujet</div>
        <div class="form-grid">
            <div class="form-field">
                <label class="form-label" for="etudiant_id">Étudiant (quitus validé)</label>
                <select id="etudiant_id" name="etudiant_id" class="form-input" required>
                    <option value="">Choisir un étudiant…</option>
                    @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}" {{ old('etudiant_id') == $etudiant->id ? 'selected' : '' }}>
                        {{ $etudiant->user->nom }} {{ $etudiant->user->prenom }} — {{ $etudiant->matricule }}
                    </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('etudiant_id')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="salle_id">Salle</label>
                <select id="salle_id" name="salle_id" class="form-input" required>
                    <option value="">Choisir une salle…</option>
                    @foreach($salles as $salle)
                    <option value="{{ $salle->id }}" {{ old('salle_id') == $salle->id ? 'selected' : '' }}>
                        {{ $salle->nom }}{{ $salle->localisation ? ' — '.$salle->localisation : '' }}
                    </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('salle_id')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="date_soutenance">Date</label>
                <input id="date_soutenance" name="date_soutenance" type="date" class="form-input" value="{{ old('date_soutenance') }}" required>
                <x-input-error :messages="$errors->get('date_soutenance')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="heure_debut">Heure de début</label>
                <input id="heure_debut" name="heure_debut" type="time" class="form-input" value="{{ old('heure_debut') }}" required>
                <x-input-error :messages="$errors->get('heure_debut')" />
            </div>
            <div class="form-field" style="grid-column:1/-1;">
                <label class="form-label" for="sujet">Thème du mémoire</label>
                <textarea id="sujet" name="sujet" rows="3" class="form-input" placeholder="Titre complet du mémoire…" required style="resize:vertical;">{{ old('sujet') }}</textarea>
                <x-input-error :messages="$errors->get('sujet')" />
            </div>
        </div>

        {{-- Jury --}}
        <div class="form-section">
            <div class="form-section-title">Composition du jury</div>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;">
                @foreach(['president_id'=>'Président','rapporteur_id'=>'Rapporteur','membre_id'=>'Examinateur'] as $field => $label)
                <div class="form-field">
                    <label class="form-label" for="{{ $field }}">{{ $label }}</label>
                    <select id="{{ $field }}" name="{{ $field }}" class="form-input" required>
                        <option value="">Choisir…</option>
                        @foreach($enseignants as $e)
                        <option value="{{ $e->id }}" {{ old($field) == $e->id ? 'selected' : '' }}>
                            {{ $e->user->nom }} {{ $e->user->prenom }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get($field)" />
                </div>
                @endforeach
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('planification.index') }}" class="btn-outline">Annuler</a>
            <button type="submit" class="btn-premium">Confirmer la planification</button>
        </div>
    </form>
</div>

@include('admin._form-styles')
@include('admin._table-styles')

<script>
    document.getElementById('etudiant_id').addEventListener('change', function() {
        const id = this.value;
        const sujet = document.getElementById('sujet');
        if (!id) { sujet.value = ''; return; }
        sujet.placeholder = 'Récupération du thème…';
        fetch(`/admin/etudiants/${id}/theme`)
            .then(r => r.json())
            .then(d => { sujet.value = d.theme || ''; sujet.placeholder = 'Titre complet du mémoire…'; })
            .catch(() => { sujet.placeholder = 'Erreur — saisir manuellement.'; });
    });
</script>
</x-app-layout>
