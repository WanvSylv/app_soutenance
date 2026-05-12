<x-app-layout>
@section('header', 'Salles')

<div class="page-toolbar">
    <p class="page-desc">Salles et amphithéâtres disponibles pour les soutenances.</p>
    <a href="{{ route('admin.salles.create') }}" class="btn-premium">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Ajouter une salle
    </a>
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
                    <th>Code & Désignation</th>
                    <th>Capacité</th>
                    <th>Localisation</th>
                    <th>Statut</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salles as $salle)
                <tr>
                    <td>
                        <div class="row-identity">
                            <div class="avatar" style="background:#7C3AED;font-size:0.6rem;">{{ $salle->code }}</div>
                            <div class="row-name">{{ $salle->nom }}</div>
                        </div>
                    </td>
                    <td><span class="row-text">{{ $salle->capacite ?? '—' }} <span class="row-muted">places</span></span></td>
                    <td><span class="row-text">{{ $salle->localisation ?? '—' }}</span></td>
                    <td>
                        @if($salle->disponible)
                            <span class="badge badge-green">Opérationnelle</span>
                        @else
                            <span class="badge badge-red">Maintenance</span>
                        @endif
                    </td>
                    <td>
                        <div class="row-actions">
                            <a href="{{ route('admin.salles.edit', $salle) }}" class="action-btn action-edit" title="Modifier">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.salles.destroy', $salle) }}" method="POST" onsubmit="return confirm('Supprimer cette salle ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Supprimer">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="empty-state"><svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Aucune salle configurée</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('admin._table-styles')
</x-app-layout>
