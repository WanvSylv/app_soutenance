<x-app-layout>
@section('header', 'Paramètres')

@if(session('success'))
    <div class="alert-success" style="margin-bottom:1.5rem;"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ session('success') }}</div>
@endif

<form action="{{ route('admin.parametres.update') }}" method="POST">
    @csrf @method('PUT')

    {{-- Soutenances --}}
    <div class="form-card" style="margin-bottom:1.25rem;">
        <div class="form-section-title">Soutenances</div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;">
            <div class="form-field">
                <label class="form-label" for="duree_soutenance">Durée (min)</label>
                <div style="position:relative;">
                    <input id="duree_soutenance" name="duree_soutenance" type="number" class="form-input" style="padding-right:2.5rem;"
                        value="{{ old('duree_soutenance', $parametres->get('duree_soutenance')?->valeur ?? 90) }}" min="15" max="240" required>
                    <span style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);font-size:0.7rem;font-weight:700;color:#A3AED0;pointer-events:none;">min</span>
                </div>
                <x-input-error :messages="$errors->get('duree_soutenance')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="note_passage">Note de passage (/20)</label>
                <div style="position:relative;">
                    <input id="note_passage" name="note_passage" type="number" class="form-input" style="padding-right:2.5rem;"
                        value="{{ old('note_passage', $parametres->get('note_passage')?->valeur ?? 10) }}" min="0" max="20" step="0.5" required>
                    <span style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);font-size:0.7rem;font-weight:700;color:#A3AED0;pointer-events:none;">/20</span>
                </div>
                <x-input-error :messages="$errors->get('note_passage')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="delai_convocation_j">Délai convocations (j)</label>
                <div style="position:relative;">
                    <input id="delai_convocation_j" name="delai_convocation_j" type="number" class="form-input" style="padding-right:2rem;"
                        value="{{ old('delai_convocation_j', $parametres->get('delai_convocation_j')?->valeur ?? 7) }}" min="1" max="30" required>
                    <span style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);font-size:0.7rem;font-weight:700;color:#A3AED0;pointer-events:none;">j</span>
                </div>
                <x-input-error :messages="$errors->get('delai_convocation_j')" />
            </div>
        </div>
    </div>

    {{-- Mémoires --}}
    <div class="form-card" style="margin-bottom:1.25rem;">
        <div class="form-section-title">Mémoires</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
            <div class="form-field">
                <label class="form-label" for="taille_max_memoire_mo">Taille max (Mo)</label>
                <div style="position:relative;">
                    <input id="taille_max_memoire_mo" name="taille_max_memoire_mo" type="number" class="form-input" style="padding-right:2.5rem;"
                        value="{{ old('taille_max_memoire_mo', $parametres->get('taille_max_memoire_mo')?->valeur ?? 30) }}" min="1" max="500" required>
                    <span style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);font-size:0.7rem;font-weight:700;color:#A3AED0;pointer-events:none;">Mo</span>
                </div>
                <x-input-error :messages="$errors->get('taille_max_memoire_mo')" />
            </div>
        </div>
    </div>

    {{-- Institution --}}
    <div class="form-card" style="margin-bottom:1.5rem;">
        <div class="form-section-title">Institution</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
            <div class="form-field">
                <label class="form-label" for="nom_institution">Nom</label>
                <input id="nom_institution" name="nom_institution" type="text" class="form-input"
                    value="{{ old('nom_institution', $parametres->get('nom_institution')?->valeur ?? 'HOREB IP') }}" required>
                <x-input-error :messages="$errors->get('nom_institution')" />
            </div>
            <div class="form-field">
                <label class="form-label" for="ville_institution">Ville</label>
                <input id="ville_institution" name="ville_institution" type="text" class="form-input"
                    value="{{ old('ville_institution', $parametres->get('ville_institution')?->valeur ?? 'Cotonou') }}" required>
                <x-input-error :messages="$errors->get('ville_institution')" />
            </div>
            <div class="form-field" style="grid-column:1/-1;">
                <label class="form-label" for="email_contact">Email de contact</label>
                <input id="email_contact" name="email_contact" type="email" class="form-input"
                    value="{{ old('email_contact', $parametres->get('email_contact')?->valeur ?? 'contact@horebip.edu') }}" required>
                <x-input-error :messages="$errors->get('email_contact')" />
            </div>
        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;">
        <button type="submit" class="btn-premium">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Enregistrer les paramètres
        </button>
    </div>
</form>

@include('admin._table-styles')
@include('admin._form-styles')
</x-app-layout>
