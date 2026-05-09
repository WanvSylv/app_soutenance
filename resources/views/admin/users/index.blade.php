<x-app-layout>
    @section('header', 'Gestion des Comptes')

    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div>
            <p class="text-[#A3AED0] font-bold leading-relaxed max-w-xl">
                Contrôlez les accès à la plateforme en gérant les comptes administrateurs, jurys et étudiants.
            </p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-premium group">
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Créer un Compte
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-3xl animate-fade-in flex items-center shadow-sm">
            <div class="p-2 bg-emerald-500 text-white rounded-xl mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-8 p-6 bg-rose-50 border border-rose-100 text-rose-600 rounded-3xl animate-fade-in flex items-center shadow-sm">
            <div class="p-2 bg-rose-500 text-white rounded-xl mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
    @endif

    <div class="glass-card animate-fade-in" style="animation-delay: 0.1s">
        <div class="overflow-x-auto">
            <table class="w-full premium-table">
                <thead>
                    <tr class="border-b border-[#F4F7FE]">
                        <th class="py-6 px-8 text-left">Utilisateur</th>
                        <th class="py-6 px-8 text-left">Rôle</th>
                        <th class="py-6 px-8 text-left">Contact</th>
                        <th class="py-6 px-8 text-center">Statut</th>
                        <th class="py-6 px-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F4F7FE]">
                    @foreach($users as $user)
                        <tr class="hover:bg-[#F4F7FE]/50 transition-colors">
                            <td class="py-6 px-8">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-2xl overflow-hidden mr-4 shadow-lg shadow-blue-500/20">
                                        @if($user->photo_path)
                                            <img src="{{ asset('storage/' . $user->photo_path) }}" alt="Photo" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-sm">
                                                {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-[#1B254B] mb-0.5">{{ $user->nom }} {{ $user->prenom }}</span>
                                        <span class="text-xs text-[#A3AED0] font-medium">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                @php
                                    $roleLabels = [
                                        'admin' => 'Administrateur',
                                        'super_admin' => 'Super Admin',
                                        'enseignant' => 'Jury',
                                        'etudiant' => 'Étudiant',
                                    ];
                                    $roleClasses = [
                                        'admin' => 'bg-purple-50 text-purple-600 border-purple-100',
                                        'super_admin' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        'enseignant' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'etudiant' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    ];
                                @endphp
                                <span class="px-3 py-1.5 border {{ $roleClasses[$user->role] ?? 'bg-gray-50' }} rounded-xl text-[10px] font-black uppercase tracking-widest">
                                    {{ $roleLabels[$user->role] ?? $user->role }}
                                </span>
                            </td>
                            <td class="py-6 px-8">
                                <span class="text-sm font-bold text-[#1B254B]">{{ $user->telephone ?? 'N/A' }}</span>
                            </td>
                            <td class="py-6 px-8 text-center">
                                @if($user->actif)
                                    <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500 mr-2 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                    <span class="text-[10px] font-black text-[#1B254B] uppercase tracking-widest">Actif</span>
                                @else
                                    <span class="inline-flex h-2 w-2 rounded-full bg-rose-500 mr-2"></span>
                                    <span class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest">Suspendu</span>
                                @endif
                            </td>
                            <td class="py-6 px-8 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-3 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-2xl transition border border-blue-100" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-2xl transition border border-rose-100" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
            <div class="p-8 border-t border-[#F4F7FE]">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
