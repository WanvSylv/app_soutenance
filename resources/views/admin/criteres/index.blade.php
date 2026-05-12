<x-app-layout>
@section('header', 'Critères d\'évaluation')

<div class="page-toolbar">
    <p class="page-desc">Indicateurs de performance utilisés lors des soutenances.</p>
    <a href="{{ route('admin.criteres.create') }}" class="btn-premium">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Nouveau critère
    </a>
</div>

@if(session('success'))
    <div class="alert-success"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ session('success') }}</div>
@endif

<div class="data-card">
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Ordre</th>
                    <th>Libellé</th>
                    <th>Description</th>
                    <th>Coefficient</th>
                    <th>Statut</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($criteres as $critere)
                <tr>
                    <td><span class="badge badge-blue">{{ $critere->ordre }}</span></td>
                    <td><span class="row-name">{{ $critere->libelle }}</span></td>
                    <td style="max-width:280px;"><span class="row-muted" style="font-size:0.78rem;">{{ Str::limit($critere->description ?? '—', 70) }}</span></td>
                    <td><span class="row-name" style="color:#2D60FF;">×{{ $critere->coefficient }}</span></td>
                    <td>
                        @if($critere->actif)
                            <span class="badge badge-green">Actif</span>
                        @else
                            <span class="badge" style="background:#F4F7FE;color:#A3AED0;">Inactif</span>
                        @endif
                    </td>
                    <td>
                        <div class="row-actions">
                            <a href="{{ route('admin.criteres.edit', $critere) }}" class="action-btn action-edit" title="Modifier">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.criteres.destroy', $critere) }}" method="POST" onsubmit="return confirm('Supprimer ce critère ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Supprimer">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Aucun critère défini</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('admin._table-styles')
</x-app-layout>
