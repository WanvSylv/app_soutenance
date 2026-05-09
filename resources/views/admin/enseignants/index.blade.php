<x-app-layout>
    @section('header', 'Gestion des Jurys')

    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div>
            <p class="text-[#A3AED0] font-bold leading-relaxed max-w-xl">
                Administrez le corps professoral et gérez les expertises pour les compositions de jurys.
            </p>
        </div>
        <a href="{{ route('admin.enseignants.create') }}" class="btn-premium group">
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Ajouter un Jury
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-3xl animate-fade-in flex items-center">
            <div class="p-2 bg-emerald-500 text-white rounded-xl mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="glass-card animate-fade-in" style="animation-delay: 0.1s">
        <div class="overflow-x-auto">
            <table class="w-full premium-table">
                <thead>
                    <tr class="border-b border-[#F4F7FE]">
                        <th class="py-6 px-8 text-left">Jury</th>
                        <th class="py-6 px-8 text-left">Grade</th>
                        <th class="py-6 px-8 text-left">Spécialité</th>
                        <th class="py-6 px-8 text-left">Email</th>
                        <th class="py-6 px-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F4F7FE]">
                    @forelse($enseignants as $enseignant)
                        <tr class="hover:bg-[#F4F7FE]/50 transition-colors">
                            <td class="py-6 px-8">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-2xl overflow-hidden mr-4 shadow-lg shadow-blue-500/20">
                                        @if($enseignant->user->photo_path)
                                            <img src="{{ asset('storage/' . $enseignant->user->photo_path) }}" alt="Photo" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white font-black text-sm">
                                                {{ substr($enseignant->user->prenom, 0, 1) }}{{ substr($enseignant->user->nom, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-[#1B254B] mb-0.5">{{ $enseignant->user->nom }} {{ $enseignant->user->prenom }}</span>
                                        <span class="text-[10px] text-[#A3AED0] font-black uppercase tracking-widest">{{ $enseignant->departement ?? 'Département non défini' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <span class="px-3 py-1.5 bg-blue-50 text-[#2D60FF] rounded-lg text-xs font-black uppercase tracking-tight">
                                    {{ $enseignant->grade }}
                                </span>
                            </td>
                            <td class="py-6 px-8">
                                <span class="text-sm font-bold text-[#1B254B]">{{ $enseignant->specialite }}</span>
                            </td>
                            <td class="py-6 px-8">
                                <span class="text-sm font-medium text-[#A3AED0]">{{ $enseignant->user->email }}</span>
                            </td>
                            <td class="py-6 px-8 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.enseignants.edit', $enseignant) }}" class="p-3 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-2xl transition border border-blue-100" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.enseignants.destroy', $enseignant) }}" method="POST" class="inline-block" onsubmit="return confirm('Confirmer la suppression de cet enseignant ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-2xl transition border border-rose-100" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-[#F4F7FE] rounded-3xl flex items-center justify-center mb-6 text-[#A3AED0]">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <p class="text-[#A3AED0] font-black text-lg">Aucun enseignant répertorié</p>
                                    <p class="text-[#A3AED0] text-sm mt-1">Ajoutez un enseignant pour commencer la gestion académique.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
