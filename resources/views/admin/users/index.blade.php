<x-app-layout>
@section('header', 'Comptes')

<div class="page-toolbar">
    <p class="page-desc">Gestion des accès administrateurs, jurys et étudiants.</p>
    <a href="{{ route('admin.users.create') }}" class="btn-premium">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Créer un compte
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
                    <th>Utilisateur</th>
                    <th>Rôle</th>
                    <th>Téléphone</th>
                    <th>Statut</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                @php
                    $roleLabels = ['admin'=>'Admin','super_admin'=>'Super Admin','enseignant'=>'Jury','etudiant'=>'Étudiant'];
                    $roleColors = ['admin'=>'#7C3AED','super_admin'=>'#DC2626','enseignant'=>'#2D60FF','etudiant'=>'#10B981'];
                    $avatarColor = $roleColors[$user->role] ?? '#A3AED0';
                @endphp
                <tr>
                    <td>
                        <div class="row-identity">
                            <div class="avatar" style="background:{{ $avatarColor }};">{{ substr($user->prenom,0,1) }}{{ substr($user->nom,0,1) }}</div>
                            <div>
                                <div class="row-name">{{ $user->nom }} {{ $user->prenom }}</div>
                                <div class="row-sub">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background:{{ $avatarColor }}18;color:{{ $avatarColor }};">
                            {{ $roleLabels[$user->role] ?? $user->role }}
                        </span>
                    </td>
                    <td><span class="row-muted">{{ $user->telephone ?? '—' }}</span></td>
                    <td>
                        @if($user->actif)
                            <span class="badge badge-green">Actif</span>
                        @else
                            <span class="badge badge-red">Suspendu</span>
                        @endif
                    </td>
                    <td>
                        <div class="row-actions">
                            <a href="{{ route('admin.users.edit', $user) }}" class="action-btn action-edit" title="Modifier">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Supprimer ce compte ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Supprimer">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="table-pagination">{{ $users->links() }}</div>
    @endif
</div>

@include('admin._table-styles')
<style>
    .alert-error { display:flex;align-items:center;gap:0.6rem;background:#FFF5F5;border:1px solid #FECACA;border-radius:8px;padding:0.75rem 1.25rem;font-size:0.825rem;font-weight:600;color:#DC2626;margin-bottom:1.25rem; }
</style>
</x-app-layout>
