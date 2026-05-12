<x-app-layout>
@section('header', 'Mes évaluations')

<div style="margin-bottom:1.5rem;">
    <p class="page-desc">Soutenances dont vous êtes membre du jury.</p>
</div>

@if(session('success'))
    <div class="alert-success" style="margin-bottom:1.25rem;"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ session('success') }}</div>
@endif

<div style="display:flex;flex-direction:column;gap:1rem;">
    @forelse($soutenances as $soutenance)
    @php
        $myJury = $soutenance->juryMembres->where('enseignant_id', auth()->user()->enseignant->id)->first();
        $statusColors = ['planifiee'=>'#2D60FF','en_cours'=>'#F59E0B','terminee'=>'#10B981','annulee'=>'#EF4444'];
        $dot = $statusColors[$soutenance->statut] ?? '#A3AED0';
    @endphp
    <div class="data-card" style="padding:1.5rem;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;">

            {{-- Info soutenance --}}
            <div style="flex:1;min-width:280px;">
                <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.75rem;">
                    <span style="width:8px;height:8px;border-radius:50%;background:{{ $dot }};flex-shrink:0;"></span>
                    <span style="font-size:0.75rem;font-weight:700;color:#A3AED0;">{{ $soutenance->date_heure_debut->translatedFormat('l d F Y') }} à {{ $soutenance->date_heure_debut->format('H:i') }}</span>
                    <span style="font-size:0.72rem;font-weight:600;color:#A3AED0;">— {{ $soutenance->salle->nom }}</span>
                </div>

                <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.6rem;">
                    <div class="avatar" style="background:#2D60FF;width:28px;height:28px;font-size:0.6rem;">{{ substr($soutenance->etudiant->user->nom,0,1) }}</div>
                    <div>
                        <div class="row-name">{{ $soutenance->etudiant->user->nom }} {{ $soutenance->etudiant->user->prenom }}</div>
                        <div class="row-sub">{{ $soutenance->etudiant->filiere }}</div>
                    </div>
                </div>

                <div style="font-size:0.78rem;font-weight:500;color:#A3AED0;font-style:italic;margin-bottom:0.75rem;">{{ Str::limit($soutenance->sujet, 100) }}</div>

                {{-- Jury --}}
                <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                    @foreach($soutenance->juryMembres as $m)
                    <span style="font-size:0.65rem;font-weight:700;background:#F4F7FE;border:1px solid #E0E5F2;border-radius:4px;padding:0.2rem 0.5rem;color:#1B254B;">
                        {{ $m->fonction }} : {{ $m->enseignant->user->nom }}
                    </span>
                    @endforeach
                </div>
            </div>

            {{-- Action --}}
            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.5rem;min-width:180px;">
                @if($soutenance->statut == 'terminee' && $soutenance->procesVerbal)
                    <div style="text-align:right;">
                        <div style="font-size:2rem;font-weight:900;color:#1B254B;line-height:1;">{{ number_format($soutenance->procesVerbal->moyenne, 2) }}<span style="font-size:0.9rem;font-weight:600;">/20</span></div>
                        <div style="font-size:0.7rem;font-weight:700;color:#10B981;text-transform:uppercase;letter-spacing:0.08em;">{{ $soutenance->procesVerbal->mention }}</div>
                    </div>
                @elseif($myJury && $myJury->statut_confirmation === 'en_attente')
                    <div style="font-size:0.7rem;font-weight:700;color:#A3AED0;text-transform:uppercase;letter-spacing:0.08em;text-align:right;margin-bottom:0.25rem;">Confirmer votre présence</div>
                    <div style="display:flex;gap:0.5rem;">
                        <form action="{{ route('enseignant.evaluations.availability', $soutenance) }}" method="POST">
                            @csrf
                            <input type="hidden" name="statut_confirmation" value="confirme">
                            <button type="submit" class="btn-premium" style="font-size:0.72rem;padding:0.5rem 1rem;background:#10B981;">Confirmer</button>
                        </form>
                        <button type="button" onclick="showIndispoModal('{{ $soutenance->id }}')" class="btn-outline" style="font-size:0.72rem;padding:0.5rem 1rem;border-color:#FECACA;color:#DC2626;">Indisponible</button>
                    </div>
                @elseif($myJury && $myJury->statut_confirmation === 'indisponible')
                    <span class="badge badge-red">Indisponible</span>
                @elseif(now()->gte($soutenance->date_heure_debut) && in_array($soutenance->statut, ['planifiee','en_cours']))
                    <a href="{{ route('enseignant.evaluations.evaluate', $soutenance) }}" class="btn-premium" style="font-size:0.75rem;">
                        Démarrer l'évaluation
                    </a>
                @else
                    <span style="font-size:0.72rem;font-weight:600;color:#A3AED0;">{{ $soutenance->date_heure_debut->format('d/m/Y à H:i') }}</span>
                @endif
            </div>

        </div>
    </div>
    @empty
    <div class="data-card"><div class="empty-state"><svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>Aucune évaluation pour le moment</div></div>
    @endforelse
</div>

{{-- Modale indisponibilité --}}
<div id="indispoModal" onclick="if(event.target===this)hideIndispoModal()" style="display:none;position:fixed;inset:0;background:rgba(27,37,75,0.45);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:2rem;width:100%;max-width:420px;margin:1rem;">
        <h3 style="font-size:1rem;font-weight:800;color:#1B254B;margin:0 0 0.4rem;">Déclarer une indisponibilité</h3>
        <p style="font-size:0.825rem;color:#A3AED0;margin:0 0 1.25rem;">Indiquez le motif pour lequel vous ne pouvez pas siéger.</p>
        <form id="indispoForm" method="POST">
            @csrf
            <input type="hidden" name="statut_confirmation" value="indisponible">
            <div style="margin-bottom:1.25rem;">
                <label class="form-label" style="display:block;margin-bottom:0.4rem;">Motif</label>
                <textarea name="motif_indisponibilite" rows="4" class="form-input" required placeholder="Ex : Déplacement professionnel, Maladie…" style="resize:vertical;"></textarea>
            </div>
            <div style="display:flex;gap:0.75rem;">
                <button type="button" onclick="hideIndispoModal()" class="btn-outline" style="flex:1;">Annuler</button>
                <button type="submit" class="btn-premium" style="flex:1;background:#EF4444;">Confirmer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showIndispoModal(id) {
        document.getElementById('indispoForm').action = `/enseignant/evaluations/${id}/availability`;
        document.getElementById('indispoModal').style.display = 'flex';
    }
    function hideIndispoModal() {
        document.getElementById('indispoModal').style.display = 'none';
    }
</script>

@include('admin._table-styles')
@include('admin._form-styles')
</x-app-layout>
