<x-app-layout>
@section('header', 'Jurys')

<div class="page-toolbar">
    <p class="page-desc">Corps professoral et composition des jurys de soutenance.</p>
    <a href="{{ route('admin.enseignants.create') }}" class="btn-premium">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Ajouter un jury
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
                    <th>Jury</th>
                    <th>Grade</th>
                    <th>Spécialité</th>
                    <th>Email</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enseignants as $enseignant)
                <tr>
                    <td>
                        <div class="row-identity">
                            <div class="avatar" style="background:#2D60FF;">
                                {{ substr($enseignant->user?->prenom ?? 'E', 0, 1) }}{{ substr($enseignant->user?->nom ?? 'N', 0, 1) }}
                            </div>
                            <div>
                                <div class="row-name">{{ $enseignant->user?->nom }} {{ $enseignant->user?->prenom }}</div>
                                <div class="row-sub">{{ $enseignant->departement ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-blue">{{ $enseignant->grade }}</span></td>
                    <td><span class="row-text">{{ $enseignant->specialite }}</span></td>
                    <td><span class="row-muted">{{ $enseignant->user?->email ?? '—' }}</span></td>
                    <td>
                        <div class="row-actions">
                            <a href="{{ route('admin.enseignants.edit', $enseignant) }}" class="action-btn action-edit" title="Modifier">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.enseignants.destroy', $enseignant) }}" method="POST" onsubmit="return confirm('Supprimer cet enseignant ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Supprimer">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="empty-state"><svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Aucun enseignant répertorié</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('admin._table-styles')
</x-app-layout>
