<x-app-layout>
    @section('header', 'Mon Espace Étudiant')

    <!-- Top Greeting -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg md:text-xl font-black text-[#1B254B]">Bonjour, {{ auth()->user()->prenom }} 👋</h2>
            <p class="text-[#A3AED0] text-sm font-bold mt-1">Suivez l'état de votre soutenance et consultez vos résultats.</p>
        </div>
    </div>

    @if(!$etudiant)
        <div class="glass-card p-12 text-center animate-fade-in">
            <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6 text-amber-500">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-[#1B254B]">Profil incomplet</h3>
            <p class="text-[#A3AED0] mt-2">Votre profil étudiant n'est pas encore configuré par l'administration.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: My Soutenance Details -->
            <div class="lg:col-span-4 flex flex-col gap-8">
                <!-- Quitus Status -->
                <div class="glass-card p-6 {{ $etudiant->quitus_valide ? 'border-l-4 border-emerald-500' : 'border-l-4 border-amber-500' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] mb-1">Statut du Quitus</p>
                            <h4 class="text-lg font-black {{ $etudiant->quitus_valide ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $etudiant->quitus_valide ? 'VALIDÉ' : 'EN ATTENTE' }}
                            </h4>
                        </div>
                        <div class="p-3 {{ $etudiant->quitus_valide ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} rounded-2xl">
                            @if($etudiant->quitus_valide)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- My Soutenance -->
                <div class="glass-card overflow-hidden">
                    <div class="p-6 border-b border-[#F4F7FE] bg-white">
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-[#1B254B]">Ma Soutenance</h3>
                    </div>
                    <div class="p-6">
                        @if(!$soutenance)
                            <div class="text-center py-8">
                                <p class="text-sm font-bold text-[#A3AED0]">Votre soutenance n'est pas encore planifiée.</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                <div>
                                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-2">Sujet</p>
                                    <p class="text-sm font-bold text-[#1B254B] leading-relaxed">{{ $soutenance->sujet }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Date & Heure</p>
                                        <p class="text-xs font-black text-[#1B254B]">{{ $soutenance->date_heure_debut->translatedFormat('d M Y à H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Salle</p>
                                        <p class="text-xs font-black text-[#1B254B]">{{ $soutenance->salle->nom }} [{{ $soutenance->salle->code }}]</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3">Composition du Jury</p>
                                    <div class="space-y-3">
                                        @foreach($soutenance->juryMembres as $membre)
                                            <div class="flex items-center gap-3">
                                                <div class="h-8 w-8 rounded-full bg-[#F4F7FE] flex items-center justify-center text-[10px] font-black text-blue-600">
                                                    {{ substr($membre->enseignant->user->prenom, 0, 1) }}{{ substr($membre->enseignant->user->nom, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-[#1B254B]">{{ $membre->enseignant->user->nom }} {{ $membre->enseignant->user->prenom }}</p>
                                                    <p class="text-[9px] text-[#A3AED0] uppercase font-black">{{ $membre->role }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- My Memoir -->
                <div class="glass-card p-6">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-[#1B254B] mb-6">Mon Mémoire</h3>
                    @if($memoire)
                        <div class="flex flex-col gap-4 p-5 bg-[#F4F7FE] rounded-2xl border border-[#E0E5F2]">
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-white text-rose-500 rounded-xl shadow-sm shrink-0">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-1">Titre du mémoire :</p>
                                    <p class="text-sm font-bold text-[#1B254B] leading-snug">{{ $memoire->titre }}</p>
                                    <p class="text-[10px] text-[#A3AED0] mt-2 font-bold uppercase">Déposé le : {{ $memoire->updated_at->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t border-white/50 flex justify-end">
                                <a href="{{ route('etudiant.memoire.view') }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white text-blue-600 text-[10px] font-black rounded-xl border border-blue-100 hover:bg-blue-50 transition uppercase tracking-widest shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Consulter le fichier
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="py-8 text-center bg-[#F4F7FE]/50 rounded-2xl border border-dashed border-[#E0E5F2]">
                            <svg class="w-12 h-12 text-[#E0E5F2] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest">Aucun mémoire déposé</p>
                            <a href="{{ route('etudiant.memoire.index') }}" class="mt-4 inline-block px-6 py-2.5 bg-blue-600 text-white text-[10px] font-black rounded-xl hover:bg-blue-700 transition uppercase tracking-widest shadow-lg shadow-blue-500/20">Aller au dépôt</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Results & Global Planning -->
            <div class="lg:col-span-8 flex flex-col gap-8">
                <!-- Results Card -->
                <div class="glass-card p-8 border-l-4 border-indigo-500 overflow-hidden relative">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600 mb-6">Résultats Académiques</h3>
                        
                        @if($procesVerbal)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div class="text-center md:text-left">
                                    <p class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest mb-1">Moyenne</p>
                                    <p class="text-5xl font-black text-[#1B254B]">{{ number_format($procesVerbal->moyenne, 2) }}<span class="text-sm text-[#A3AED0]">/20</span></p>
                                </div>
                                <div class="text-center md:text-left">
                                    <p class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest mb-1">Mention</p>
                                    <p class="text-xl font-black text-indigo-600 uppercase">{{ $procesVerbal->mention }}</p>
                                </div>
                                <div class="text-center md:text-left">
                                    <p class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest mb-1">Décision</p>
                                    <span class="inline-block px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl font-black text-xs uppercase tracking-widest border border-emerald-100">
                                        {{ $procesVerbal->decision }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-4 p-6 bg-[#F4F7FE] rounded-2xl border border-dashed border-[#E0E5F2]">
                                <div class="p-3 bg-white rounded-xl text-blue-500 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-[#1B254B]">Vos résultats seront disponibles ici après la délibération du jury.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Global Weekly Planning -->
                <div class="glass-card p-6 md:p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-[#1B254B]">Planning Global de la Semaine</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse min-w-[600px]">
                            <thead>
                                <tr class="border-b border-[#F4F7FE]">
                                    <th class="p-4"></th>
                                    @for($i = 0; $i < 7; $i++)
                                        @php $date = $startOfWeek->copy()->addDays($i); @endphp
                                        <th class="p-4 text-center">
                                            <p class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest">{{ $date->translatedFormat('D') }}</p>
                                            <p class="text-sm font-black mt-1 {{ $date->isToday() ? 'text-blue-600' : 'text-[#1B254B]' }}">{{ $date->format('d') }}</p>
                                        </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(['08:00', '10:00', '13:00', '15:00'] as $time)
                                    <tr class="border-b border-[#F4F7FE]/50">
                                        <td class="p-4 text-[10px] font-black text-[#A3AED0] uppercase whitespace-nowrap">{{ $time }}</td>
                                        @for($i = 0; $i < 7; $i++)
                                            @php 
                                                $currentDate = $startOfWeek->copy()->addDays($i);
                                                $count = $weekSoutenances->filter(function($s) use ($currentDate, $time) {
                                                    return $s->date_heure_debut->format('Y-m-d') == $currentDate->format('Y-m-d') 
                                                        && $s->date_heure_debut->format('H:i') == $time;
                                                })->count();
                                            @endphp
                                            <td class="p-2 h-16 relative">
                                                @if($count > 0)
                                                    <div class="absolute inset-1 p-1 bg-blue-50/50 border border-blue-100 rounded-lg flex items-center justify-center">
                                                        <span class="text-[10px] font-black text-blue-600">{{ $count }} sout.</span>
                                                    </div>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
