<x-app-layout>
    @section('header', 'Ajouter un Jury')

    <div class="max-w-4xl mx-auto animate-fade-in">
        <div class="mb-8">
            <a href="{{ route('admin.enseignants.index') }}" class="inline-flex items-center text-sm font-bold text-blue-500 hover:text-blue-400 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour à la liste des jurys
            </a>
        </div>

        <div class="glass-card p-10">
            <form action="{{ route('admin.enseignants.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ photoPreview: null }">
                @csrf

                <div class="flex flex-col md:flex-row items-center gap-8 mb-12">
                    <div class="relative group">
                        <div class="h-32 w-32 rounded-[2rem] bg-[#F4F7FE] border-2 border-dashed border-[#E0E5F2] flex items-center justify-center overflow-hidden transition-all group-hover:border-blue-400">
                            <template x-if="!photoPreview">
                                <svg class="w-10 h-10 text-[#A3AED0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </template>
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="h-full w-full object-cover">
                            </template>
                        </div>
                        <label for="photo" class="absolute -bottom-2 -right-2 h-10 w-10 bg-blue-600 text-white rounded-xl flex items-center justify-center cursor-pointer shadow-lg shadow-blue-500/20 hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <input type="file" id="photo" name="photo" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }">
                        </label>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-[#1B254B] uppercase tracking-tight mb-1">Photo de profil</h3>
                        <p class="text-xs text-[#A3AED0] font-medium">Format JPG, PNG. Taille max 2Mo.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                    </div>
                </div>

                <div class="flex items-center space-x-4 mb-2">
                    <div class="p-2 bg-blue-500/10 rounded-xl">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#1B254B] uppercase tracking-tight">Informations de base</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="nom" :value="__('Nom')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <x-text-input id="nom" name="nom" type="text" class="block w-full" :value="old('nom')" required placeholder="Ex: TRAORE" />
                        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                    </div>

                    <div class="group">
                        <x-input-label for="prenom" :value="__('Prénom')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <x-text-input id="prenom" name="prenom" type="text" class="block w-full" :value="old('prenom')" required placeholder="Ex: Moussa" />
                        <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="email" :value="__('Email Professionnel')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email')" required placeholder="exemple@horebip.com" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="group">
                        <x-input-label for="telephone" :value="__('Téléphone')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <x-text-input id="telephone" name="telephone" type="text" class="block w-full" :value="old('telephone')" placeholder="+229 ..." />
                        <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
                    </div>
                </div>

                <div class="flex items-center space-x-4 mt-12 mb-2">
                    <div class="p-2 bg-violet-500/10 rounded-xl">
                        <svg class="w-6 h-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">Profil Académique</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="grade" :value="__('Grade')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <x-text-input id="grade" name="grade" type="text" class="block w-full" :value="old('grade')" required placeholder="Ex: Docteur, Professeur" />
                        <x-input-error class="mt-2" :messages="$errors->get('grade')" />
                    </div>

                    <div class="group">
                        <x-input-label for="specialite" :value="__('Spécialité')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <select id="specialite" name="specialite" class="block w-full select2-field" required>
                            <option value="">Sélectionnez une spécialité</option>
                            <option value="Génie Logiciel" {{ old('specialite') == 'Génie Logiciel' ? 'selected' : '' }}>Génie Logiciel</option>
                            <option value="Cybersécurité" {{ old('specialite') == 'Cybersécurité' ? 'selected' : '' }}>Cybersécurité</option>
                            <option value="Réseaux et Télécommunications" {{ old('specialite') == 'Réseaux et Télécommunications' ? 'selected' : '' }}>Réseaux et Télécommunications</option>
                            <option value="Intelligence Artificielle" {{ old('specialite') == 'Intelligence Artificielle' ? 'selected' : '' }}>Intelligence Artificielle</option>
                            <option value="Data Science" {{ old('specialite') == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                            <option value="Systèmes Embarqués" {{ old('specialite') == 'Systèmes Embarqués' ? 'selected' : '' }}>Systèmes Embarqués</option>
                            <option value="Informatique de Gestion" {{ old('specialite') == 'Informatique de Gestion' ? 'selected' : '' }}>Informatique de Gestion</option>
                            <option value="Développement Web et Mobile" {{ old('specialite') == 'Développement Web et Mobile' ? 'selected' : '' }}>Développement Web et Mobile</option>
                            <option value="Cloud Computing" {{ old('specialite') == 'Cloud Computing' ? 'selected' : '' }}>Cloud Computing</option>
                            <option value="Administration Bases de Données" {{ old('specialite') == 'Administration Bases de Données' ? 'selected' : '' }}>Administration Bases de Données</option>
                            <option value="Audit et Sécurité Informatique" {{ old('specialite') == 'Audit et Sécurité Informatique' ? 'selected' : '' }}>Audit et Sécurité Informatique</option>
                            <option value="Internet des Objets (IoT)" {{ old('specialite') == 'Internet des Objets (IoT)' ? 'selected' : '' }}>Internet des Objets (IoT)</option>
                            <option value="Gestion de Projet Informatique" {{ old('specialite') == 'Gestion de Projet Informatique' ? 'selected' : '' }}>Gestion de Projet Informatique</option>
                            <option value="Ingénierie des Systèmes" {{ old('specialite') == 'Ingénierie des Systèmes' ? 'selected' : '' }}>Ingénierie des Systèmes</option>
                            <option value="Bioinformatique" {{ old('specialite') == 'Bioinformatique' ? 'selected' : '' }}>Bioinformatique</option>
                            <option value="Génie Informatique" {{ old('specialite') == 'Génie Informatique' ? 'selected' : '' }}>Génie Informatique</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('specialite')" />
                    </div>
                </div>

                <div class="group">
                    <x-input-label for="departement" :value="__('Département')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                    <select id="departement" name="departement" class="block w-full select2-field">
                        <option value="">Sélectionnez un département</option>
                        <option value="Sciences Informatiques" {{ old('departement') == 'Sciences Informatiques' ? 'selected' : '' }}>Sciences Informatiques</option>
                        <option value="Génie Électrique et Informatique" {{ old('departement') == 'Génie Électrique et Informatique' ? 'selected' : '' }}>Génie Électrique et Informatique</option>
                        <option value="Mathématiques Appliquées" {{ old('departement') == 'Mathématiques Appliquées' ? 'selected' : '' }}>Mathématiques Appliquées</option>
                        <option value="Management des Systèmes d\'Information" {{ old('departement') == "Management des Systèmes d'Information" ? 'selected' : '' }}>Management des Systèmes d'Information</option>
                        <option value="Télécommunications" {{ old('departement') == 'Télécommunications' ? 'selected' : '' }}>Télécommunications</option>
                        <option value="Ingénierie des Technologies" {{ old('departement') == 'Ingénierie des Technologies' ? 'selected' : '' }}>Ingénierie des Technologies</option>
                        <option value="Sciences des Données" {{ old('departement') == 'Sciences des Données' ? 'selected' : '' }}>Sciences des Données</option>
                        <option value="Innovation et Recherche" {{ old('departement') == 'Innovation et Recherche' ? 'selected' : '' }}>Innovation et Recherche</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('departement')" />
                </div>

                <div class="p-6 bg-amber-500/5 border border-amber-500/10 rounded-2xl">
                    <div class="flex items-start">
                        <div class="p-2 bg-amber-500/20 rounded-lg mr-4">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-amber-500 mb-1">Génération automatique</p>
                            <p class="text-xs text-amber-200/60 leading-relaxed font-medium">Un mot de passe sécurisé sera généré automatiquement et envoyé par email à l'enseignant.</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit" class="btn-premium px-12">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Créer le compte enseignant
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-field').select2({
            width: '100%',
            placeholder: "Faites un choix ou tapez pour rechercher",
            allowClear: true,
            tags: true // Permet à l'utilisateur de saisir une valeur non présente dans la liste si besoin
        });
    });
</script>
@endsection
