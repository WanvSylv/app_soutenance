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
                <div style="margin-top:1rem;">
                    <span class="badge badge-amber">En attente de quitus</span>
                </div>
            </div>
        </div>
    </div>

@elseif($memoire)
    <div class="data-card" style="padding:2rem;margin-bottom:1.25rem;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div style="flex:1;min-width:0;">
                @php
                    $statusBadge = ['en_attente'=>['badge-amber','En attente'],'valide'=>['badge-green','Validé'],'rejete'=>['badge-red','Rejeté']];
                    [$cls, $lbl] = $statusBadge[$memoire->statut] ?? ['badge-amber','—'];
                @endphp
                <span class="badge {{ $cls }}" style="margin-bottom:0.75rem;">{{ $lbl }}</span>
                <div style="font-size:1rem;font-weight:800;color:#1B254B;margin-bottom:0.3rem;line-height:1.3;">{{ $memoire->titre }}</div>
                <div style="font-size:0.78rem;font-weight:500;color:#A3AED0;margin-bottom:1rem;">Déposé le {{ $memoire->date_depot->format('d/m/Y à H:i') }}</div>
                @if($memoire->resume)
                <div style="background:#F4F7FE;border-radius:6px;padding:0.875rem;margin-bottom:1rem;">
                    <div class="table-filter-label" style="margin-bottom:0.4rem;">Résumé</div>
                    <div style="font-size:0.825rem;font-weight:500;color:#1B254B;line-height:1.6;">{{ $memoire->resume }}</div>
                </div>
                @endif
                @if($memoire->statut === 'rejete' && $memoire->motif_rejet)
                <div style="background:#FFF5F5;border:1px solid #FECACA;border-radius:6px;padding:0.875rem;margin-bottom:1rem;">
                    <div class="table-filter-label" style="color:#DC2626;margin-bottom:0.4rem;">Motif du rejet</div>
                    <div style="font-size:0.825rem;font-weight:500;color:#DC2626;">{{ $memoire->motif_rejet }}</div>
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

    <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:8px;padding:0.875rem 1.25rem;font-size:0.8rem;font-weight:500;color:#1E40AF;">
        Votre mémoire a bien été reçu. Vous serez convoqué par email une fois la soutenance planifiée par l'administration.
    </div>

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
                    <input id="fichier" name="fichier" type="file" accept="application/pdf" required
                        style="font-family:inherit;font-size:0.8rem;font-weight:500;color:#1B254B;width:100%;">
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

@include('admin._table-styles')
@include('admin._form-styles')
</x-app-layout>
