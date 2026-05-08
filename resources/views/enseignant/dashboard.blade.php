<x-app-layout>
    @section('header', 'Tableau de Bord Jury')

    <!-- Top Greeting -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg md:text-xl font-black text-[#1B254B]">Bonjour, {{ auth()->user()->prenom }} 👋</h2>
            <p class="text-[#A3AED0] text-sm font-bold mt-1">Gérez vos convocations et les notations des soutenances.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Card 1: Agenda Semaine -->
        <div class="glass-card p-6 border-l-4 border-blue-500 shadow-xl shadow-blue-500/5 hover:scale-[1.02] transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] mb-2">Agenda Semaine</p>
                    <h3 class="text-3xl font-black text-[#1B254B]">{{ $weekSoutenances->count() }}</h3>
                    <p class="text-[10px] font-bold text-blue-500 mt-2">Convocations cette semaine</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-2xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card 2: À évaluer -->
        <div class="glass-card p-6 border-l-4 border-amber-500 shadow-xl shadow-amber-500/5 hover:scale-[1.02] transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] mb-2">À Évaluer</p>
                    <h3 class="text-3xl font-black text-[#1B254B]">{{ $pendingEvaluationsCount }}</h3>
                    <p class="text-[10px] font-bold text-amber-500 mt-2">Dossiers en attente</p>
                </div>
                <div class="p-3 bg-amber-50 rounded-2xl text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Évaluations Terminées -->
        <div class="glass-card p-6 border-l-4 border-emerald-500 shadow-xl shadow-emerald-500/5 hover:scale-[1.02] transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] mb-2">Terminées</p>
                    <h3 class="text-3xl font-black text-[#1B254B]">{{ $completedEvaluationsCount }}</h3>
                    <p class="text-[10px] font-bold text-emerald-500 mt-2">Notes enregistrées</p>
                </div>
                <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card 4: Statut -->
        <div class="glass-card p-6 border-l-4 border-indigo-500 shadow-xl shadow-indigo-500/5 hover:scale-[1.02] transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] mb-2">Disponibilité</p>
                    <h3 class="text-xl font-black text-[#1B254B]">DISPONIBLE</h3>
                    <p class="text-[10px] font-bold text-indigo-500 mt-2">Paramètres de jury</p>
                </div>
                <div class="p-3 bg-indigo-50 rounded-2xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8 items-start">
        
        <!-- Left Column: Upcoming Defenses (Agenda) -->
        <div class="lg:col-span-4 flex flex-col gap-8">
            <div class="glass-card overflow-hidden">
                <div class="p-6 border-b border-[#F4F7FE] flex items-center justify-between bg-white">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-[#1B254B]">Prochaines Convocations</h3>
                </div>
                <div class="p-4 flex flex-col">
                    @forelse($upcomingSoutenances as $s)
                        <div class="group flex items-center gap-4 p-4 hover:bg-[#F4F7FE] rounded-2xl transition-all cursor-pointer border border-transparent hover:border-[#E0E5F2]">
                            <div class="flex flex-col items-center justify-center h-14 w-14 rounded-2xl bg-white border border-[#E0E5F2] shadow-sm group-hover:shadow-md transition-all shrink-0">
                                <span class="text-[10px] font-black text-blue-600 uppercase">{{ $s->date_heure_debut->translatedFormat('M') }}</span>
                                <span class="text-xl font-black text-[#1B254B]">{{ $s->date_heure_debut->format('d') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-black text-[#1B254B] truncate">{{ $s->etudiant->user->nom }} {{ $s->etudiant->user->prenom }}</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-[10px] font-bold text-[#A3AED0] flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $s->date_heure_debut->format('H:i') }}
                                    </span>
                                    <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">{{ $s->salle->nom }}</span>
                                </div>
                            </div>
                            <a href="{{ route('enseignant.evaluations.evaluate', $s) }}" class="p-2.5 bg-blue-50 text-blue-600 rounded-xl opacity-0 group-hover:opacity-100 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <p class="text-sm font-bold text-[#A3AED0]">Aucune convocation à venir.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Weekly Planning Grid -->
        <div class="lg:col-span-8">
            <div class="glass-card p-6 md:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-[#1B254B]">Aperçu de mon Agenda — {{ now()->translatedFormat('F Y') }}</h3>
                    <div class="flex items-center gap-2 bg-[#F4F7FE] p-1 rounded-xl">
                        <button class="p-2 hover:bg-white rounded-lg transition-all text-[#1B254B]"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                        <span class="text-[10px] font-black uppercase tracking-widest px-2">Aujourd'hui</span>
                        <button class="p-2 hover:bg-white rounded-lg transition-all text-[#1B254B]"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                    </div>
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
                                            $soutenance = $weekSoutenances->first(function($s) use ($currentDate, $time) {
                                                return $s->date_heure_debut->format('Y-m-d') == $currentDate->format('Y-m-d') 
                                                    && $s->date_heure_debut->format('H:i') == $time;
                                            });
                                        @endphp
                                        <td class="p-2 h-20 relative">
                                            @if($soutenance)
                                                <div class="absolute inset-1 p-2 bg-blue-50 border border-blue-100 rounded-xl flex flex-col justify-between overflow-hidden group cursor-pointer hover:shadow-md transition-all">
                                                    <span class="text-[9px] font-black text-blue-600 truncate uppercase">{{ $soutenance->etudiant->user->nom }}</span>
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-[8px] font-bold text-blue-400">{{ $soutenance->salle->nom }}</span>
                                                        <a href="{{ route('enseignant.evaluations.evaluate', $soutenance) }}" class="text-[8px] font-black text-blue-600 hover:underline">Notes</a>
                                                    </div>
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
</x-app-layout>
