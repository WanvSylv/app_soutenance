<x-app-layout>
    @section('header', '')

    <!-- Top Greeting -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg md:text-xl font-black text-[#1B254B]">Bonjour, {{ auth()->user()->prenom }} 👋</h2>
            <p class="text-[#A3AED0] text-sm font-bold mt-1">Aperçu de la gestion des soutenances.</p>
        </div>
        @if(auth()->user()->isAdmin())
        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center">
            <select name="annee_id" id="annee_id" onchange="this.form.submit()" class="rounded-xl border-[#E0E5F2] bg-white text-[#1B254B] focus:ring-blue-500 font-bold text-xs p-2 w-full sm:w-auto">
                @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ $anneeFiltre && $anneeFiltre->id == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }} {{ $annee->active ? '(Active)' : '' }}
                    </option>
                @endforeach
            </select>
        </form>
        @endif
    </div>

    <!-- 5 Stat Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Card 1: Total Soutenances -->
        <div class="glass-card p-6 border-l-4 border-blue-500 shadow-xl shadow-blue-500/5 hover:scale-[1.02] transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] mb-2">Soutenances</p>
                    <h3 class="text-3xl font-black text-[#1B254B]">{{ $stats['soutenances_count'] }}</h3>
                    <p class="text-[9px] font-bold text-blue-500 mt-2 uppercase">{{ $anneeFiltre ? $anneeFiltre->libelle : 'Total' }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-2xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card 2: À Venir -->
        <div class="glass-card p-6 border-l-4 border-green-500 shadow-xl shadow-green-500/5 hover:scale-[1.02] transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] mb-2">À Venir</p>
                    <h3 class="text-3xl font-black text-[#1B254B]">{{ $upcomingSoutenances->count() }}</h3>
                    <div class="flex items-center gap-1 mt-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                        <p class="text-[9px] font-bold text-green-600 uppercase">En attente</p>
                    </div>
                </div>
                <div class="p-3 bg-green-50 rounded-2xl text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Conflits -->
        <div class="glass-card p-6 border-l-4 border-amber-500 shadow-xl shadow-amber-500/5 hover:scale-[1.02] transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] mb-2">Alertes</p>
                    <h3 class="text-3xl font-black text-[#1B254B]">{{ $conflitsCount }}</h3>
                    <p class="text-[9px] font-bold text-amber-600 mt-2 uppercase">Conflits détectés</p>
                </div>
                <div class="p-3 bg-amber-50 rounded-2xl text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card 4: PV en attente -->
        <div class="glass-card p-6 border-l-4 border-purple-500 shadow-xl shadow-purple-500/5 hover:scale-[1.02] transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] mb-2">Délibérations</p>
                    <h3 class="text-3xl font-black text-[#1B254B]">{{ $pvAttenteCount }}</h3>
                    <p class="text-[9px] font-bold text-purple-600 mt-2 uppercase">PV à générer</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-2xl text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card 5: Taux de réussite -->
        <div class="glass-card p-6 border-l-4 border-teal-500 shadow-xl shadow-teal-500/5 hover:scale-[1.02] transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] mb-2">Performance</p>
                    <h3 class="text-3xl font-black text-[#1B254B]">{{ $tauxReussite }}%</h3>
                    <p class="text-[9px] font-bold text-teal-600 mt-2 uppercase">Taux de réussite</p>
                </div>
                <div class="p-3 bg-teal-50 rounded-2xl text-teal-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8 items-start">
        
        <!-- Left Column: Upcoming Defenses & Jury -->
        <div class="lg:col-span-4 flex flex-col gap-8">
            <div class="glass-card overflow-hidden">
                <div class="p-6 border-b border-[#F4F7FE] flex items-center justify-between bg-white">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-[#1B254B]">Prochaines Soutenances</h3>
                    <a href="{{ route('planification.index') }}" class="text-[10px] font-black text-blue-600 hover:underline uppercase">Voir tout</a>
                </div>
                <div class="p-4 flex flex-col">
                    @forelse($upcomingSoutenances->take(6) as $soutenance)
                        <div class="p-4 hover:bg-[#F4F7FE] rounded-2xl transition group cursor-pointer border-b last:border-0 border-[#F4F7FE]">
                            <div class="flex items-start gap-4">
                                <div class="bg-blue-50 px-3 py-1.5 rounded-xl flex flex-col items-center justify-center shrink-0 border border-blue-100 group-hover:bg-white transition shadow-sm">
                                    <span class="text-[9px] font-black text-blue-600 uppercase">{{ $soutenance->date_heure_debut->translatedFormat('d M') }}</span>
                                    <span class="text-[10px] font-black text-blue-700">{{ $soutenance->date_heure_debut->format('H:i') }}</span>
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-xs font-black text-[#1B254B] uppercase truncate">{{ $soutenance->etudiant->user->nom }} {{ $soutenance->etudiant->user->prenom }}</h4>
                                    <p class="text-[9px] font-bold text-[#A3AED0] mt-1 truncate">{{ $soutenance->sujet }}</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-[9px] font-black text-blue-400 uppercase tracking-tighter">{{ $soutenance->salle->nom }}</span>
                                        <span class="w-1 h-1 rounded-full bg-[#E0E5F2]"></span>
                                        <span class="text-[9px] font-bold text-[#A3AED0] uppercase">M2</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center">
                            <svg class="w-12 h-12 text-[#E0E5F2] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-[#A3AED0] text-sm font-bold">Aucune soutenance prévue</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Jury Profile Card -->
            @if($availableJury)
            <div class="glass-card p-6">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1B254B] mb-6">Jury Disponible aujourd'hui</h3>
                <div class="flex items-center gap-5">
                    <div class="h-16 w-16 rounded-2xl bg-[#F4F7FE] overflow-hidden shrink-0 border border-[#E0E5F2]">
                        @if($availableJury->user->photo_path)
                            <img src="{{ asset('storage/' . $availableJury->user->photo_path) }}" alt="Jury" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-[#2D60FF] flex items-center justify-center text-white font-black text-xl uppercase">
                                {{ substr($availableJury->user->nom, 0, 1) }}{{ substr($availableJury->user->prenom, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-black text-[#1B254B]">{{ $availableJury->user->nom }} {{ $availableJury->user->prenom }}</h4>
                            <div class="px-2 py-0.5 bg-green-50 text-green-600 text-[8px] font-black rounded uppercase">Disponible</div>
                        </div>
                        <p class="text-[9px] font-bold text-[#A3AED0] mt-0.5">{{ $availableJury->grade ?? 'Professeur' }}</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-[#F4F7FE] space-y-2">
                    <p class="text-[9px] font-black text-[#1B254B] uppercase tracking-widest">Spécialité :</p>
                    <p class="text-[10px] font-bold text-[#A3AED0]">{{ $availableJury->specialite ?? 'Informatique' }}</p>
                </div>
                <button class="w-full mt-6 py-2.5 bg-blue-600 text-white text-[10px] font-black rounded-xl hover:bg-blue-700 transition uppercase tracking-widest shadow-lg shadow-blue-500/10">
                    Voir le profil
                </button>
            </div>
            @endif

            <!-- Mentions Card -->
            <div class="glass-card p-6">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1B254B] mb-6">Répartition des Mentions</h3>
                <div class="space-y-4">
                    @foreach($mentionsCount as $mention => $count)
                        @php 
                            $percent = $totalTerminees > 0 ? round(($count / $totalTerminees) * 100) : 0;
                            $colors = [
                                'Très Bien' => 'bg-indigo-500',
                                'Bien' => 'bg-blue-500',
                                'Assez Bien' => 'bg-emerald-500',
                                'Passable' => 'bg-amber-500',
                                'Ajourné' => 'bg-rose-500'
                            ];
                            $color = $colors[$mention] ?? 'bg-slate-400';
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[9px] font-black text-[#1B254B] uppercase">{{ $mention }}</span>
                                <span class="text-[9px] font-bold text-[#A3AED0]">{{ $count }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-[#F4F7FE] rounded-full overflow-hidden">
                                <div class="{{ $color }} h-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Planning Mini Grid & Alerts -->
        <div class="lg:col-span-8 flex flex-col gap-8">
            
            @if(isset($indisponibilitesJury) && $indisponibilitesJury->count() > 0)
            <!-- Indisponibilités Alerts -->
            <div class="glass-card border-l-4 border-rose-500 overflow-hidden animate-fade-in mb-8">
                <div class="p-6 bg-rose-50/50 border-b border-rose-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-rose-500 text-white rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-black uppercase tracking-[0.2em] text-rose-700">Alertes d'indisponibilité</h3>
                            <p class="text-[10px] font-bold text-rose-500 uppercase mt-0.5">{{ $indisponibilitesJury->count() }} jury(s) ont décliné leur participation</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 flex flex-col divide-y divide-rose-100">
                    @foreach($indisponibilitesJury as $indispo)
                    <div class="p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 font-black text-xs uppercase">
                                {{ substr($indispo->enseignant->user->nom, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-[#1B254B] uppercase">{{ $indispo->enseignant->user->nom }} {{ $indispo->enseignant->user->prenom }}</h4>
                                <p class="text-[9px] font-bold text-rose-500 mt-1 uppercase tracking-tighter">Soutenance de : {{ $indispo->soutenance->etudiant->user->nom }} ({{ $indispo->soutenance->date_heure_debut->format('d/m/Y H:i') }})</p>
                                <p class="text-[10px] text-[#A3AED0] mt-2 italic">"{{ $indispo->motif_indisponibilite }}"</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.planification.edit', $indispo->soutenance_id) }}" class="px-4 py-2 bg-rose-500 text-white text-[10px] font-black rounded-xl shadow-lg shadow-rose-500/20 hover:bg-rose-600 transition uppercase tracking-widest whitespace-nowrap">
                            Remplacer le jury
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(isset($soutenancesExpirees) && $soutenancesExpireesCount > 0)
            <!-- Expired but Unevaluated Alerts -->
            <div class="glass-card border-l-4 border-amber-500 overflow-hidden animate-fade-in">
                <div class="p-6 bg-amber-50/50 border-b border-amber-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-amber-500 text-white rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-black uppercase tracking-[0.2em] text-amber-700">Soutenances passées non évaluées</h3>
                            <p class="text-[10px] font-bold text-amber-500 uppercase mt-0.5">{{ $soutenancesExpireesCount }} séance(s) terminées sans notes</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 flex flex-col divide-y divide-amber-100">
                    @foreach($soutenancesExpirees as $expiree)
                    <div class="p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 font-black text-xs uppercase">
                                {{ substr($expiree->etudiant->user->nom, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-[#1B254B] uppercase">{{ $expiree->etudiant->user->nom }} {{ $expiree->etudiant->user->prenom }}</h4>
                                <p class="text-[9px] font-bold text-amber-600 mt-1 uppercase tracking-tighter">Était prévue le : {{ $expiree->date_heure_debut->format('d/m/Y') }} à {{ $expiree->date_heure_debut->format('H:i') }}</p>
                                <p class="text-[10px] text-[#A3AED0] mt-2 italic">Salle : {{ $expiree->salle->nom }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.planification.edit', $expiree->id) }}" class="px-4 py-2 bg-white border border-amber-200 text-amber-600 text-[10px] font-black rounded-xl hover:bg-amber-50 transition uppercase tracking-widest whitespace-nowrap">
                                Modifier la date
                            </a>
                            <form action="{{ route('admin.planification.annuler', $expiree->id) }}" method="POST" onsubmit="return confirm('Voulez-vous marquer cette soutenance comme annulée ou non-soutenue ?')">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-amber-500 text-white text-[10px] font-black rounded-xl shadow-lg shadow-amber-500/20 hover:bg-amber-600 transition uppercase tracking-widest whitespace-nowrap">
                                    Marquer Non-Soutenue
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="glass-card p-8">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-[#1B254B]">Planning des Soutenances – {{ now()->translatedFormat('F Y') }}</h3>
                        <a href="{{ route('admin.export.planning.hebdo') }}" target="_blank" class="flex items-center gap-2 px-3 py-1.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition border border-rose-100 text-[10px] font-black uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Exporter PDF
                        </a>
                    </div>
                    <div class="flex items-center gap-2 bg-[#F4F7FE] p-1 rounded-xl">
                        <button class="p-1 hover:bg-white rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                        <button class="px-4 py-1.5 bg-white text-xs font-black text-[#1B254B] rounded-lg shadow-sm">Aujourd'hui</button>
                        <button class="p-1 hover:bg-white rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b border-[#F4F7FE]">
                                <th class="p-4"></th>
                                @for($i = 0; $i < 7; $i++)
                                    @php $date = $startOfWeek->copy()->addDays($i); @endphp
                                    <th class="p-4 text-[9px] font-black {{ $date->isToday() ? 'text-blue-600' : 'text-[#1B254B]' }} uppercase tracking-widest text-center">
                                        {{ $date->translatedFormat('D. d') }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salles->take(6) as $salle)
                            <tr class="border-b border-[#F4F7FE] last:border-0">
                                <td class="p-4">
                                    <span class="text-[9px] font-black text-[#1B254B] uppercase">{{ $salle->nom }}</span>
                                    <div class="flex flex-col gap-4 mt-4 opacity-20">
                                        <span class="text-[7px] font-black">08:00</span>
                                        <span class="text-[7px] font-black">13:00</span>
                                    </div>
                                </td>
                                @for($i = 0; $i < 7; $i++)
                                    @php 
                                        $currentDate = $startOfWeek->copy()->addDays($i);
                                        $soutenancesDuJour = $weekSoutenances->filter(function($s) use ($salle, $currentDate) {
                                            return $s->salle_id == $salle->id && $s->date_heure_debut->isSameDay($currentDate);
                                        });
                                    @endphp
                                    <td class="p-1 border-r border-[#F4F7FE] min-h-[120px] relative">
                                        @foreach($soutenancesDuJour as $soutenance)
                                            @php
                                                $statusColors = [
                                                    'planifiee' => 'bg-green-50 border-green-100 text-green-600',
                                                    'terminee' => 'bg-purple-50 border-purple-100 text-purple-600',
                                                ];
                                                $colorClass = $statusColors[$soutenance->statut] ?? 'bg-blue-50 border-blue-100 text-blue-600';
                                            @endphp
                                            <div class="{{ $colorClass }} border p-2 rounded-lg shadow-sm mb-1">
                                                <p class="text-[6px] font-black opacity-70">{{ $soutenance->date_heure_debut->format('H:i') }}</p>
                                                <p class="text-[8px] font-black text-[#1B254B] mt-0.5 uppercase truncate">{{ $soutenance->etudiant->user->nom }}</p>
                                            </div>
                                        @endforeach
                                    </td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-10 flex flex-wrap items-center gap-6 border-t border-[#F4F7FE] pt-6">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span class="text-[8px] font-black text-[#A3AED0] uppercase tracking-widest">Confirmée</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        <span class="text-[8px] font-black text-[#A3AED0] uppercase tracking-widest">Planifiée</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                        <span class="text-[8px] font-black text-[#A3AED0] uppercase tracking-widest">En cours</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span>
                        <span class="text-[8px] font-black text-[#A3AED0] uppercase tracking-widest">Terminée</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                        <span class="text-[8px] font-black text-[#A3AED0] uppercase tracking-widest">Conflit</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
