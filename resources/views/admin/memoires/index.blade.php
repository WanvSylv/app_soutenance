<x-app-layout>
@section('header', 'Mémoires')

<div class="data-card" style="margin-bottom:1.5rem;">
    <form action="{{ route('admin.memoires.index') }}" method="GET" style="display:flex;gap:1rem;align-items:flex-end;flex-wrap:wrap;padding:1.25rem 1.5rem;">
        <div style="flex:1;min-width:200px;">
            <label class="table-filter-label">Étudiant ou matricule</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, prénom ou matricule..." class="table-filter-input">
        </div>
        <div style="min-width:180px;">
            <label class="table-filter-label">Statut</label>
            <select name="statut" class="table-filter-input">
                <option value="all"                    {{ request('statut','all') == 'all'                    ? 'selected' : '' }}>Tous</option>
                <option value="en_attente"             {{ request('statut') == 'en_attente'                   ? 'selected' : '' }}>En attente</option>
                <option value="valide"                 {{ request('statut') == 'valide'                       ? 'selected' : '' }}>Validés</option>
                <option value="rejete"                 {{ request('statut') == 'rejete'                       ? 'selected' : '' }}>Rejetés</option>
                <option value="corrections_demandees"  {{ request('statut') == 'corrections_demandees'        ? 'selected' : '' }}>Corrections demandées</option>
            </select>
        </div>
        <button type="submit" class="btn-premium">Filtrer</button>
    </form>
</div>

@if(session('success'))
    <div class="alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif

<div class="data-card">
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Thème du mémoire</th>
                    <th>Date de dépôt</th>
                    <th>Version</th>
                    <th>Statut</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($memoires as $memoire)
                <tr>
                    <td>
                        <div class="row-identity">
                            <div class="avatar" style="background:#2D60FF;">
                                {{ substr($memoire->etudiant?->user?->nom ?? 'E', 0, 1) }}{{ substr($memoire->etudiant?->user?->prenom ?? 'T', 0, 1) }}
                            </div>
                            <div>
                                <div class="row-name">{{ $memoire->etudiant?->user?->nom }} {{ $memoire->etudiant?->user?->prenom }}</div>
                                <div class="row-sub">{{ $memoire->etudiant?->matricule ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="max-width:260px;">
                        <div class="row-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $memoire->titre }}">{{ $memoire->titre }}</div>
                        <div class="row-sub">{{ $memoire->anneeAcademique?->libelle ?? '—' }}</div>
                    </td>
                    <td>
                        <div class="row-text">{{ $memoire->date_depot->format('d/m/Y') }}</div>
                        <div class="row-sub">{{ $memoire->date_depot->format('H:i') }}</div>
                    </td>
                    <td>
                        <span style="font-size:0.78rem;font-weight:700;color:#2D60FF;">V{{ $memoire->numero_version }}</span>
                    </td>
                    <td>
                        @php
                            $badges = [
                                'en_attente'            => 'badge-amber',
                                'valide'                => 'badge-green',
                                'rejete'                => 'badge-red',
                                'corrections_demandees' => 'badge-orange',
                            ];
                            $labels = [
                                'en_attente'            => 'En attente',
                                'valide'                => 'Validé',
                                'rejete'                => 'Rejeté',
                                'corrections_demandees' => 'Corrections dem.',
                            ];
                        @endphp
                        <span class="badge {{ $badges[$memoire->statut] ?? 'badge-amber' }}">{{ $labels[$memoire->statut] ?? $memoire->statut }}</span>
                    </td>
                    <td>
                        <div class="row-actions">
                            <a href="{{ route('admin.memoires.download', $memoire) }}" class="action-btn action-edit" title="Télécharger">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>

                            {{-- Voir historique des versions --}}
                            @if($memoire->numero_version > 1)
                                <button type="button" onclick="openHistoriqueModal({{ $memoire->id }})" class="action-btn" style="background:#EFF6FF;color:#2D60FF;border:1px solid #BFDBFE;" title="Historique des versions">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </button>
                            @endif

                            @if($memoire->statut === 'en_attente')
                                <form action="{{ route('admin.memoires.valider', $memoire) }}" method="POST" onsubmit="return confirm('Valider ce mémoire ?')">
                                    @csrf
                                    <button type="submit" class="action-btn action-success" title="Valider">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                <button type="button" onclick="openCorrectionModal({{ $memoire->id }}, '{{ addslashes($memoire->etudiant?->user?->nom ?? '') }}')" class="action-btn" style="background:#FFFBEB;color:#D97706;border:1px solid #FDE68A;" title="Demander corrections">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button type="button" onclick="openRejetModal({{ $memoire->id }}, '{{ addslashes($memoire->etudiant?->user?->nom ?? '') }}')" class="action-btn action-delete" title="Rejeter">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Aucun mémoire trouvé</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($memoires->hasPages())
        <div class="table-pagination">{{ $memoires->links() }}</div>
    @endif
</div>

{{-- Modale rejet --}}
<div id="rejetModal" onclick="if(event.target===this)this.style.display='none'" style="display:none;position:fixed;inset:0;background:rgba(27,37,75,0.45);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:2rem;width:100%;max-width:440px;margin:1rem;">
        <h3 style="font-size:1rem;font-weight:800;color:#1B254B;margin:0 0 0.4rem;">Rejeter le mémoire</h3>
        <p style="font-size:0.825rem;color:#A3AED0;margin:0 0 1.25rem;">Motif pour <span id="studentNameRejet" style="color:#DC2626;font-weight:700;"></span></p>
        <form id="rejetForm" method="POST">
            @csrf
            <textarea name="motif_rejet" rows="4" required placeholder="Ex : Format non conforme, sujet incomplet..." class="table-filter-input" style="resize:vertical;margin-bottom:1.25rem;"></textarea>
            <p style="font-size:0.75rem;color:#A3AED0;margin:0 0 1rem;">Un email sera envoyé automatiquement à l'étudiant avec ce motif.</p>
            <div style="display:flex;gap:0.75rem;justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('rejetModal').style.display='none'" class="btn-outline">Annuler</button>
                <button type="submit" class="btn-premium" style="background:#DC2626;">Confirmer le rejet</button>
            </div>
        </form>
    </div>
</div>

{{-- Modale corrections --}}
<div id="correctionModal" onclick="if(event.target===this)this.style.display='none'" style="display:none;position:fixed;inset:0;background:rgba(27,37,75,0.45);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:2rem;width:100%;max-width:480px;margin:1rem;">
        <h3 style="font-size:1rem;font-weight:800;color:#1B254B;margin:0 0 0.4rem;">Demander des corrections</h3>
        <p style="font-size:0.825rem;color:#A3AED0;margin:0 0 1.25rem;">Corrections pour <span id="studentNameCorrection" style="color:#D97706;font-weight:700;"></span></p>
        <form id="correctionForm" method="POST">
            @csrf
            <textarea name="motif_correction" rows="6" required placeholder="Décrivez précisément les corrections attendues..." class="table-filter-input" style="resize:vertical;margin-bottom:1.25rem;"></textarea>
            <p style="font-size:0.75rem;color:#A3AED0;margin:0 0 1rem;">L'étudiant recevra un email avec ces instructions et pourra soumettre une nouvelle version.</p>
            <div style="display:flex;gap:0.75rem;justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('correctionModal').style.display='none'" class="btn-outline">Annuler</button>
                <button type="submit" class="btn-premium" style="background:#D97706;">Envoyer la demande</button>
            </div>
        </form>
    </div>
</div>

{{-- Modale historique versions --}}
<div id="historiqueModal" onclick="if(event.target===this)this.style.display='none'" style="display:none;position:fixed;inset:0;background:rgba(27,37,75,0.45);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:2rem;width:100%;max-width:620px;margin:1rem;max-height:80vh;overflow-y:auto;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
            <h3 style="font-size:1rem;font-weight:800;color:#1B254B;margin:0;">Historique des versions</h3>
            <button type="button" onclick="document.getElementById('historiqueModal').style.display='none'" style="background:none;border:none;cursor:pointer;color:#A3AED0;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="historiqueContent">
            <div style="text-align:center;color:#A3AED0;padding:2rem;">Chargement...</div>
        </div>
    </div>
</div>

{{-- Données versions pour JS --}}
@php
    $versionsDataPhp = [];
    foreach ($memoires as $m) {
        $versionsDataPhp[$m->id] = $m->versions()->orderByDesc('numero_version')->get()->map(function($v) {
            return [
                'version'     => $v->numero_version,
                'titre'       => $v->titre,
                'date'        => $v->date_depot->format('d/m/Y H:i'),
                'taille'      => number_format($v->taille_fichier_ko / 1024, 1) . ' Mo',
                'statut'      => $v->statut_apres ?? '—',
                'motif'       => $v->motif ?? '',
                'downloadUrl' => route('admin.memoires.version.download', $v),
            ];
        })->values()->all();
    }
@endphp
<script>
    const versionsData = @json($versionsDataPhp);

    const statutLabels = {
        'valide': '<span class="badge badge-green">Validé</span>',
        'rejete': '<span class="badge badge-red">Rejeté</span>',
        'corrections_demandees': '<span class="badge badge-orange">Corrections dem.</span>',
        'en_attente': '<span class="badge badge-amber">En attente</span>',
        '—': '—',
    };

    function openRejetModal(id, name) {
        document.getElementById('studentNameRejet').innerText = name;
        document.getElementById('rejetForm').action = `/admin/memoires/${id}/rejeter`;
        document.getElementById('rejetModal').style.display = 'flex';
    }

    function openCorrectionModal(id, name) {
        document.getElementById('studentNameCorrection').innerText = name;
        document.getElementById('correctionForm').action = `/admin/memoires/${id}/corrections`;
        document.getElementById('correctionModal').style.display = 'flex';
    }

    function openHistoriqueModal(id) {
        const versions = versionsData[id] || [];
        let html = '';
        if (versions.length === 0) {
            html = '<p style="color:#A3AED0;text-align:center;">Aucune version archivée.</p>';
        } else {
            versions.forEach(v => {
                const badgeHtml = statutLabels[v.statut] || v.statut;
                const motifHtml = v.motif
                    ? `<div style="background:#FFF5F5;border:1px solid #FECACA;border-radius:6px;padding:0.6rem 0.875rem;margin-top:0.5rem;font-size:0.78rem;color:#DC2626;">${v.motif.replace(/\n/g,'<br>')}</div>`
                    : '';
                html += `
                    <div style="border:1px solid #E0E5F2;border-radius:8px;padding:1rem;margin-bottom:0.875rem;">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:0.75rem;flex-wrap:wrap;margin-bottom:0.5rem;">
                            <div>
                                <span style="font-size:0.9rem;font-weight:800;color:#2D60FF;">V${v.version}</span>
                                <span style="font-size:0.78rem;color:#A3AED0;margin-left:0.5rem;">${v.date} — ${v.taille}</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                ${badgeHtml}
                                <a href="${v.downloadUrl}" style="font-size:0.72rem;background:#EFF6FF;color:#2D60FF;border:1px solid #BFDBFE;border-radius:5px;padding:0.25rem 0.65rem;text-decoration:none;font-weight:600;">↓ Télécharger</a>
                            </div>
                        </div>
                        <div style="font-size:0.8rem;font-weight:600;color:#1B254B;">${v.titre}</div>
                        ${motifHtml}
                    </div>`;
            });
        }
        document.getElementById('historiqueContent').innerHTML = html;
        document.getElementById('historiqueModal').style.display = 'flex';
    }
</script>

<style>
.badge-orange { background:#FFFBEB; color:#D97706; border:1px solid #FDE68A; }
</style>

@include('admin._table-styles')
</x-app-layout>
