<x-app-layout>
@section('header', 'Étudiants')

<div class="page-toolbar">
    <p class="page-desc">Inscriptions et dossiers académiques des étudiants.</p>
    <a href="{{ route('admin.etudiants.create') }}" class="btn-premium">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Inscrire un étudiant
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
                    <th>Étudiant</th>
                    <th>Matricule</th>
                    <th>Filière / Niveau</th>
                    <th style="text-align:center">Quitus</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($etudiants as $etudiant)
                <tr>
                    <td>
                        <div class="row-identity">
                            <div class="avatar" style="background:#10B981;">
                                {{ substr($etudiant->user?->prenom ?? 'E', 0, 1) }}{{ substr($etudiant->user?->nom ?? 'T', 0, 1) }}
                            </div>
                            <div>
                                <div class="row-name">{{ $etudiant->user?->nom }} {{ $etudiant->user?->prenom }}</div>
                                <div class="row-sub">{{ $etudiant->user?->email ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-blue" style="font-family:monospace;">{{ $etudiant->matricule }}</span></td>
                    <td>
                        <div class="row-name">{{ $etudiant->filiere }}</div>
                        <div class="row-sub">{{ $etudiant->niveau }}</div>
                    </td>
                    <td style="text-align:center">
                        @if($etudiant->quitus_valide)
                            <span class="badge badge-green">Validé</span>
                        @else
                            <span class="badge badge-amber">En attente</span>
                        @endif
                    </td>
                    <td>
                        <div class="row-actions">
                            @if(!$etudiant->quitus_valide)
                            <form action="{{ route('admin.quitus.valider', $etudiant) }}" method="POST">
                                @csrf
                                <button type="submit" class="action-btn action-success" title="Valider le quitus">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('admin.etudiants.edit', $etudiant) }}" class="action-btn action-edit" title="Modifier">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.etudiants.destroy', $etudiant) }}" method="POST" onsubmit="return confirm('Supprimer cet étudiant ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Supprimer">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($etudiants->hasPages())
        <div class="table-pagination">{{ $etudiants->links() }}</div>
    @endif
</div>

@include('admin._table-styles')
</x-app-layout>
