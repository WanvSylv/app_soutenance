<x-app-layout>
@section('header', 'Évaluation')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
    <a href="{{ route('enseignant.evaluations.index') }}" class="form-back" style="margin-bottom:0;">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Retour
    </a>
    <span class="badge {{ $soutenance->statut === 'terminee' ? 'badge-blue' : 'badge-green' }}" style="font-size:0.72rem;padding:0.35rem 0.75rem;">
        {{ $soutenance->statut === 'terminee' ? 'Soutenance terminée' : 'En cours' }}
    </span>
</div>

@if(session('success'))
    <div class="alert-success" style="margin-bottom:1.25rem;"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ session('success') }}</div>
@endif

{{-- En-tête étudiant --}}
<div class="data-card" style="padding:1.5rem;margin-bottom:1.5rem;">
    <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
        <div class="avatar" style="background:#2D60FF;width:48px;height:48px;font-size:1.1rem;">{{ substr($soutenance->etudiant->user->nom,0,1) }}</div>
        <div style="flex:1;min-width:200px;">
            <div style="font-size:1rem;font-weight:800;color:#1B254B;">{{ $soutenance->etudiant->user->nom }} {{ $soutenance->etudiant->user->prenom }}</div>
            <div class="row-sub">{{ $soutenance->etudiant->filiere }}</div>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,auto);gap:2rem;">
            <div><div class="table-filter-label">Sujet</div><div class="row-text" style="max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $soutenance->sujet }}</div></div>
            <div><div class="table-filter-label">Date</div><div class="row-text">{{ $soutenance->date_heure_debut->translatedFormat('d M Y à H:i') }}</div></div>
            <div><div class="table-filter-label">Salle</div><div class="row-text">{{ $soutenance->salle->nom }}</div></div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- Formulaire de notation --}}
    <div class="lg:col-span-8 flex flex-col gap-5">
        <form action="{{ route('enseignant.evaluations.store', $soutenance) }}" method="POST" id="evalForm">
            @csrf
            <div class="data-card">
                <div class="panel-header"><span class="panel-title">Critères d'évaluation</span></div>
                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Critère</th>
                                <th style="text-align:center;">Coeff.</th>
                                <th style="text-align:center;">Note (0–20)</th>
                                <th style="text-align:right;">Pondérée</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criteres as $idx => $critere)
                            <tr class="critere-row" data-coeff="{{ $critere->coefficient }}">
                                <td><span class="badge badge-blue">{{ $idx + 1 }}</span></td>
                                <td><span class="row-name">{{ $critere->libelle }}</span></td>
                                <td style="text-align:center;"><span class="row-text">×{{ (int)$critere->coefficient }}</span></td>
                                <td style="text-align:center;">
                                    <input type="number" step="0.25" min="0" max="20"
                                        name="note_{{ $critere->id }}"
                                        class="note-input form-input" style="width:90px;text-align:center;padding:0.5rem;"
                                        value="{{ old('note_'.$critere->id, $notesExistantes[$critere->id]->valeur ?? '') }}"
                                        placeholder="—"
                                        {{ $hasValidated || $soutenance->statut === 'terminee' ? 'disabled' : '' }}>
                                </td>
                                <td style="text-align:right;"><span class="row-text ponderee-val">—</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background:#F4F7FE;border-top:1px solid #E0E5F2;">
                                <td colspan="2" style="padding:0.875rem 1.25rem;font-size:0.75rem;font-weight:800;text-align:right;color:#1B254B;text-transform:uppercase;letter-spacing:0.08em;">Total</td>
                                <td style="padding:0.875rem;text-align:center;font-size:0.875rem;font-weight:800;color:#1B254B;" class="total-coeff">—</td>
                                <td></td>
                                <td style="padding:0.875rem 1.25rem;text-align:right;font-size:0.875rem;font-weight:800;color:#2D60FF;" class="total-ponderee">—</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-top:0;">
                <div class="kpi-card" style="--accent:#10B981;">
                    <div class="kpi-top"><span class="kpi-label">Moyenne finale</span></div>
                    <span class="kpi-value" id="liveAverage" style="color:#10B981;">—</span>
                    <span class="kpi-sub">/ 20</span>
                </div>
                <div class="data-card" style="padding:1.25rem;">
                    <label class="form-label" style="display:block;margin-bottom:0.4rem;">Commentaire <span style="font-weight:400;text-transform:none;">(optionnel)</span></label>
                    <textarea name="commentaire" rows="3" class="form-input" placeholder="Observations générales…" style="resize:vertical;" {{ $hasValidated || $soutenance->statut === 'terminee' ? 'disabled' : '' }}></textarea>
                </div>
            </div>

            @if(!$hasValidated && $soutenance->statut !== 'terminee')
            <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;margin-top:1.25rem;flex-wrap:wrap;">
                <p style="font-size:0.72rem;font-weight:600;color:#A3AED0;max-width:300px;text-align:right;flex:1;">Après validation, la note est définitivement enregistrée.</p>
                <button type="submit" class="btn-outline">Enregistrer brouillon</button>
                <button type="button" onclick="document.getElementById('validateForm').submit();" class="btn-premium" style="background:#10B981;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                    Valider et verrouiller
                </button>
            </div>
            @endif
        </form>

        {{-- Délibération président --}}
        @if($isPresident && $notationComplete && $soutenance->statut !== 'terminee')
        <div id="presidentDelib" class="data-card" style="border-color:#FDE68A;background:#FFFBEB;padding:1.5rem;">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem;">
                <div style="width:36px;height:36px;border-radius:8px;background:#F59E0B;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <div style="font-size:0.875rem;font-weight:800;color:#1B254B;">Délibération</div>
                    <div style="font-size:0.75rem;color:#D97706;font-weight:600;">Tous les membres ont validé leurs notes.</div>
                </div>
            </div>
            <form action="{{ route('enseignant.evaluations.deliberate', $soutenance) }}" method="POST">
                @csrf
                <div class="form-field" style="margin-bottom:1.25rem;">
                    <label class="form-label">Observations finales du jury</label>
                    <textarea name="observations_generales" rows="4" class="form-input" required placeholder="Rapport final de délibération…" style="resize:vertical;"></textarea>
                </div>
                <button type="submit" class="btn-premium" style="width:100%;justify-content:center;background:#1B254B;" onclick="return confirm('Clôturer officiellemement cette soutenance et générer le PV ?')">
                    Clôturer et générer le procès-verbal
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- Panneau jury --}}
    <div class="lg:col-span-4">
        <div class="data-card" style="padding:1.5rem;position:sticky;top:80px;">
            <div class="table-filter-label" style="margin-bottom:1rem;">Jury connecté</div>
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem;">
                <div class="avatar" style="background:#2D60FF;width:44px;height:44px;font-size:0.9rem;">{{ substr(auth()->user()->nom,0,1) }}{{ substr(auth()->user()->prenom,0,1) }}</div>
                <div>
                    <div class="row-name">{{ auth()->user()->enseignant->grade ?? '' }} {{ auth()->user()->nom }} {{ auth()->user()->prenom }}</div>
                    <div class="row-sub">{{ auth()->user()->enseignant->specialite ?? '' }}</div>
                </div>
            </div>

            <div style="background:#F4F7FE;border-radius:8px;padding:1.25rem;margin-bottom:1rem;">
                <div class="table-filter-label" style="margin-bottom:0.75rem;">Calcul en temps réel</div>
                <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
                    <span class="row-sub">Total pondéré</span>
                    <span class="row-text total-ponderee-display">—</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span class="row-sub">Moyenne</span>
                    <span class="row-name live-average-display" style="color:#10B981;">—</span>
                </div>
            </div>

            @if($isPresident && $notationComplete && $soutenance->statut !== 'terminee')
            <button type="button" onclick="document.getElementById('presidentDelib').scrollIntoView({behavior:'smooth',block:'start'})" class="btn-premium" style="width:100%;justify-content:center;background:#F59E0B;font-size:0.75rem;">
                Accéder à la délibération
            </button>
            @endif
        </div>
    </div>

</div>

{{-- Formulaire caché validation --}}
<form id="validateForm" action="{{ route('enseignant.evaluations.validateNotes', $soutenance) }}" method="POST" class="hidden">
    @csrf
    @foreach($criteres as $critere)
    <input type="hidden" name="note_{{ $critere->id }}" id="hidden_note_{{ $critere->id }}" value="">
    @endforeach
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.note-input');
    const avgMain = document.getElementById('liveAverage');
    const avgSide = document.querySelector('.live-average-display');
    const totPond = document.querySelector('.total-ponderee');
    const totSide = document.querySelector('.total-ponderee-display');
    const totCoeff = document.querySelector('.total-coeff');

    function calc() {
        let pond = 0, coeff = 0;
        document.querySelectorAll('.critere-row').forEach(row => {
            const c = parseFloat(row.dataset.coeff);
            const v = parseFloat(row.querySelector('.note-input').value) || 0;
            row.querySelector('.ponderee-val').textContent = (v * c).toFixed(2).replace('.', ',');
            const hidden = document.getElementById('hidden_note_' + row.querySelector('.note-input').name.split('_')[1]);
            if (hidden) hidden.value = row.querySelector('.note-input').value;
            pond += v * c; coeff += c;
        });
        const avg = coeff > 0 ? (pond / coeff) : 0;
        const avgTxt = avg.toFixed(2).replace('.', ',');
        avgMain.textContent = avgTxt;
        avgSide.textContent = avgTxt + ' / 20';
        totCoeff.textContent = coeff;
        totPond.textContent = pond.toFixed(2).replace('.', ',');
        totSide.textContent = pond.toFixed(2).replace('.', ',');
    }

    inputs.forEach(i => i.addEventListener('input', calc));
    calc();
});
</script>

@include('admin._table-styles')
@include('admin._form-styles')
</x-app-layout>
