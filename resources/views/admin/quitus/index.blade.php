<x-app-layout>
@section('header', 'Quitus')

<div class="data-card" style="margin-bottom:1.5rem;">
    <form action="{{ route('admin.quitus.index') }}" method="GET" style="display:flex;gap:1rem;align-items:flex-end;flex-wrap:wrap;padding:1.25rem 1.5rem;">
        <div style="flex:1;min-width:200px;">
            <label class="table-filter-label">Rechercher</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou matricule..." class="table-filter-input">
        </div>
        <div style="min-width:160px;">
            <label class="table-filter-label">Statut</label>
            <select name="statut" class="table-filter-input">
                <option value="">Tous</option>
                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="valide"     {{ request('statut') == 'valide'     ? 'selected' : '' }}>Validés</option>
            </select>
        </div>
        <button type="submit" class="btn-premium">Filtrer</button>
    </form>
</div>

@if(session('success'))
    <div class="alert-success"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ session('success') }}</div>
@endif

<div class="data-card">
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Matricule</th>
                    <th>Filière / Niveau</th>
                    <th>Mémoire</th>
                    <th>Quitus</th>
                    <th style="text-align:right">Décision</th>
                </tr>
            </thead>
            <tbody>
                @forelse($etudiants as $etudiant)
                <tr>
                    <td>
                        <div class="row-identity">
                            <div class="avatar" style="background:#2D60FF;">{{ substr($etudiant->user->prenom,0,1) }}{{ substr($etudiant->user->nom,0,1) }}</div>
                            <div>
                                <div class="row-name">{{ $etudiant->user->nom }} {{ $etudiant->user->prenom }}</div>
                                <div class="row-sub">{{ $etudiant->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-blue" style="font-family:monospace;">{{ $etudiant->matricule }}</span></td>
                    <td>
                        <div class="row-name">{{ $etudiant->filiere }}</div>
                        <div class="row-sub">{{ $etudiant->niveau }}</div>
                    </td>
                    <td>
                        @if($etudiant->memoires->count() > 0)
                            <span class="badge badge-green">Déposé</span>
                        @else
                            <span class="row-muted" style="font-style:italic;">Non soumis</span>
                        @endif
                    </td>
                    <td>
                        @if($etudiant->quitus_valide)
                            <span class="badge badge-green">Éligible</span>
                        @else
                            <span class="badge badge-amber">En attente</span>
                        @endif
                    </td>
                    <td style="text-align:right">
                        @if(!$etudiant->quitus_valide)
                        <form action="{{ route('admin.quitus.valider', $etudiant) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-premium" style="font-size:0.72rem;padding:0.5rem 1rem;">Valider</button>
                        </form>
                        @else
                            <span class="badge badge-green">Validé</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Aucune demande trouvée</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($etudiants->hasPages())
        <div class="table-pagination">{{ $etudiants->links() }}</div>
    @endif
</div>

@include('admin._table-styles')
</x-app-layout>
