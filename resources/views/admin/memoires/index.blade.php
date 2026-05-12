<x-app-layout>
@section('header', 'Mémoires')

<div class="data-card" style="margin-bottom:1.5rem;">
    <form action="{{ route('admin.memoires.index') }}" method="GET" style="display:flex;gap:1rem;align-items:flex-end;flex-wrap:wrap;padding:1.25rem 1.5rem;">
        <div style="flex:1;min-width:200px;">
            <label class="table-filter-label">Étudiant ou matricule</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, prénom ou matricule..." class="table-filter-input">
        </div>
        <div style="min-width:160px;">
            <label class="table-filter-label">Statut</label>
            <select name="statut" class="table-filter-input">
                <option value="all"        {{ request('statut','all') == 'all'       ? 'selected' : '' }}>Tous</option>
                <option value="en_attente" {{ request('statut') == 'en_attente'      ? 'selected' : '' }}>En attente</option>
                <option value="valide"     {{ request('statut') == 'valide'          ? 'selected' : '' }}>Validés</option>
                <option value="rejete"     {{ request('statut') == 'rejete'          ? 'selected' : '' }}>Rejetés</option>
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
                    <td style="max-width:280px;">
                        <div class="row-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $memoire->titre }}">{{ $memoire->titre }}</div>
                        <div class="row-sub">{{ $memoire->anneeAcademique?->libelle ?? '—' }}</div>
                    </td>
                    <td>
                        <div class="row-text">{{ $memoire->date_depot->format('d/m/Y') }}</div>
                        <div class="row-sub">{{ $memoire->date_depot->format('H:i') }}</div>
                    </td>
                    <td>
                        @php
                            $badges = ['en_attente'=>'badge-amber','valide'=>'badge-green','rejete'=>'badge-red'];
                            $labels = ['en_attente'=>'En attente','valide'=>'Validé','rejete'=>'Rejeté'];
                        @endphp
                        <span class="badge {{ $badges[$memoire->statut] ?? '' }}">{{ $labels[$memoire->statut] ?? $memoire->statut }}</span>
                    </td>
                    <td>
                        <div class="row-actions">
                            <a href="{{ route('admin.memoires.download', $memoire) }}" class="action-btn action-edit" title="Télécharger">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                            @if($memoire->statut == 'en_attente')
                                <form action="{{ route('admin.memoires.valider', $memoire) }}" method="POST" onsubmit="return confirm('Valider ce mémoire ?')">
                                    @csrf
                                    <button type="submit" class="action-btn action-success" title="Valider">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                <button type="button" onclick="openRejetModal({{ $memoire->id }}, '{{ addslashes($memoire->etudiant?->user?->nom ?? '') }}')" class="action-btn action-delete" title="Rejeter">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="empty-state"><svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Aucun mémoire trouvé</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($memoires->hasPages())
        <div class="table-pagination">{{ $memoires->links() }}</div>
    @endif
</div>

{{-- Modale rejet --}}
<div id="rejetModal" onclick="if(event.target===this)closeRejetModal()" style="display:none;position:fixed;inset:0;background:rgba(27,37,75,0.45);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:2rem;width:100%;max-width:440px;margin:1rem;">
        <h3 style="font-size:1rem;font-weight:800;color:#1B254B;margin:0 0 0.4rem;">Rejeter le mémoire</h3>
        <p style="font-size:0.825rem;color:#A3AED0;margin:0 0 1.25rem;">Motif pour <span id="studentName" style="color:#2D60FF;font-weight:700;"></span></p>
        <form id="rejetForm" method="POST">
            @csrf
            <textarea name="motif_rejet" rows="4" required placeholder="Ex : Format non conforme, sujet incomplet..." class="table-filter-input" style="resize:vertical;margin-bottom:1.25rem;"></textarea>
            <div style="display:flex;gap:0.75rem;justify-content:flex-end;">
                <button type="button" onclick="closeRejetModal()" class="btn-outline">Annuler</button>
                <button type="submit" class="btn-premium">Confirmer le rejet</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejetModal(id, name) {
        document.getElementById('studentName').innerText = name;
        document.getElementById('rejetForm').action = `/admin/memoires/${id}/rejeter`;
        document.getElementById('rejetModal').style.display = 'flex';
    }
    function closeRejetModal() {
        document.getElementById('rejetModal').style.display = 'none';
    }
</script>

@include('admin._table-styles')
</x-app-layout>
