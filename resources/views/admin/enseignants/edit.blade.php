<x-app-layout>
    @section('header', 'Modifier le Jury')

    <div class="max-w-4xl mx-auto animate-fade-in">
        <div class="mb-8">
            <a href="{{ route('admin.enseignants.index') }}" class="inline-flex items-center text-sm font-bold text-blue-500 hover:text-blue-400 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour à la liste des jurys
            </a>
        </div>

        <div class="glass-card p-10">
            <form action="{{ route('admin.enseignants.update', $enseignant->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ photoPreview: null }">
                @csrf
                @method('PUT')

                <div class="flex flex-col md:flex-row items-center gap-8 mb-12">
                    <div class="relative group">
                        <div class="h-32 w-32 rounded-[2rem] bg-[#F4F7FE] border-2 border-dashed border-[#E0E5F2] flex items-center justify-center overflow-hidden transition-all group-hover:border-blue-400">
                            <template x-if="!photoPreview">
                                @if($enseignant->user->photo_path)
                                    <img src="{{ asset('storage/' . $enseignant->user->photo_path) }}" class="h-full w-full object-cover">
                                @else
                                    <svg class="w-10 h-10 text-[#A3AED0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
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
                        <p class="text-xs text-[#A3AED0] font-medium">Laissez vide pour conserver la photo actuelle.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                    </div>
                </div>

                <div class="flex items-center space-x-4 mb-2">
                    <div class="p-2 bg-blue-500/10 rounded-xl">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#1B254B] uppercase tracking-tight">Informations Personnelles</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="nom" :value="__('Nom')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <x-text-input id="nom" name="nom" type="text" class="block w-full" :value="old('nom', $enseignant->user->nom)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                    </div>

                    <div class="group">
                        <x-input-label for="prenom" :value="__('Prénom')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <x-text-input id="prenom" name="prenom" type="text" class="block w-full" :value="old('prenom', $enseignant->user->prenom)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="email" :value="__('Email Professionnel')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $enseignant->user->email)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="group">
                        <x-input-label for="telephone" :value="__('Téléphone')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <x-text-input id="telephone" name="telephone" type="text" class="block w-full" :value="old('telephone', $enseignant->user->telephone)" />
                        <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
                    </div>
                </div>

                <div class="flex items-center space-x-4 mt-12 mb-2">
                    <div class="p-2 bg-violet-500/10 rounded-xl">
                        <svg class="w-6 h-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">Expertise Académique</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="grade" :value="__('Grade')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <x-text-input id="grade" name="grade" type="text" class="block w-full" :value="old('grade', $enseignant->grade)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('grade')" />
                    </div>

                    <div class="group">
                        <x-input-label for="specialite" :value="__('Spécialité')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                        <select id="specialite" name="specialite" class="block w-full select2-field" required>
                            <option value="">Sélectionnez une spécialité</option>
                            <option value="Génie Logiciel" {{ old('specialite', $enseignant->specialite) == 'Génie Logiciel' ? 'selected' : '' }}>Génie Logiciel</option>
                            <option value="Cybersécurité" {{ old('specialite', $enseignant->specialite) == 'Cybersécurité' ? 'selected' : '' }}>Cybersécurité</option>
                            <option value="Réseaux et Télécommunications" {{ old('specialite', $enseignant->specialite) == 'Réseaux et Télécommunications' ? 'selected' : '' }}>Réseaux et Télécommunications</option>
                            <option value="Intelligence Artificielle" {{ old('specialite', $enseignant->specialite) == 'Intelligence Artificielle' ? 'selected' : '' }}>Intelligence Artificielle</option>
                            <option value="Data Science" {{ old('specialite', $enseignant->specialite) == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                            <option value="Systèmes Embarqués" {{ old('specialite', $enseignant->specialite) == 'Systèmes Embarqués' ? 'selected' : '' }}>Systèmes Embarqués</option>
                            <option value="Informatique de Gestion" {{ old('specialite', $enseignant->specialite) == 'Informatique de Gestion' ? 'selected' : '' }}>Informatique de Gestion</option>
                            <option value="Développement Web et Mobile" {{ old('specialite', $enseignant->specialite) == 'Développement Web et Mobile' ? 'selected' : '' }}>Développement Web et Mobile</option>
                            <option value="Cloud Computing" {{ old('specialite', $enseignant->specialite) == 'Cloud Computing' ? 'selected' : '' }}>Cloud Computing</option>
                            <option value="Administration Bases de Données" {{ old('specialite', $enseignant->specialite) == 'Administration Bases de Données' ? 'selected' : '' }}>Administration Bases de Données</option>
                            <option value="Audit et Sécurité Informatique" {{ old('specialite', $enseignant->specialite) == 'Audit et Sécurité Informatique' ? 'selected' : '' }}>Audit et Sécurité Informatique</option>
                            <option value="Internet des Objets (IoT)" {{ old('specialite', $enseignant->specialite) == 'Internet des Objets (IoT)' ? 'selected' : '' }}>Internet des Objets (IoT)</option>
                            <option value="Gestion de Projet Informatique" {{ old('specialite', $enseignant->specialite) == 'Gestion de Projet Informatique' ? 'selected' : '' }}>Gestion de Projet Informatique</option>
                            <option value="Ingénierie des Systèmes" {{ old('specialite', $enseignant->specialite) == 'Ingénierie des Systèmes' ? 'selected' : '' }}>Ingénierie des Systèmes</option>
                            <option value="Bioinformatique" {{ old('specialite', $enseignant->specialite) == 'Bioinformatique' ? 'selected' : '' }}>Bioinformatique</option>
                            <option value="Génie Informatique" {{ old('specialite', $enseignant->specialite) == 'Génie Informatique' ? 'selected' : '' }}>Génie Informatique</option>
                            @if(!in_array(old('specialite', $enseignant->specialite), ['', 'Génie Logiciel', 'Cybersécurité', 'Réseaux et Télécommunications', 'Intelligence Artificielle', 'Data Science', 'Systèmes Embarqués', 'Informatique de Gestion', 'Développement Web et Mobile', 'Cloud Computing', 'Administration Bases de Données', 'Audit et Sécurité Informatique', 'Internet des Objets (IoT)', 'Gestion de Projet Informatique', 'Ingénierie des Systèmes', 'Bioinformatique', 'Génie Informatique']))
                                <option value="{{ old('specialite', $enseignant->specialite) }}" selected>{{ old('specialite', $enseignant->specialite) }}</option>
                            @endif
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('specialite')" />
                    </div>
                </div>

                <div class="group">
                    <x-input-label for="departement" :value="__('Département')" class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-2" />
                    <select id="departement" name="departement" class="block w-full select2-field">
                        <option value="">Sélectionnez un département</option>
                        <option value="Sciences Informatiques" {{ old('departement', $enseignant->departement) == 'Sciences Informatiques' ? 'selected' : '' }}>Sciences Informatiques</option>
                        <option value="Génie Électrique et Informatique" {{ old('departement', $enseignant->departement) == 'Génie Électrique et Informatique' ? 'selected' : '' }}>Génie Électrique et Informatique</option>
                        <option value="Mathématiques Appliquées" {{ old('departement', $enseignant->departement) == 'Mathématiques Appliquées' ? 'selected' : '' }}>Mathématiques Appliquées</option>
                        <option value="Management des Systèmes d'Information" {{ old('departement', $enseignant->departement) == "Management des Systèmes d'Information" ? 'selected' : '' }}>Management des Systèmes d'Information</option>
                        <option value="Télécommunications" {{ old('departement', $enseignant->departement) == 'Télécommunications' ? 'selected' : '' }}>Télécommunications</option>
                        <option value="Ingénierie des Technologies" {{ old('departement', $enseignant->departement) == 'Ingénierie des Technologies' ? 'selected' : '' }}>Ingénierie des Technologies</option>
                        <option value="Sciences des Données" {{ old('departement', $enseignant->departement) == 'Sciences des Données' ? 'selected' : '' }}>Sciences des Données</option>
                        <option value="Innovation et Recherche" {{ old('departement', $enseignant->departement) == 'Innovation et Recherche' ? 'selected' : '' }}>Innovation et Recherche</option>
                        @if(!in_array(old('departement', $enseignant->departement), ['', 'Sciences Informatiques', 'Génie Électrique et Informatique', 'Mathématiques Appliquées', "Management des Systèmes d'Information", 'Télécommunications', 'Ingénierie des Technologies', 'Sciences des Données', 'Innovation et Recherche']))
                            <option value="{{ old('departement', $enseignant->departement) }}" selected>{{ old('departement', $enseignant->departement) }}</option>
                        @endif
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('departement')" />
                </div>

                <div class="flex justify-end items-center pt-10 space-x-6">
                    <a href="{{ route('admin.enseignants.index') }}" class="text-sm font-bold text-slate-400 hover:text-white transition">Annuler</a>
                    <button type="submit" class="btn-premium px-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Mettre à jour le profil
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
