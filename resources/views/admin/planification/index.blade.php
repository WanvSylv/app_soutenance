<x-app-layout>
    @section('header', 'PLANNING DES SOUTENANCES')

    <form action="{{ route('planification.index') }}" method="GET" id="filterForm">
        <input type="hidden" name="view" value="{{ $view }}">
        <input type="hidden" name="date" value="{{ $start->format('Y-m-d') }}">

        <div class="mb-6 md:mb-8 flex flex-col gap-4 animate-fade-in">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-[#A3AED0] text-sm font-bold uppercase tracking-widest">Planifiez et gérez le calendrier des soutenances</p>
                </div>
                <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-[#E0E5F2] self-start sm:self-auto">
                    <div class="flex items-center gap-2 border-r border-[#F4F7FE] pr-3">
                    @php
                        if ($view === 'day') {
                            $prevDate = $start->copy()->subDay()->format('Y-m-d');
                            $nextDate = $start->copy()->addDay()->format('Y-m-d');
                        } elseif ($view === 'month') {
                            $prevDate = $start->copy()->subMonth()->format('Y-m-d');
                            $nextDate = $start->copy()->addMonth()->format('Y-m-d');
                        } else {
                            $prevDate = $start->copy()->subWeek()->format('Y-m-d');
                            $nextDate = $start->copy()->addWeek()->format('Y-m-d');
                        }
                    @endphp
                    <a href="{{ route('planification.index', ['date' => $prevDate, 'view' => $view, 'salle_id' => request('salle_id')]) }}" class="p-2 hover:bg-[#F4F7FE] rounded-xl transition">
                        <svg class="w-5 h-5 text-[#1B254B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <div class="relative px-2">
                        <span class="text-sm font-black text-[#1B254B]">
                            @if($view === 'day')
                                {{ $start->translatedFormat('d M Y') }}
                            @else
                                {{ $start->format('d') }} - {{ $end->translatedFormat('d M Y') }}
                            @endif
                        </span>
                    </div>
                    <a href="{{ route('planification.index', ['date' => $nextDate, 'view' => $view, 'salle_id' => request('salle_id')]) }}" class="p-2 hover:bg-[#F4F7FE] rounded-xl transition">
                        <svg class="w-5 h-5 text-[#1B254B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                    <a href="{{ route('planification.index', ['view' => $view]) }}" class="px-4 py-1.5 bg-[#F4F7FE] text-[#1B254B] text-xs font-black rounded-xl hover:bg-blue-50 transition whitespace-nowrap">Aujourd'hui</a>
                </div>
            </div>
        </div>

        <!-- Controls Bar: filters left, CTA right -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <!-- Left: View toggles + Salle filter -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- View toggles -->
                <div class="flex bg-white p-1.5 rounded-2xl shadow-sm border border-[#E0E5F2]">
                    <a href="{{ route('planification.index', ['view' => 'day', 'date' => $start->format('Y-m-d'), 'salle_id' => request('salle_id')]) }}"
                       class="px-5 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition {{ $view === 'day' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-[#A3AED0] hover:text-[#1B254B]' }}">Jour</a>
                    <a href="{{ route('planification.index', ['view' => 'week', 'date' => $start->format('Y-m-d'), 'salle_id' => request('salle_id')]) }}"
                       class="px-5 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition {{ $view === 'week' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-[#A3AED0] hover:text-[#1B254B]' }}">Semaine</a>
                    <a href="{{ route('planification.index', ['view' => 'month', 'date' => $start->format('Y-m-d'), 'salle_id' => request('salle_id')]) }}"
                       class="px-5 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition {{ $view === 'month' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-[#A3AED0] hover:text-[#1B254B]' }}">Mois</a>
                </div>
                <!-- Salle filter -->
                <div class="relative">
                    <select name="salle_id" onchange="this.form.submit()"
                            class="bg-white border border-[#E0E5F2] rounded-2xl pl-4 pr-10 py-2.5 text-xs font-black text-[#1B254B] focus:ring-blue-500 shadow-sm appearance-none cursor-pointer">
                        <option value="all">Toutes les salles</option>
                        @foreach(\App\Models\Salle::all() as $s)
                            <option value="{{ $s->id }}" {{ request('salle_id') == $s->id ? 'selected' : '' }}>{{ $s->nom }}</option>
                        @endforeach
                    </select>
                    <svg class="w-4 h-4 text-[#A3AED0] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <!-- Right: CTA Buttons -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.export.planning.hebdo', ['date' => $start->format('Y-m-d')]) }}" target="_blank"
                   class="inline-flex items-center justify-center gap-2 bg-rose-50 text-rose-600 px-6 py-3 rounded-2xl text-sm font-black border border-rose-100 shadow-lg shadow-rose-500/5 hover:bg-rose-100 transition-all whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Exporter PDF
                </a>

                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.planification.create') }}"
                   class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-2xl text-sm font-black shadow-lg shadow-blue-500/20 hover:scale-[1.02] hover:bg-blue-700 transition-all whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nouvelle soutenance
                </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Main Grid Layout -->
    <div class="flex flex-col lg:flex-row gap-6 md:gap-8">
        
        <!-- Planning Grid -->
        <div class="flex-grow glass-card overflow-hidden min-w-0">
            <div class="overflow-x-auto -webkit-overflow-scrolling-touch scroll-smooth" style="-webkit-overflow-scrolling: touch;">
                <table class="w-full border-collapse" style="min-width: 700px;">
                    <thead>
                        <tr class="bg-white border-b border-[#F4F7FE]">
                            <th class="p-6 text-[10px] font-black text-[#1B254B] uppercase tracking-[0.2em] text-left border-r border-[#F4F7FE] min-w-[140px]">Salles</th>
                            @php
                                $diffDays = $start->diffInDays($end) + 1;
                            @endphp
                            @for($i = 0; $i < $diffDays; $i++)
                                @php $date = $start->copy()->addDays($i); @endphp
                                <th class="p-6 text-[10px] font-black {{ $date->isToday() ? 'text-blue-600 bg-blue-50/30' : 'text-[#1B254B]' }} uppercase tracking-[0.2em] text-center border-r border-[#F4F7FE] min-w-[160px]">
                                    {{ $date->translatedFormat($view === 'day' ? 'l d F Y' : 'D. d M') }}
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salles as $salle)
                        <tr class="border-b border-[#F4F7FE]">
                            <td class="p-6 border-r border-[#F4F7FE] bg-white sticky left-0 z-20 shadow-[5px_0_10px_rgba(0,0,0,0.02)]">
                                <h4 class="text-xs font-black text-[#1B254B]">{{ $salle->nom }}</h4>
                                <p class="text-[9px] font-bold text-[#A3AED0] mt-1 uppercase tracking-widest">Capacité : {{ $salle->capacite ?? 40 }}</p>
                                
                                <div class="mt-4 flex flex-col gap-6 opacity-30">
                                    <span class="text-[8px] font-black">08:00</span>
                                    <span class="text-[8px] font-black">10:00</span>
                                    <span class="text-[8px] font-black">13:00</span>
                                    <span class="text-[8px] font-black">15:00</span>
                                </div>
                            </td>
                            
                            @for($i = 0; $i < $diffDays; $i++)
                                @php 
                                    $currentDate = $start->copy()->addDays($i);
                                    $soutenancesDuJour = $soutenances->filter(function($s) use ($salle, $currentDate) {
                                        return $s->salle_id == $salle->id && $s->date_heure_debut->isSameDay($currentDate);
                                    });
                                @endphp
                                <td class="p-2 border-r border-[#F4F7FE] bg-[#FCFDFF]/50 relative min-h-[300px] {{ $currentDate->isWeekend() ? 'opacity-40' : '' }}">
                                    @foreach($soutenancesDuJour as $soutenance)
                                        @php
                                            $hour = $soutenance->date_heure_debut->hour;
                                            $minute = $soutenance->date_heure_debut->minute;
                                            // Calcul approximatif du top pour l'affichage visuel
                                            // 08:00 -> top-4, 10:00 -> top-32, 13:00 -> top-60 etc.
                                            $topClass = "top-4";
                                            if($hour >= 10 && $hour < 13) $topClass = "top-32";
                                            if($hour >= 13 && $hour < 15) $topClass = "top-56";
                                            if($hour >= 15) $topClass = "top-80";

                                            $statusColors = [
                                                'planifiee' => 'bg-green-50 border-green-100 text-green-600',
                                                'terminee' => 'bg-purple-50 border-purple-100 text-purple-600',
                                                'annulee' => 'bg-rose-50 border-rose-100 text-rose-600',
                                            ];
                                            $colorClass = $statusColors[$soutenance->statut] ?? 'bg-blue-50 border-blue-100 text-blue-600';
                                        @endphp
                                        <div class="absolute {{ $topClass }} left-2 right-2 p-3 {{ $colorClass }} border rounded-xl shadow-sm z-10 cursor-pointer hover:scale-[1.03] transition-all group">
                                            <p class="text-[8px] font-black opacity-70">{{ $soutenance->date_heure_debut->format('H:i') }} - {{ $soutenance->date_heure_debut->addMinutes(90)->format('H:i') }}</p>
                                            <p class="text-[10px] font-black text-[#1B254B] mt-1 uppercase">{{ $soutenance->etudiant->user->nom }}</p>
                                            <p class="text-[8px] font-bold text-[#A3AED0] mt-0.5 truncate">{{ $soutenance->sujet }}</p>
                                            
                                            <div class="hidden group-hover:block absolute top-full left-0 right-0 mt-2 p-4 bg-white shadow-2xl rounded-2xl border border-[#F4F7FE] z-50 min-w-[200px]">
                                                <p class="text-[9px] font-black text-blue-600 uppercase mb-3">Composition du Jury</p>
                                                @foreach($soutenance->juryMembres as $membre)
                                                    <div class="flex items-center justify-between mb-2 last:mb-0">
                                                        <div class="flex flex-col">
                                                            <p class="text-[10px] font-bold text-[#1B254B]">{{ $membre->enseignant->user->nom }} {{ $membre->enseignant->user->prenom }}</p>
                                                            <p class="text-[8px] text-[#A3AED0] uppercase">{{ $membre->fonction }}</p>
                                                        </div>
                                                        @php
                                                            $statusBadge = [
                                                                'en_attente' => 'bg-gray-100 text-gray-500',
                                                                'confirme' => 'bg-emerald-100 text-emerald-600',
                                                                'indisponible' => 'bg-rose-100 text-rose-600',
                                                            ];
                                                        @endphp
                                                        <span class="text-[7px] font-black px-1.5 py-0.5 rounded {{ $statusBadge[$membre->statut_confirmation] ?? 'bg-gray-100' }} uppercase">
                                                            {{ str_replace('_', ' ', $membre->statut_confirmation) }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <div class="h-full w-full grid grid-rows-4 pointer-events-none opacity-10">
                                        <div class="border-b border-[#F4F7FE]"></div>
                                        <div class="border-b border-[#F4F7FE]"></div>
                                        <div class="border-b border-[#F4F7FE]"></div>
                                        <div></div>
                                    </div>
                                </td>
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(auth()->user()->isAdmin())
            <div class="p-6 bg-blue-50/30 flex items-center gap-3 border-t border-[#F4F7FE]">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Glissez-déposez une soutenance pour la déplacer. Cliquez sur un créneau pour voir les détails.</p>
            </div>
            @endif
        </div>

        <!-- Sidebar Jury / Next Soutenance -->
        <div class="w-full lg:w-[320px] shrink-0 flex flex-col gap-8">
            <div class="glass-card p-6">
                @if(auth()->user()->role === 'enseignant')
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1B254B] mb-8">Ma Prochaine Soutenance</h3>
                    
                    @if($nextSoutenance)
                    <div class="flex flex-col">
                        <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl mb-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-blue-600 text-white rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-blue-700 uppercase tracking-widest">{{ $nextSoutenance->date_heure_debut->translatedFormat('d F Y') }}</p>
                                    <p class="text-[9px] font-bold text-blue-500 uppercase">{{ $nextSoutenance->date_heure_debut->format('H:i') }} — {{ $nextSoutenance->salle->nom }} [{{ $nextSoutenance->salle->code }}]</p>
                                </div>
                            </div>
                            <h4 class="text-xs font-black text-[#1B254B] uppercase mb-1">{{ $nextSoutenance->etudiant->user->nom }} {{ $nextSoutenance->etudiant->user->prenom }}</h4>
                            <p class="text-[10px] font-bold text-[#A3AED0] italic line-clamp-2 leading-relaxed">"{{ $nextSoutenance->sujet }}"</p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <p class="text-[9px] font-black text-[#1B254B] uppercase tracking-widest mb-3">Membres du Jury :</p>
                                <div class="space-y-2">
                                    @foreach($nextSoutenance->juryMembres as $membre)
                                        <div class="flex items-center justify-between p-2 rounded-xl {{ $membre->enseignant_id == $availableJury->id ? 'bg-blue-600 text-white' : 'bg-[#F4F7FE] text-[#1B254B]' }}">
                                            <span class="text-[10px] font-bold">{{ $membre->enseignant->user->nom }} {{ $membre->enseignant->user->prenom }}</span>
                                            <span class="text-[8px] font-black uppercase opacity-70">{{ $membre->fonction }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="py-12 text-center">
                            <div class="w-16 h-16 bg-[#F4F7FE] rounded-full flex items-center justify-center mx-auto mb-4 text-[#A3AED0]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-[#A3AED0] text-xs font-bold uppercase tracking-widest">Aucune soutenance prévue</p>
                        </div>
                    @endif

                    <a href="{{ route('enseignant.evaluations.index') }}" class="w-full mt-8 block text-center py-3.5 bg-blue-600 text-white text-[10px] font-black rounded-xl hover:bg-blue-700 transition uppercase tracking-widest shadow-lg shadow-blue-500/20">
                        Voir mon agenda complet
                    </a>

                @else
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1B254B] mb-8">Jury Disponible</h3>
                    
                    @if($availableJury)
                    <div class="flex flex-col items-center">
                        <div class="h-28 w-28 rounded-2xl overflow-hidden mb-6 ring-4 ring-blue-50 shadow-lg">
                            @if($availableJury->user->photo_path)
                                <img src="{{ asset('storage/'.$availableJury->user->photo_path) }}" alt="Jury" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full bg-[#2D60FF] flex items-center justify-center text-white font-black text-3xl uppercase">
                                    {{ substr($availableJury->user->nom, 0, 1) }}{{ substr($availableJury->user->prenom, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <h4 class="text-sm font-black text-[#1B254B] text-center">{{ $availableJury->user->nom }} {{ $availableJury->user->prenom }}</h4>
                        <p class="text-[10px] font-bold text-[#A3AED0] mt-1 uppercase tracking-widest">{{ $availableJury->grade ?? 'Professeur Titulaire' }}</p>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div>
                            <p class="text-[9px] font-black text-[#1B254B] uppercase tracking-widest mb-1">Spécialité :</p>
                            <p class="text-[10px] font-bold text-[#A3AED0]">{{ $availableJury->specialite ?? 'Informatique' }}</p>
                        </div>
                    </div>
                    @endif

                    <a href="{{ route('admin.enseignants.index') }}" class="w-full mt-8 block text-center py-3 bg-white border border-[#E0E5F2] text-[#1B254B] text-[10px] font-black rounded-xl hover:bg-[#F4F7FE] transition uppercase tracking-widest shadow-sm">
                        Voir tous les jurys
                    </a>
                @endif
            </div>
        </div>

    </div>

    <!-- Improved Legend -->
    <div class="mt-12 flex flex-wrap items-center gap-10 animate-fade-in">
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-blue-600 shadow-sm"></span>
            <span class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest">Confirmée</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-green-500 shadow-sm"></span>
            <span class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest">Planifiée</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-amber-400 shadow-sm"></span>
            <span class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest">En cours</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-purple-600 shadow-sm"></span>
            <span class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest">Terminée</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-rose-500 shadow-sm"></span>
            <span class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest">Conflit</span>
        </div>
    </div>

</x-app-layout>
