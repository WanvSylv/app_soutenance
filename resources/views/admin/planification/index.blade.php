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
                <div class="flex items-center gap-3 bg-white p-1.5 border border-[#E0E5F2] self-start sm:self-auto" style="border-radius:8px;">
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
                    <a href="{{ route('planification.index', ['view' => $view]) }}" style="padding:0.4rem 1rem;background:#F4F7FE;color:#1B254B;font-size:0.72rem;font-weight:700;border-radius:6px;text-decoration:none;white-space:nowrap;text-transform:uppercase;letter-spacing:0.04em;">Aujourd'hui</a>
                </div>
            </div>
        </div>

        <!-- Controls Bar: filters left, CTA right -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <!-- Left: View toggles + Salle filter -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- View toggles -->
                <div style="display:flex;background:#F4F7FE;padding:3px;border-radius:8px;gap:2px;">
                    @foreach(['day'=>'Jour','week'=>'Semaine','month'=>'Mois'] as $v => $label)
                    <a href="{{ route('planification.index', ['view' => $v, 'date' => $start->format('Y-m-d'), 'salle_id' => request('salle_id')]) }}"
                       style="padding:0.4rem 1rem;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-radius:6px;text-decoration:none;transition:all 0.15s;{{ $view === $v ? 'background:#fff;color:#1B254B;' : 'color:#A3AED0;' }}">{{ $label }}</a>
                    @endforeach
                </div>
                <!-- Salle filter -->
                <select name="salle_id" onchange="this.form.submit()" class="table-filter-input" style="width:auto;min-width:160px;">
                    <option value="all">Toutes les salles</option>
                    @foreach(\App\Models\Salle::all() as $s)
                        <option value="{{ $s->id }}" {{ request('salle_id') == $s->id ? 'selected' : '' }}>{{ $s->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Right: CTA Buttons -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.export.planning.hebdo', ['date' => $start->format('Y-m-d')]) }}" target="_blank" class="btn-outline" style="font-size:0.75rem;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    PDF
                </a>

                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.planification.create') }}" class="btn-premium" style="font-size:0.75rem;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Nouvelle soutenance
                </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Main Grid Layout -->
    <div>
        
        <!-- Planning Grid -->
        <div class="flex-grow data-card overflow-hidden min-w-0">

            @if($view === 'month')
            {{-- ── VUE MOIS : calendrier 7 colonnes ───────────────── --}}
            @php
                $monthRef   = $start->copy()->addDays(7); // date dans le bon mois
                $totalDays  = $start->diffInDays($end) + 1;
                $jours      = ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'];
                $statusDot  = ['planifiee'=>'#2D60FF','terminee'=>'#7C3AED','deliberee'=>'#10B981','annulee'=>'#EF4444'];
            @endphp
            <div style="padding:0;">
                {{-- En-tête jours --}}
                <div style="display:grid;grid-template-columns:repeat(7,1fr);border-bottom:1px solid #F4F7FE;">
                    @foreach($jours as $j)
                    <div style="padding:0.6rem;text-align:center;font-size:0.65rem;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;color:#A3AED0;">{{ $j }}</div>
                    @endforeach
                </div>
                {{-- Semaines --}}
                @for($w = 0; $w < $totalDays / 7; $w++)
                <div style="display:grid;grid-template-columns:repeat(7,1fr);border-bottom:1px solid #F4F7FE;">
                    @for($d = 0; $d < 7; $d++)
                    @php
                        $day = $start->copy()->addDays($w * 7 + $d);
                        $isCurrentMonth = $day->month === $monthRef->month;
                        $isToday = $day->isToday();
                        $daySouts = $soutenances->filter(fn($s) => $s->date_heure_debut->isSameDay($day));
                    @endphp
                    <div style="min-height:90px;padding:0.5rem;border-right:1px solid #F4F7FE;{{ $day->isWeekend() ? 'background:#FAFBFF;' : '' }}">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.35rem;">
                            <span style="width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:{{ $isToday ? '900' : '600' }};{{ $isToday ? 'background:#2D60FF;color:#fff;' : ($isCurrentMonth ? 'color:#1B254B;' : 'color:#D1D5DB;') }}">{{ $day->day }}</span>
                            @if($daySouts->count() > 0)
                            <span style="font-size:0.6rem;font-weight:700;color:#A3AED0;">{{ $daySouts->count() }}</span>
                            @endif
                        </div>
                        @foreach($daySouts->take(3) as $s)
                        @php $dot = $statusDot[$s->statut] ?? '#2D60FF'; @endphp
                        <a href="{{ route('admin.planification.edit', $s->id) }}" style="display:block;background:{{ $dot }}12;border-left:2px solid {{ $dot }};border-radius:3px;padding:0.2rem 0.4rem;margin-bottom:2px;text-decoration:none;overflow:hidden;" title="{{ $s->etudiant?->user?->nom }} — {{ $s->sujet }}">
                            <span style="font-size:0.6rem;font-weight:700;color:{{ $dot }};white-space:nowrap;">{{ $s->date_heure_debut->format('H:i') }}</span>
                            <span style="font-size:0.6rem;font-weight:600;color:#1B254B;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $s->etudiant?->user?->nom }}</span>
                        </a>
                        @endforeach
                        @if($daySouts->count() > 3)
                        <span style="font-size:0.6rem;color:#A3AED0;font-weight:600;">+{{ $daySouts->count() - 3 }} autres</span>
                        @endif
                    </div>
                    @endfor
                </div>
                @endfor
            </div>

            @else
            {{-- ── VUE SEMAINE / JOUR : grille salles × jours ─────── --}}
            @php $diffDays = $start->diffInDays($end) + 1; @endphp
            <div class="overflow-x-auto" style="-webkit-overflow-scrolling:touch;">
                <table style="width:100%;border-collapse:collapse;min-width:600px;">
                    <thead>
                        <tr style="border-bottom:1px solid #F4F7FE;background:#fff;">
                            <th style="padding:0.75rem 1.25rem;text-align:left;font-size:0.65rem;font-weight:800;color:#A3AED0;text-transform:uppercase;letter-spacing:0.1em;min-width:130px;position:sticky;left:0;background:#fff;z-index:10;">Salle</th>
                            @for($i = 0; $i < $diffDays; $i++)
                            @php $date = $start->copy()->addDays($i); @endphp
                            <th style="padding:0.75rem 1rem;text-align:center;font-size:0.65rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;min-width:140px;{{ $date->isToday() ? 'color:#2D60FF;background:#EFF6FF;' : 'color:#A3AED0;' }}">
                                {{ $date->translatedFormat($view === 'day' ? 'l d F Y' : 'D. d M') }}
                            </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salles as $salle)
                        <tr style="border-bottom:1px solid #F4F7FE;">
                            <td style="padding:0.75rem 1.25rem;position:sticky;left:0;background:#fff;z-index:5;border-right:1px solid #F4F7FE;">
                                <div style="font-size:0.75rem;font-weight:700;color:#1B254B;">{{ $salle->nom }}</div>
                                <div style="font-size:0.65rem;font-weight:500;color:#A3AED0;margin-top:1px;">{{ $salle->capacite ?? '—' }} places</div>
                            </td>
                            @for($i = 0; $i < $diffDays; $i++)
                            @php
                                $cur = $start->copy()->addDays($i);
                                $daySouts = $soutenances->filter(fn($s) => $s->salle_id == $salle->id && $s->date_heure_debut->isSameDay($cur));
                                $statusC = ['planifiee'=>['#EFF6FF','#2D60FF'],'terminee'=>['#F5F3FF','#7C3AED'],'deliberee'=>['#F0FDF4','#10B981'],'annulee'=>['#FFF5F5','#EF4444']];
                            @endphp
                            <td style="padding:0.4rem;vertical-align:top;border-right:1px solid #F4F7FE;{{ $cur->isWeekend() ? 'background:#FAFBFF;' : '' }}min-height:70px;">
                                @foreach($daySouts as $s)
                                @php [$bg, $col] = $statusC[$s->statut] ?? ['#EFF6FF','#2D60FF']; @endphp
                                <a href="{{ route('admin.planification.edit', $s->id) }}" style="display:block;background:{{ $bg }};border-left:2px solid {{ $col }};border-radius:4px;padding:0.3rem 0.5rem;margin-bottom:3px;text-decoration:none;">
                                    <div style="font-size:0.6rem;font-weight:800;color:{{ $col }};">{{ $s->date_heure_debut->format('H:i') }}</div>
                                    <div style="font-size:0.65rem;font-weight:700;color:#1B254B;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px;">{{ $s->etudiant?->user?->nom }}</div>
                                </a>
                                @endforeach
                            </td>
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

        </div>

    </div>

    {{-- ── Tableau jurys / prochaine soutenance ──────────────── --}}
    <div class="data-card mt-6">
        <div class="panel-header">
            @if(auth()->user()->role === 'enseignant')
                <span class="panel-title">Ma prochaine soutenance</span>
                <a href="{{ route('enseignant.evaluations.index') }}" class="btn-premium" style="font-size:0.72rem;">Mon agenda</a>
            @else
                <span class="panel-title">Corps des jurys</span>
                <a href="{{ route('admin.enseignants.index') }}" class="panel-link">Gérer</a>
            @endif
        </div>

        @if(auth()->user()->role === 'enseignant')
            @if($nextSoutenance)
            <div style="padding:1.25rem 1.5rem;display:flex;flex-wrap:wrap;gap:2rem;align-items:flex-start;">
                <div>
                    <div class="row-sub" style="margin-bottom:0.25rem;">{{ $nextSoutenance->date_heure_debut->translatedFormat('l d F Y') }} à {{ $nextSoutenance->date_heure_debut->format('H:i') }}</div>
                    <div class="row-name">{{ $nextSoutenance->etudiant?->user?->nom }} {{ $nextSoutenance->etudiant?->user?->prenom }}</div>
                    <div class="row-sub" style="margin-top:2px;font-style:italic;">{{ Str::limit($nextSoutenance->sujet, 80) }}</div>
                    <div class="row-sub" style="margin-top:4px;">{{ $nextSoutenance->salle?->nom }}</div>
                </div>
                <div>
                    <div class="table-filter-label" style="margin-bottom:0.4rem;">Jury</div>
                    @foreach($nextSoutenance->juryMembres as $m)
                    <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.3rem;">
                        <span class="badge badge-blue">{{ $m->fonction }}</span>
                        <span class="row-text">{{ $m->enseignant?->user?->nom }} {{ $m->enseignant?->user?->prenom }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="empty-state">Aucune soutenance à venir</div>
            @endif

        @else
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Grade</th>
                            <th>Spécialité</th>
                            <th>Département</th>
                            <th>Bureau</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enseignants as $e)
                        <tr>
                            <td>
                                <div class="row-identity">
                                    <div class="avatar" style="background:#2D60FF;">{{ substr($e->user?->prenom??'E',0,1) }}{{ substr($e->user?->nom??'N',0,1) }}</div>
                                    <div>
                                        <div class="row-name">{{ $e->user?->nom }} {{ $e->user?->prenom }}</div>
                                        <div class="row-sub">{{ $e->user?->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-blue">{{ $e->grade }}</span></td>
                            <td><span class="row-text">{{ $e->specialite }}</span></td>
                            <td><span class="row-muted">{{ $e->departement ?? '—' }}</span></td>
                            <td><span class="row-muted">{{ $e->bureau ?? '—' }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
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

@include('admin._table-styles')
</x-app-layout>
