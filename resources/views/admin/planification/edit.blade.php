<x-app-layout>
@section('header', 'Modifier la soutenance')

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
    <form action="{{ route('admin.planification.update', $soutenance->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-section-title">Candidat & sujet</div>
        <div class="form-grid">
            <div class="form-field">
                <label class="form-label" for="etudiant_id">Étudiant</label>
                <select id="etudiant_id" name="etudiant_id" class="form-input" required>
                    @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}" {{ old('etudiant_id', $soutenance->etudiant_id) == $etudiant->id ? 'selected' : '' }}>
                        {{ $etudiant->user->nom }} {{ $etudiant->user->prenom }} — {{ $etudiant->matricule }}
                    </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('etudiant_id')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="salle_id">Salle</label>
                <select id="salle_id" name="salle_id" class="form-input" required>
                    @foreach($salles as $salle)
                    <option value="{{ $salle->id }}" {{ old('salle_id', $soutenance->salle_id) == $salle->id ? 'selected' : '' }}>
                        {{ $salle->nom }}{{ $salle->localisation ? ' — '.$salle->localisation : '' }}
                    </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('salle_id')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="date_soutenance">Date</label>
                <input id="date_soutenance" name="date_soutenance" type="date" class="form-input" value="{{ old('date_soutenance', $soutenance->date_heure_debut->format('Y-m-d')) }}" required>
                <x-input-error :messages="$errors->get('date_soutenance')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="heure_debut">Heure de début</label>
                <input id="heure_debut" name="heure_debut" type="time" class="form-input" value="{{ old('heure_debut', $soutenance->date_heure_debut->format('H:i')) }}" required>
                <x-input-error :messages="$errors->get('heure_debut')" />
            </div>
            <div class="form-field" style="grid-column:1/-1;">
                <label class="form-label" for="sujet">Thème du mémoire</label>
                <textarea id="sujet" name="sujet" rows="3" class="form-input" required style="resize:vertical;">{{ old('sujet', $soutenance->sujet) }}</textarea>
                <x-input-error :messages="$errors->get('sujet')" />
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Composition du jury</div>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;">
                @php
                    $juryFields = [
                        'president_id'  => ['Président', $president?->enseignant_id],
                        'rapporteur_id' => ['Rapporteur', $rapporteur?->enseignant_id],
                        'membre_id'     => ['Examinateur', $membre?->enseignant_id],
                    ];
                @endphp
                @foreach($juryFields as $field => [$label, $current])
                <div class="form-field">
                    <label class="form-label" for="{{ $field }}">{{ $label }}</label>
                    <select id="{{ $field }}" name="{{ $field }}" class="form-input" required>
                        <option value="">Choisir…</option>
                        @foreach($enseignants as $e)
                        <option value="{{ $e->id }}" {{ old($field, $current) == $e->id ? 'selected' : '' }}>
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
            <button type="submit" class="btn-premium">Enregistrer les modifications</button>
        </div>
    </form>
</div>

@include('admin._form-styles')
@include('admin._table-styles')

<script>
    document.getElementById('etudiant_id').addEventListener('change', function() {
        const id = this.value;
        const sujet = document.getElementById('sujet');
        if (!id) return;
        fetch(`/admin/etudiants/${id}/theme`)
            .then(r => r.json())
            .then(d => { if (d.theme) sujet.value = d.theme; });
    });
</script>
</x-app-layout>
