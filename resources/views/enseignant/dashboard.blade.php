<x-app-layout>
@section('header', 'Tableau de bord')

<div style="margin-bottom:1.75rem;">
    <h2 style="font-size:1.1rem;font-weight:800;color:#1B254B;margin:0 0 0.25rem;">Bonjour, {{ auth()->user()->prenom }}</h2>
    <p style="font-size:0.825rem;font-weight:500;color:#A3AED0;margin:0;">Gérez vos convocations et les notations des soutenances.</p>
</div>

{{-- KPI --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="kpi-card" style="--accent:#2D60FF;">
        <div class="kpi-top"><span class="kpi-label">Agenda semaine</span><div class="kpi-icon" style="background:rgba(45,96,255,0.08);"><svg width="16" height="16" fill="none" stroke="#2D60FF" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div></div>
        <span class="kpi-value">{{ $weekSoutenances->count() }}</span>
        <span class="kpi-sub">Convocations cette semaine</span>
    </div>
    <div class="kpi-card" style="--accent:#F59E0B;">
        <div class="kpi-top"><span class="kpi-label">À évaluer</span><div class="kpi-icon" style="background:rgba(245,158,11,0.08);"><svg width="16" height="16" fill="none" stroke="#F59E0B" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div></div>
        <span class="kpi-value">{{ $pendingEvaluationsCount }}</span>
        <span class="kpi-sub">Dossiers en attente</span>
    </div>
    <div class="kpi-card" style="--accent:#10B981;">
        <div class="kpi-top"><span class="kpi-label">Terminées</span><div class="kpi-icon" style="background:rgba(16,185,129,0.08);"><svg width="16" height="16" fill="none" stroke="#10B981" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div></div>
        <span class="kpi-value">{{ $completedEvaluationsCount }}</span>
        <span class="kpi-sub">Notes enregistrées</span>
    </div>
    <div class="kpi-card" style="--accent:#7C3AED;">
        <div class="kpi-top"><span class="kpi-label">Statut</span><div class="kpi-icon" style="background:rgba(124,58,237,0.08);"><svg width="16" height="16" fill="none" stroke="#7C3AED" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div></div>
        <span class="kpi-value" style="font-size:1.25rem;">DISPO.</span>
        <span class="kpi-sub">Disponible</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- Prochaines convocations --}}
    <div class="lg:col-span-4">
        <div class="data-card">
            <div class="panel-header"><span class="panel-title">Prochaines convocations</span></div>
            @forelse($upcomingSoutenances as $s)
            <div class="sout-row">
                <div class="sout-date">
                    <span>{{ $s->date_heure_debut->translatedFormat('d M') }}</span>
                    <span>{{ $s->date_heure_debut->format('H:i') }}</span>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="sout-name">{{ $s->etudiant->user->nom }} {{ $s->etudiant->user->prenom }}</div>
                    <div class="sout-salle">{{ $s->salle->nom }}</div>
                </div>
                <a href="{{ route('enseignant.evaluations.evaluate', $s) }}" class="action-btn action-edit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @empty
            <p class="empty-state" style="padding:2rem;">Aucune convocation à venir.</p>
            @endforelse
        </div>
    </div>

    {{-- Agenda semaine --}}
    <div class="lg:col-span-8">
        <div class="data-card">
            <div class="panel-header">
                <span class="panel-title">Mon agenda — {{ now()->translatedFormat('F Y') }}</span>
            </div>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;min-width:600px;">
                    <thead>
                        <tr style="border-bottom:1px solid #F4F7FE;">
                            <th style="padding:0.6rem 1rem;text-align:left;font-size:0.65rem;font-weight:800;color:#A3AED0;text-transform:uppercase;letter-spacing:0.1em;width:60px;"></th>
                            @for($i = 0; $i < 7; $i++)
                            @php $date = $startOfWeek->copy()->addDays($i); @endphp
                            <th style="padding:0.6rem 0.5rem;text-align:center;font-size:0.65rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;{{ $date->isToday() ? 'color:#2D60FF;' : 'color:#A3AED0;' }}">
                                {{ $date->translatedFormat('D d') }}
                            </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['08:00','10:00','13:00','15:00'] as $time)
                        <tr style="border-bottom:1px solid #F4F7FE;">
                            <td style="padding:0.6rem 1rem;font-size:0.65rem;font-weight:700;color:#A3AED0;">{{ $time }}</td>
                            @for($i = 0; $i < 7; $i++)
                            @php
                                $cur = $startOfWeek->copy()->addDays($i);
                                $s = $weekSoutenances->first(fn($s) => $s->date_heure_debut->format('Y-m-d') == $cur->format('Y-m-d') && $s->date_heure_debut->format('H:i') == $time);
                            @endphp
                            <td style="padding:0.3rem;height:56px;position:relative;">
                                @if($s)
                                <a href="{{ route('enseignant.evaluations.evaluate', $s) }}" style="position:absolute;inset:3px;background:#EFF6FF;border-left:2px solid #2D60FF;border-radius:4px;padding:0.3rem 0.5rem;text-decoration:none;overflow:hidden;">
                                    <div style="font-size:0.6rem;font-weight:800;color:#2D60FF;">{{ $s->date_heure_debut->format('H:i') }}</div>
                                    <div style="font-size:0.65rem;font-weight:700;color:#1B254B;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $s->etudiant->user->nom }}</div>
                                </a>
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

@include('admin._table-styles')
<style>
    .sout-row { display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1.25rem;border-bottom:1px solid #F4F7FE;transition:background 0.15s; }
    .sout-row:last-child { border-bottom:none; }
    .sout-row:hover { background:#F4F7FE; }
    .sout-date { display:flex;flex-direction:column;align-items:center;min-width:44px;background:#F4F7FE;border-radius:6px;padding:0.4rem 0.5rem;font-size:0.65rem;font-weight:800;color:#2D60FF;text-transform:uppercase;line-height:1.3; }
    .sout-name { font-size:0.8rem;font-weight:700;color:#1B254B;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
    .sout-salle { font-size:0.7rem;font-weight:500;color:#A3AED0;margin-top:1px; }
</style>
</x-app-layout>
