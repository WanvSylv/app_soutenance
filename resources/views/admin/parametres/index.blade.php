<x-app-layout>
    @section('header', 'Paramètres Globaux')

    <div class="max-w-5xl mx-auto animate-fade-in">

        @if(session('success'))
            <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-3xl animate-fade-in flex items-center shadow-sm">
                <div class="p-2 bg-emerald-500 text-white rounded-xl mr-4 shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.parametres.update') }}" method="POST" class="space-y-10">
            @csrf
            @method('PUT')

            {{-- Section 1 : Soutenances --}}
            <div class="glass-card p-10">
                <div class="flex items-center space-x-4 mb-10">
                    <div class="p-3 bg-blue-500/10 rounded-2xl">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-[#1B254B] uppercase tracking-tight">Paramètres des Soutenances</h2>
                        <p class="text-sm text-[#A3AED0] font-medium mt-1">Durée, notes, délais de convocation</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <x-input-label for="duree_soutenance" :value="__('Durée d\'une soutenance (min)')" />
                        <div class="relative mt-1">
                            <x-text-input id="duree_soutenance" name="duree_soutenance" type="number" class="block w-full pr-16"
                                :value="old('duree_soutenance', $parametres->get('duree_soutenance')?->valeur ?? 90)"
                                min="15" max="240" required />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#A3AED0] font-bold text-sm pointer-events-none">min</span>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('duree_soutenance')" />
                    </div>

                    <div>
                        <x-input-label for="note_passage" :value="__('Note minimale de passage (/20)')" />
                        <div class="relative mt-1">
                            <x-text-input id="note_passage" name="note_passage" type="number" class="block w-full pr-12"
                                :value="old('note_passage', $parametres->get('note_passage')?->valeur ?? 10)"
                                min="0" max="20" step="0.5" required />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#A3AED0] font-bold text-sm pointer-events-none">/20</span>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('note_passage')" />
                    </div>

                    <div>
                        <x-input-label for="delai_convocation_j" :value="__('Délai min. convocations (jours)')" />
                        <div class="relative mt-1">
                            <x-text-input id="delai_convocation_j" name="delai_convocation_j" type="number" class="block w-full pr-14"
                                :value="old('delai_convocation_j', $parametres->get('delai_convocation_j')?->valeur ?? 7)"
                                min="1" max="30" required />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#A3AED0] font-bold text-sm pointer-events-none">j</span>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('delai_convocation_j')" />
                    </div>
                </div>
            </div>

            {{-- Section 2 : Mémoires --}}
            <div class="glass-card p-10">
                <div class="flex items-center space-x-4 mb-10">
                    <div class="p-3 bg-indigo-500/10 rounded-2xl">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-[#1B254B] uppercase tracking-tight">Paramètres des Mémoires</h2>
                        <p class="text-sm text-[#A3AED0] font-medium mt-1">Taille maximale autorisée pour le dépôt</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <x-input-label for="taille_max_memoire_mo" :value="__('Taille max. du mémoire (Mo)')" />
                        <div class="relative mt-1">
                            <x-text-input id="taille_max_memoire_mo" name="taille_max_memoire_mo" type="number" class="block w-full pr-12"
                                :value="old('taille_max_memoire_mo', $parametres->get('taille_max_memoire_mo')?->valeur ?? 30)"
                                min="1" max="500" required />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#A3AED0] font-bold text-sm pointer-events-none">Mo</span>
                        </div>
                        <p class="text-xs text-[#A3AED0] mt-2 font-medium">Taille maximale autorisée pour le dépôt de mémoire en ligne.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('taille_max_memoire_mo')" />
                    </div>
                </div>
            </div>

            {{-- Section 3 : Institution --}}
            <div class="glass-card p-10">
                <div class="flex items-center space-x-4 mb-10">
                    <div class="p-3 bg-amber-500/10 rounded-2xl">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-[#1B254B] uppercase tracking-tight">Informations de l'Institution</h2>
                        <p class="text-sm text-[#A3AED0] font-medium mt-1">Utilisées dans les emails et les documents générés</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <x-input-label for="nom_institution" :value="__('Nom de l\'institution')" />
                        <x-text-input id="nom_institution" name="nom_institution" type="text" class="mt-1 block w-full"
                            :value="old('nom_institution', $parametres->get('nom_institution')?->valeur ?? 'HOREB IP')"
                            required />
                        <x-input-error class="mt-2" :messages="$errors->get('nom_institution')" />
                    </div>

                    <div>
                        <x-input-label for="ville_institution" :value="__('Ville')" />
                        <x-text-input id="ville_institution" name="ville_institution" type="text" class="mt-1 block w-full"
                            :value="old('ville_institution', $parametres->get('ville_institution')?->valeur ?? 'Cotonou')"
                            required />
                        <x-input-error class="mt-2" :messages="$errors->get('ville_institution')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="email_contact" :value="__('Email de contact administration')" />
                        <x-text-input id="email_contact" name="email_contact" type="email" class="mt-1 block w-full"
                            :value="old('email_contact', $parametres->get('email_contact')?->valeur ?? 'contact@horebip.edu')"
                            required />
                        <x-input-error class="mt-2" :messages="$errors->get('email_contact')" />
                    </div>
                </div>
            </div>

            {{-- Bouton de sauvegarde --}}
            <div class="flex justify-end">
                <button type="submit" class="btn-premium px-14 text-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Enregistrer les Paramètres
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
