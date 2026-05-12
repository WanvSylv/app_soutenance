<x-app-layout>
@section('header', 'Mon espace')

<div style="margin-bottom:1.75rem;">
    <h2 style="font-size:1.1rem;font-weight:800;color:#1B254B;margin:0 0 0.25rem;">Bonjour, {{ auth()->user()->prenom }}</h2>
    <p style="font-size:0.825rem;font-weight:500;color:#A3AED0;margin:0;">Suivez l'état de votre soutenance et consultez vos résultats.</p>
</div>

@if(!$etudiant)
    <div class="data-card"><div class="empty-state">Votre profil étudiant n'est pas encore configuré par l'administration.</div></div>
@else

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- Colonne gauche --}}
    <div class="lg:col-span-4 flex flex-col gap-5">

        {{-- Quitus --}}
        <div class="kpi-card" style="--accent:{{ $etudiant->quitus_valide ? '#10B981' : '#F59E0B' }};">
            <div class="kpi-top">
                <span class="kpi-label">Quitus</span>
                <div class="kpi-icon" style="background:{{ $etudiant->quitus_valide ? 'rgba(16,185,129,0.08)' : 'rgba(245,158,11,0.08)' }};">
                    <svg width="16" height="16" fill="none" stroke="{{ $etudiant->quitus_valide ? '#10B981' : '#F59E0B' }}" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <span class="kpi-value" style="font-size:1.1rem;">{{ $etudiant->quitus_valide ? 'Validé' : 'En attente' }}</span>
            <span class="kpi-sub">Éligibilité administrative</span>
        </div>

        {{-- Ma soutenance --}}
        <div class="data-card">
            <div class="panel-header"><span class="panel-title">Ma soutenance</span></div>
            <div style="padding:1.25rem 1.5rem;">
                @if(!$soutenance)
                    <p style="font-size:0.8rem;font-weight:500;color:#A3AED0;font-style:italic;">Votre soutenance n'est pas encore planifiée.</p>
                @else
                    <div style="margin-bottom:1rem;">
                        <div class="table-filter-label" style="margin-bottom:0.3rem;">Sujet</div>
                        <div style="font-size:0.825rem;font-weight:700;color:#1B254B;line-height:1.5;">{{ $soutenance->sujet }}</div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1rem;">
                        <div>
                            <div class="table-filter-label" style="margin-bottom:0.2rem;">Date & heure</div>
                            <div class="row-text">{{ $soutenance->date_heure_debut->translatedFormat('d M Y à H:i') }}</div>
                        </div>
                        <div>
                            <div class="table-filter-label" style="margin-bottom:0.2rem;">Salle</div>
                            <div class="row-text">{{ $soutenance->salle->nom }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="table-filter-label" style="margin-bottom:0.4rem;">Jury</div>
                        @foreach($soutenance->juryMembres as $m)
                        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.3rem;">
                            <div class="avatar" style="background:#2D60FF;width:24px;height:24px;font-size:0.55rem;">{{ substr($m->enseignant->user->prenom,0,1) }}{{ substr($m->enseignant->user->nom,0,1) }}</div>
                            <span class="row-text" style="font-size:0.78rem;">{{ $m->enseignant->user->nom }} {{ $m->enseignant->user->prenom }}</span>
                            <span class="badge badge-blue" style="font-size:0.6rem;padding:0.15rem 0.5rem;">{{ $m->fonction }}</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Mon mémoire --}}
        <div class="data-card">
            <div class="panel-header"><span class="panel-title">Mon mémoire</span></div>
            <div style="padding:1.25rem 1.5rem;">
                @if($memoire)
                    <div style="font-size:0.825rem;font-weight:700;color:#1B254B;margin-bottom:0.5rem;line-height:1.4;">{{ $memoire->titre }}</div>
                    <div class="row-sub" style="margin-bottom:1rem;">Déposé le {{ $memoire->updated_at->translatedFormat('d F Y') }}</div>
                    <a href="{{ route('etudiant.memoire.view') }}" target="_blank" class="btn-premium" style="font-size:0.72rem;padding:0.5rem 1rem;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Voir le fichier
                    </a>
                @else
                    <p class="empty-state" style="padding:1rem 0;">Aucun mémoire déposé.</p>
                    <a href="{{ route('etudiant.memoire.index') }}" class="btn-premium" style="font-size:0.72rem;padding:0.5rem 1rem;">Déposer mon mémoire</a>
                @endif
            </div>
        </div>
    </div>

    {{-- Colonne droite --}}
    <div class="lg:col-span-8 flex flex-col gap-5">

        {{-- Résultats --}}
        <div class="data-card" style="padding:1.5rem;">
            <div class="table-filter-label" style="color:#7C3AED;margin-bottom:1rem;">Résultats académiques</div>
            @if($procesVerbal)
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;">
                <div>
                    <div class="kpi-label" style="color:#A3AED0;">Moyenne</div>
                    <div style="font-size:2.5rem;font-weight:900;color:#1B254B;line-height:1;">{{ number_format($procesVerbal->moyenne, 2) }}<span style="font-size:1rem;font-weight:600;color:#A3AED0;">/20</span></div>
                </div>
                <div>
                    <div class="kpi-label" style="color:#A3AED0;">Mention</div>
                    <div style="font-size:1.25rem;font-weight:800;color:#7C3AED;text-transform:uppercase;">{{ $procesVerbal->mention }}</div>
                </div>
                <div>
                    <div class="kpi-label" style="color:#A3AED0;">Décision</div>
                    <span class="badge badge-green">{{ $procesVerbal->decision }}</span>
                </div>
            </div>
            @else
            <div style="background:#F4F7FE;border-radius:8px;padding:1.25rem;display:flex;align-items:center;gap:0.75rem;">
                <svg width="18" height="18" fill="none" stroke="#A3AED0" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span style="font-size:0.825rem;font-weight:500;color:#A3AED0;">Vos résultats seront disponibles après la délibération du jury.</span>
            </div>
            @endif
        </div>

        {{-- Planning semaine --}}
        <div class="data-card">
            <div class="panel-header"><span class="panel-title">Planning global de la semaine</span></div>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;min-width:580px;">
                    <thead>
                        <tr style="border-bottom:1px solid #F4F7FE;">
                            <th style="padding:0.6rem 1rem;width:60px;text-align:left;font-size:0.65rem;font-weight:800;color:#A3AED0;text-transform:uppercase;"></th>
                            @for($i=0;$i<7;$i++)
                            @php $date=$startOfWeek->copy()->addDays($i); @endphp
                            <th style="padding:0.6rem 0.5rem;text-align:center;font-size:0.65rem;font-weight:800;text-transform:uppercase;letter-spacing:0.06em;{{ $date->isToday() ? 'color:#2D60FF;' : 'color:#A3AED0;' }}">{{ $date->translatedFormat('D d') }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['08:00','10:00','13:00','15:00'] as $time)
                        <tr style="border-bottom:1px solid #F4F7FE;">
                            <td style="padding:0.6rem 1rem;font-size:0.65rem;font-weight:700;color:#A3AED0;">{{ $time }}</td>
                            @for($i=0;$i<7;$i++)
                            @php $cur=$startOfWeek->copy()->addDays($i);$cnt=$weekSoutenances->filter(fn($s)=>$s->date_heure_debut->format('Y-m-d')==$cur->format('Y-m-d')&&$s->date_heure_debut->format('H:i')==$time)->count(); @endphp
                            <td style="padding:0.3rem;height:48px;position:relative;">
                                @if($cnt > 0)
                                <div style="position:absolute;inset:3px;background:#EFF6FF;border-left:2px solid #2D60FF;border-radius:4px;display:flex;align-items:center;justify-content:center;">
                                    <span style="font-size:0.65rem;font-weight:800;color:#2D60FF;">{{ $cnt }} sout.</span>
                                </div>
                                @endif
                            </td>
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endif

@include('admin._table-styles')
</x-app-layout>
