<x-app-layout>
@section('header', 'Mon mémoire')

@if(session('success'))
    <div class="alert-success" style="margin-bottom:1.25rem;"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="display:flex;align-items:center;gap:0.6rem;background:#FFF5F5;border:1px solid #FECACA;border-radius:8px;padding:0.75rem 1.25rem;font-size:0.825rem;font-weight:600;color:#DC2626;margin-bottom:1.25rem;">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        {{ session('error') }}
    </div>
@endif

@if(!$anneeActive)
    <div class="data-card" style="padding:3rem;text-align:center;">
        <div class="empty-state">
            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            La période de dépôt des mémoires n'est pas encore ouverte.
        </div>
    </div>

@elseif(!$eligible)
    <div class="data-card" style="padding:2.5rem;">
        <div style="display:flex;align-items:flex-start;gap:1rem;">
            <div style="width:40px;height:40px;border-radius:8px;background:#FFFBEB;border:1px solid #FDE68A;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" fill="none" stroke="#D97706" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <div style="font-size:0.9rem;font-weight:800;color:#1B254B;margin-bottom:0.4rem;">Dépôt non autorisé</div>
                <div style="font-size:0.825rem;font-weight:500;color:#A3AED0;line-height:1.6;">Votre dossier n'a pas encore été validé par l'administration. Vous devez obtenir votre <strong style="color:#1B254B;">quitus</strong> pour pouvoir déposer votre mémoire.</div>
                <div style="margin-top:1rem;"><span class="badge badge-amber">En attente de quitus</span></div>
            </div>
        </div>
    </div>

@elseif($memoire)
    @php
        $statusConfig = [
            'en_attente'            => ['badge-amber', 'En attente de validation'],
            'valide'                => ['badge-green',  'Validé'],
            'rejete'                => ['badge-red',    'Rejeté'],
            'corrections_demandees' => ['badge-orange', 'Corrections demandées'],
        ];
        [$badgeCls, $badgeLbl] = $statusConfig[$memoire->statut] ?? ['badge-amber', '—'];
        $canResubmit = $memoire->isResoumettable();
    @endphp

    {{-- Carte statut mémoire courant --}}
    <div class="data-card" style="padding:2rem;margin-bottom:1.25rem;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.75rem;flex-wrap:wrap;">
                    <span class="badge {{ $badgeCls }}">{{ $badgeLbl }}</span>
                    <span style="font-size:0.75rem;font-weight:700;color:#2D60FF;background:#EFF6FF;border:1px solid #BFDBFE;border-radius:20px;padding:0.15rem 0.65rem;">V{{ $memoire->numero_version }}</span>
                </div>
                <div style="font-size:1rem;font-weight:800;color:#1B254B;margin-bottom:0.3rem;line-height:1.3;">{{ $memoire->titre }}</div>
                <div style="font-size:0.78rem;font-weight:500;color:#A3AED0;margin-bottom:1rem;">Déposé le {{ $memoire->date_depot->format('d/m/Y à H:i') }}</div>

                @if($memoire->resume)
                    <div style="background:#F4F7FE;border-radius:6px;padding:0.875rem;margin-bottom:1rem;">
                        <div class="table-filter-label" style="margin-bottom:0.4rem;">Résumé</div>
                        <div style="font-size:0.825rem;font-weight:500;color:#1B254B;line-height:1.6;">{{ $memoire->resume }}</div>
                    </div>
                @endif

                @if($memoire->statut === 'corrections_demandees' && $memoire->motif_rejet)
                    <div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:6px;padding:0.875rem;margin-bottom:1rem;">
                        <div style="font-size:0.78rem;font-weight:700;color:#D97706;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:.03em;">Corrections à apporter</div>
                        <div style="font-size:0.825rem;font-weight:500;color:#92400E;line-height:1.6;white-space:pre-line;">{{ $memoire->motif_rejet }}</div>
                    </div>
                @endif

                @if($memoire->statut === 'rejete' && $memoire->motif_rejet)
                    <div style="background:#FFF5F5;border:1px solid #FECACA;border-radius:6px;padding:0.875rem;margin-bottom:1rem;">
                        <div style="font-size:0.78rem;font-weight:700;color:#DC2626;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:.03em;">Motif du rejet</div>
                        <div style="font-size:0.825rem;font-weight:500;color:#DC2626;line-height:1.6;white-space:pre-line;">{{ $memoire->motif_rejet }}</div>
                    </div>
                @endif

                <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
                    <a href="{{ route('etudiant.memoire.view') }}" target="_blank" class="btn-premium" style="font-size:0.75rem;padding:0.55rem 1.25rem;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Voir le fichier
                    </a>
                    <a href="{{ route('etudiant.memoire.download') }}" class="btn-outline" style="font-size:0.75rem;padding:0.55rem 1.25rem;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Télécharger
                    </a>
                    <span style="font-size:0.72rem;font-weight:500;color:#A3AED0;align-self:center;">{{ number_format($memoire->taille_fichier_ko / 1024, 1) }} Mo</span>
                </div>
            </div>
        </div>
    </div>

    @if($memoire->statut === 'valide')
        <div style="background:#ECFDF5;border:1px solid #A7F3D0;border-radius:8px;padding:0.875rem 1.25rem;font-size:0.8rem;font-weight:500;color:#065F46;margin-bottom:1.25rem;">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="vertical-align:middle;margin-right:0.4rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Votre mémoire a été validé. Vous serez convoqué par email une fois la soutenance planifiée par l'administration.
        </div>
    @elseif($memoire->statut === 'en_attente')
        <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:8px;padding:0.875rem 1.25rem;font-size:0.8rem;font-weight:500;color:#1E40AF;margin-bottom:1.25rem;">
            Votre mémoire est en cours d'examen par l'administration. Vous serez notifié par email du résultat.
        </div>
    @endif

    {{-- Formulaire de re-soumission --}}
    @if($canResubmit)
        <div class="form-card" style="margin-bottom:1.25rem;">
            <div style="margin-bottom:1.25rem;">
                <div class="form-section-title">
                    @if($memoire->statut === 'corrections_demandees')
                        Soumettre une version corrigée
                    @else
                        Soumettre une nouvelle version
                    @endif
                </div>
                <div style="font-size:0.8rem;font-weight:500;color:#A3AED0;">
                    Cette version sera numérotée <strong style="color:#2D60FF;">V{{ $memoire->numero_version + 1 }}</strong> et remplacera la version actuelle en cours d'examen.
                </div>
            </div>

            <form action="{{ route('etudiant.memoire.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-field" style="margin-bottom:1.25rem;">
                    <label class="form-label" for="titre">Titre complet du mémoire</label>
                    <input id="titre" name="titre" type="text" class="form-input" value="{{ old('titre', $memoire->titre) }}" placeholder="Titre officiel de votre mémoire" required>
                    <x-input-error :messages="$errors->get('titre')" />
                </div>

                <div class="form-field" style="margin-bottom:1.25rem;">
                    <label class="form-label" for="resume">Résumé <span style="font-weight:400;text-transform:none;">(optionnel)</span></label>
                    <textarea id="resume" name="resume" rows="4" class="form-input" placeholder="Décrivez brièvement le contenu de votre travail…" style="resize:vertical;">{{ old('resume', $memoire->resume) }}</textarea>
                    <x-input-error :messages="$errors->get('resume')" />
                </div>

                <div class="form-field" style="margin-bottom:1.5rem;">
                    <label class="form-label" for="fichier">Nouveau fichier PDF</label>
                    <div style="background:#F4F7FE;border:1.5px dashed #E0E5F2;border-radius:8px;padding:1.5rem;text-align:center;">
                        <svg width="32" height="32" fill="none" stroke="#A3AED0" viewBox="0 0 24 24" stroke-width="1.5" style="margin:0 auto 0.75rem;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <input id="fichier" name="fichier" type="file" accept="application/pdf" required style="font-family:inherit;font-size:0.8rem;font-weight:500;color:#1B254B;width:100%;">
                        <div style="font-size:0.7rem;color:#A3AED0;margin-top:0.5rem;">PDF uniquement — max {{ $maxMo }} Mo</div>
                    </div>
                    <x-input-error :messages="$errors->get('fichier')" />
                </div>

                <div style="display:flex;justify-content:flex-end;">
                    <button type="submit" class="btn-premium">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Soumettre la version corrigée
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Historique des versions --}}
    @if($versions->count() > 0)
        <div class="data-card" style="padding:1.5rem;">
            <div style="font-size:0.9rem;font-weight:800;color:#1B254B;margin-bottom:1rem;">Historique des versions soumises</div>
            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                @foreach($versions as $v)
                    @php
                        $vBadges  = ['valide'=>['badge-green','Validé'],'rejete'=>['badge-red','Rejeté'],'corrections_demandees'=>['badge-orange','Corrections dem.'],'en_attente'=>['badge-amber','En attente']];
                        [$vCls, $vLbl] = $vBadges[$v->statut_apres ?? ''] ?? ['','—'];
                    @endphp
                    <div style="border:1px solid #E0E5F2;border-radius:8px;padding:0.875rem 1.25rem;">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:0.75rem;flex-wrap:wrap;margin-bottom:0.4rem;">
                            <div style="display:flex;align-items:center;gap:0.6rem;">
                                <span style="font-size:0.8rem;font-weight:800;color:#2D60FF;">V{{ $v->numero_version }}</span>
                                <span style="font-size:0.75rem;color:#A3AED0;">{{ $v->date_depot->format('d/m/Y à H:i') }}</span>
                                <span style="font-size:0.72rem;color:#A3AED0;">— {{ number_format($v->taille_fichier_ko / 1024, 1) }} Mo</span>
                            </div>
                            @if($vCls)
                                <span class="badge {{ $vCls }}" style="font-size:0.7rem;">{{ $vLbl }}</span>
                            @endif
                        </div>
                        <div style="font-size:0.8rem;font-weight:600;color:#1B254B;margin-bottom:0.3rem;">{{ $v->titre }}</div>
                        @if($v->motif)
                            <div style="font-size:0.75rem;color:#A3AED0;line-height:1.5;white-space:pre-line;">{{ $v->motif }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@else
    <div class="form-card">
        <div style="margin-bottom:1.25rem;">
            <div class="form-section-title">Dépôt du mémoire</div>
            <div style="font-size:0.8rem;font-weight:500;color:#A3AED0;">Année académique active : <strong style="color:#1B254B;">{{ $anneeActive->libelle }}</strong></div>
        </div>

        <form action="{{ route('etudiant.memoire.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-field" style="margin-bottom:1.25rem;">
                <label class="form-label" for="titre">Titre complet du mémoire</label>
                <input id="titre" name="titre" type="text" class="form-input" value="{{ old('titre') }}" placeholder="Titre officiel de votre mémoire" required>
                <x-input-error :messages="$errors->get('titre')" />
            </div>

            <div class="form-field" style="margin-bottom:1.25rem;">
                <label class="form-label" for="resume">Résumé <span style="font-weight:400;text-transform:none;">(optionnel)</span></label>
                <textarea id="resume" name="resume" rows="4" class="form-input" placeholder="Décrivez brièvement le contenu de votre travail…" style="resize:vertical;">{{ old('resume') }}</textarea>
                <x-input-error :messages="$errors->get('resume')" />
            </div>

            <div class="form-field" style="margin-bottom:1.5rem;">
                <label class="form-label" for="fichier">Fichier PDF</label>
                <div style="background:#F4F7FE;border:1.5px dashed #E0E5F2;border-radius:8px;padding:1.5rem;text-align:center;">
                    <svg width="32" height="32" fill="none" stroke="#A3AED0" viewBox="0 0 24 24" stroke-width="1.5" style="margin:0 auto 0.75rem;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <input id="fichier" name="fichier" type="file" accept="application/pdf" required style="font-family:inherit;font-size:0.8rem;font-weight:500;color:#1B254B;width:100%;">
                    <div style="font-size:0.7rem;color:#A3AED0;margin-top:0.5rem;">PDF uniquement — max {{ $maxMo }} Mo</div>
                </div>
                <x-input-error :messages="$errors->get('fichier')" />
            </div>

            <div style="display:flex;justify-content:flex-end;">
                <button type="submit" class="btn-premium">Déposer le mémoire</button>
            </div>
        </form>
    </div>
@endif

<style>
.badge-orange { background:#FFFBEB; color:#D97706; border:1px solid #FDE68A; }
</style>

@include('admin._table-styles')
@include('admin._form-styles')
</x-app-layout>
