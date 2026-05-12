<x-app-layout>
@section('header', 'Sessions académiques')

<div class="page-toolbar">
    <p class="page-desc">Périodes académiques et session de référence pour les soutenances.</p>
    <a href="{{ route('admin.annees-academiques.create') }}" class="btn-premium">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Nouvelle session
    </a>
</div>

@if(session('success'))
    <div class="alert-success"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-error"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>{{ session('error') }}</div>
@endif

<div class="data-card">
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Session</th>
                    <th>Période</th>
                    <th>Statut</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($annees as $annee)
                <tr>
                    <td><span class="row-name" style="font-size:1rem;">{{ $annee->libelle }}</span></td>
                    <td>
                        <span class="row-text">
                            {{ \Carbon\Carbon::parse($annee->date_debut)->format('d M Y') }}
                            <span style="color:#A3AED0;margin:0 0.4rem;">→</span>
                            {{ \Carbon\Carbon::parse($annee->date_fin)->format('d M Y') }}
                        </span>
                    </td>
                    <td>
                        @if($annee->active)
                            <span class="badge badge-blue">Active</span>
                        @else
                            <span class="badge" style="background:#F4F7FE;color:#A3AED0;">Archivée</span>
                        @endif
                    </td>
                    <td>
                        <div class="row-actions">
                            <a href="{{ route('admin.annees-academiques.edit', $annee) }}" class="action-btn action-edit" title="Modifier">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @if(!$annee->active)
                            <form action="{{ route('admin.annees-academiques.destroy', $annee) }}" method="POST" onsubmit="return confirm('Supprimer cette session ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Supprimer">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="empty-state"><svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Aucune session enregistrée</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('admin._table-styles')
<style>
    .alert-error { display:flex;align-items:center;gap:0.6rem;background:#FFF5F5;border:1px solid #FECACA;border-radius:8px;padding:0.75rem 1.25rem;font-size:0.825rem;font-weight:600;color:#DC2626;margin-bottom:1.25rem; }
</style>
</x-app-layout>
