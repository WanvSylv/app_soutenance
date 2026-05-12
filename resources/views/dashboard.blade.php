<x-app-layout>
@section('header', 'Tableau de bord')

{{-- ─── En-tête ─────────────────────────────────────────── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-8">
    <div>
        <h2 class="text-xl font-bold text-[#1B254B]">Bonjour, {{ auth()->user()->prenom }}</h2>
        <p class="text-sm text-[#A3AED0] mt-0.5">Aperçu de l'activité des soutenances</p>
    </div>

    @if(auth()->user()->isAdmin())
    <form action="{{ route('dashboard') }}" method="GET">
        <select name="annee_id" onchange="this.form.submit()"
            style="background:#F4F7FE;border:1.5px solid #E0E5F2;border-radius:6px;color:#1B254B;padding:0.5rem 1rem;font-family:inherit;font-size:0.8rem;font-weight:600;cursor:pointer;outline:none;">
            @foreach($annees as $annee)
                <option value="{{ $annee->id }}" {{ $anneeFiltre && $anneeFiltre->id == $annee->id ? 'selected' : '' }}>
                    {{ $annee->libelle }}{{ $annee->active ? ' — Active' : '' }}
                </option>
            @endforeach
        </select>
    </form>
    @endif
</div>

{{-- ─── KPI Cards ───────────────────────────────────────── --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">

    <div class="kpi-card" style="--accent:#2D60FF;">
        <div class="kpi-top">
            <span class="kpi-label">Soutenances</span>
            <div class="kpi-icon" style="background:rgba(45,96,255,0.08);">
                <svg width="16" height="16" fill="none" stroke="#2D60FF" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <span class="kpi-value">{{ $stats['soutenances_count'] }}</span>
        <span class="kpi-sub">{{ $anneeFiltre ? $anneeFiltre->libelle : 'Total' }}</span>
    </div>

    <div class="kpi-card" style="--accent:#10B981;">
        <div class="kpi-top">
            <span class="kpi-label">À venir</span>
            <div class="kpi-icon" style="background:rgba(16,185,129,0.08);">
                <svg width="16" height="16" fill="none" stroke="#10B981" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <span class="kpi-value">{{ $upcomingSoutenances->count() }}</span>
        <span class="kpi-sub">Planifiées</span>
    </div>

    <div class="kpi-card" style="--accent:#F59E0B;">
        <div class="kpi-top">
            <span class="kpi-label">Alertes</span>
            <div class="kpi-icon" style="background:rgba(245,158,11,0.08);">
                <svg width="16" height="16" fill="none" stroke="#F59E0B" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
        <span class="kpi-value">{{ $conflitsCount }}</span>
        <span class="kpi-sub">Conflits détectés</span>
    </div>

    <div class="kpi-card" style="--accent:#7C3AED;">
        <div class="kpi-top">
            <span class="kpi-label">Délibérations</span>
            <div class="kpi-icon" style="background:rgba(124,58,237,0.08);">
                <svg width="16" height="16" fill="none" stroke="#7C3AED" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <span class="kpi-value">{{ $pvAttenteCount }}</span>
        <span class="kpi-sub">PV à générer</span>
    </div>

    <div class="kpi-card" style="--accent:#14B8A6;">
        <div class="kpi-top">
            <span class="kpi-label">Réussite</span>
            <div class="kpi-icon" style="background:rgba(20,184,166,0.08);">
                <svg width="16" height="16" fill="none" stroke="#14B8A6" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
        <span class="kpi-value">{{ $tauxReussite }}<span style="font-size:1.25rem;font-weight:600;">%</span></span>
        <span class="kpi-sub">Taux global</span>
    </div>

</div>

{{-- ─── Alertes ─────────────────────────────────────────── --}}
@if(isset($indisponibilitesJury) && $indisponibilitesJury->count() > 0)
<div class="alert-block alert-red mb-4">
    <div class="alert-header">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <strong>{{ $indisponibilitesJury->count() }} jury(s) indisponible(s)</strong>
    </div>
    @foreach($indisponibilitesJury as $indispo)
    <div class="alert-row">
        <div>
            <span class="alert-name">{{ $indispo->enseignant?->user?->nom }} {{ $indispo->enseignant?->user?->prenom }}</span>
            <span class="alert-detail">Soutenance de {{ $indispo->soutenance?->etudiant?->user?->nom }} — {{ $indispo->soutenance?->date_heure_debut?->format('d/m/Y H:i') }}</span>
            @if($indispo->motif_indisponibilite)
            <span class="alert-motif">"{{ $indispo->motif_indisponibilite }}"</span>
            @endif
        </div>
        <a href="{{ route('admin.planification.edit', $indispo->soutenance_id) }}" class="btn-premium">Remplacer</a>
    </div>
    @endforeach
</div>
@endif

@if(isset($soutenancesExpirees) && $soutenancesExpireesCount > 0)
<div class="alert-block alert-amber mb-8">
    <div class="alert-header">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <strong>{{ $soutenancesExpireesCount }} soutenance(s) passée(s) sans évaluation</strong>
    </div>
    @foreach($soutenancesExpirees as $exp)
    <div class="alert-row">
        <div>
            <span class="alert-name">{{ $exp->etudiant?->user?->nom }} {{ $exp->etudiant?->user?->prenom }}</span>
            <span class="alert-detail">Prévue le {{ $exp->date_heure_debut?->format('d/m/Y à H:i') }} — {{ $exp->salle?->nom }}</span>
        </div>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
            <a href="{{ route('admin.planification.edit', $exp->id) }}" class="btn-outline">Modifier</a>
            <form action="{{ route('admin.planification.annuler', $exp->id) }}" method="POST" onsubmit="return confirm('Marquer comme annulée ?')">
                @csrf
                <button type="submit" class="btn-premium">Annuler</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- ─── Contenu principal ───────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- Colonne gauche --}}
    <div class="lg:col-span-4 flex flex-col gap-6">

        {{-- Prochaines soutenances --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Prochaines soutenances</span>
                <a href="{{ route('planification.index') }}" class="panel-link">Voir tout</a>
            </div>
            <div class="panel-body">
                @forelse($upcomingSoutenances->take(6) as $s)
                <div class="sout-row">
                    <div class="sout-date">
                        <span>{{ $s->date_heure_debut->translatedFormat('d M') }}</span>
                        <span>{{ $s->date_heure_debut->format('H:i') }}</span>
                    </div>
                    <div class="sout-info">
                        <span class="sout-name">{{ $s->etudiant?->user?->nom }} {{ $s->etudiant?->user?->prenom }}</span>
                        <span class="sout-salle">{{ $s->salle->nom }}</span>
                    </div>
                </div>
                @empty
                <p class="empty-state">Aucune soutenance planifiée</p>
                @endforelse
            </div>
        </div>

        {{-- Mentions --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Répartition des mentions</span>
            </div>
            <div class="panel-body" style="padding:1.25rem 1.5rem;">
                @foreach($mentionsCount as $mention => $count)
                @php
                    $pct = $totalTerminees > 0 ? round(($count / $totalTerminees) * 100) : 0;
                    $colors = ['Très Bien'=>'#7C3AED','Bien'=>'#2D60FF','Assez Bien'=>'#10B981','Passable'=>'#F59E0B','Ajourné'=>'#EF4444'];
                    $c = $colors[$mention] ?? '#A3AED0';
                @endphp
                <div style="margin-bottom:0.9rem;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.3rem;">
                        <span style="font-size:0.75rem;font-weight:700;color:#1B254B;">{{ $mention }}</span>
                        <span style="font-size:0.75rem;font-weight:600;color:#A3AED0;">{{ $count }}</span>
                    </div>
                    <div style="height:4px;background:#F4F7FE;border-radius:2px;overflow:hidden;">
                        <div style="height:100%;width:{{ $pct }}%;background:{{ $c }};border-radius:2px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Planning hebdomadaire --}}
    <div class="lg:col-span-8">
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Planning — {{ now()->translatedFormat('F Y') }}</span>
                <a href="{{ route('admin.export.planning.hebdo') }}" target="_blank" class="btn-outline" style="font-size:0.7rem;padding:0.35rem 0.85rem;">
                    Exporter PDF
                </a>
            </div>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid #F4F7FE;">
                            <th style="padding:0.75rem 1rem;text-align:left;font-size:0.65rem;font-weight:800;color:#A3AED0;text-transform:uppercase;letter-spacing:0.1em;white-space:nowrap;width:100px;">Salle</th>
                            @for($i = 0; $i < 7; $i++)
                                @php $date = $startOfWeek->copy()->addDays($i); @endphp
                                <th style="padding:0.75rem 0.5rem;text-align:center;font-size:0.65rem;font-weight:800;color:{{ $date->isToday() ? '#2D60FF' : '#A3AED0' }};text-transform:uppercase;letter-spacing:0.08em;white-space:nowrap;">
                                    {{ $date->translatedFormat('D d') }}
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salles->take(5) as $salle)
                        <tr style="border-bottom:1px solid #F4F7FE;">
                            <td style="padding:0.75rem 1rem;font-size:0.7rem;font-weight:700;color:#1B254B;white-space:nowrap;">{{ $salle->nom }}</td>
                            @for($i = 0; $i < 7; $i++)
                                @php
                                    $cur = $startOfWeek->copy()->addDays($i);
                                    $soutsJour = $weekSoutenances->filter(fn($s) => $s->salle_id == $salle->id && $s->date_heure_debut->isSameDay($cur));
                                @endphp
                                <td style="padding:0.3rem;vertical-align:top;">
                                    @foreach($soutsJour as $sout)
                                    @php
                                        $sc = ['planifiee'=>['#EFF6FF','#2D60FF'],'terminee'=>['#F5F3FF','#7C3AED'],'deliberee'=>['#F0FDF4','#10B981']][$sout->statut] ?? ['#FFF7ED','#F59E0B'];
                                    @endphp
                                    <div style="background:{{ $sc[0] }};border-left:2px solid {{ $sc[1] }};padding:0.3rem 0.5rem;border-radius:3px;margin-bottom:2px;">
                                        <div style="font-size:0.6rem;font-weight:800;color:{{ $sc[1] }};">{{ $sout->date_heure_debut->format('H:i') }}</div>
                                        <div style="font-size:0.65rem;font-weight:700;color:#1B254B;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:80px;">{{ $sout->etudiant?->user?->nom }}</div>
                                    </div>
                                    @endforeach
                                </td>
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:1rem 1.5rem;border-top:1px solid #F4F7FE;display:flex;gap:1.5rem;flex-wrap:wrap;">
                @foreach(['Planifiée'=>['#EFF6FF','#2D60FF'],'Terminée'=>['#F5F3FF','#7C3AED'],'Délibérée'=>['#F0FDF4','#10B981']] as $label => [$bg, $color])
                <div style="display:flex;align-items:center;gap:0.4rem;">
                    <span style="width:10px;height:10px;border-radius:2px;background:{{ $bg }};border-left:2px solid {{ $color }};display:inline-block;"></span>
                    <span style="font-size:0.65rem;font-weight:700;color:#A3AED0;text-transform:uppercase;letter-spacing:0.08em;">{{ $label }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<style>
    /* KPI */
    .kpi-card {
        background: #fff;
        border: 1.5px solid #E0E5F2;
        border-radius: 8px;
        padding: 1.25rem 1.25rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        transition: border-color 0.2s ease;
    }

    .kpi-card:hover {
        border-color: var(--accent);
    }
    .kpi-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .kpi-icon {
        width: 30px; height: 30px;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .kpi-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--accent);
    }
    .kpi-value {
        font-size: 2.25rem;
        font-weight: 900;
        color: #1B254B;
        line-height: 1;
        margin: 0.2rem 0;
    }
    .kpi-sub {
        font-size: 0.7rem;
        font-weight: 600;
        color: #A3AED0;
    }

    /* Alertes */
    .alert-block {
        border-radius: 8px;
        border: 1px solid;
        overflow: hidden;
    }
    .alert-red  { border-color: #FECACA; background: #FFF5F5; }
    .alert-amber{ border-color: #FDE68A; background: #FFFBEB; }

    .alert-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        font-size: 0.8rem;
        font-weight: 700;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .alert-red  .alert-header { color: #DC2626; }
    .alert-amber .alert-header { color: #D97706; }

    .alert-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        flex-wrap: wrap;
    }
    .alert-row:last-child { border-bottom: none; }
    .alert-name  { display:block; font-size:0.8rem; font-weight:700; color:#1B254B; }
    .alert-detail{ display:block; font-size:0.72rem; font-weight:500; color:#A3AED0; margin-top:2px; }
    .alert-motif { display:block; font-size:0.72rem; font-style:italic; color:#A3AED0; margin-top:2px; }

    /* Panels */
    .panel {
        background: #fff;
        border: 1px solid #E0E5F2;
        border-radius: 8px;
        overflow: hidden;
    }
    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #F4F7FE;
    }
    .panel-title {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #1B254B;
    }
    .panel-link {
        font-size: 0.7rem;
        font-weight: 700;
        color: #2D60FF;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .panel-link:hover { text-decoration: underline; }
    .panel-body { display: flex; flex-direction: column; }

    /* Soutenance rows */
    .sout-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1.5rem;
        border-bottom: 1px solid #F4F7FE;
        transition: background 0.15s;
    }
    .sout-row:last-child { border-bottom: none; }
    .sout-row:hover { background: #F4F7FE; }

    .sout-date {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 44px;
        background: #F4F7FE;
        border-radius: 6px;
        padding: 0.4rem 0.5rem;
        font-size: 0.65rem;
        font-weight: 800;
        color: #2D60FF;
        text-transform: uppercase;
        line-height: 1.3;
    }

    .sout-info { display: flex; flex-direction: column; min-width: 0; }
    .sout-name  { font-size: 0.8rem; font-weight: 700; color: #1B254B; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sout-salle { font-size: 0.7rem; font-weight: 500; color: #A3AED0; margin-top: 1px; }

    .empty-state {
        padding: 2rem;
        text-align: center;
        font-size: 0.8rem;
        font-weight: 500;
        color: #A3AED0;
        font-style: italic;
    }

    /* Bouton outline */
    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: transparent;
        color: #1B254B;
        border: 1.5px solid #E0E5F2;
        border-radius: 6px;
        font-family: inherit;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.5rem 1rem;
        text-decoration: none;
        cursor: pointer;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        transition: border-color 0.15s, color 0.15s;
    }
    .btn-outline:hover { border-color: #2D60FF; color: #2D60FF; }
</style>

</x-app-layout>
