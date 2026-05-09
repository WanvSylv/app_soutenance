<x-app-layout>
    @section('header', 'Modifier l\'Étudiant')

    <div class="max-w-4xl mx-auto animate-fade-in">
        <div class="mb-8">
            <a href="{{ route('admin.etudiants.index') }}" class="inline-flex items-center text-sm font-bold text-blue-500 hover:text-blue-400 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour à la liste des étudiants
            </a>
        </div>

        <div class="glass-card p-10">
            <form action="{{ route('admin.etudiants.update', $etudiant->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ photoPreview: null }">
                @csrf
                @method('PUT')

                <div class="flex flex-col md:flex-row items-center gap-8 mb-12">
                    <div class="relative group">
                        <div class="h-32 w-32 rounded-[2rem] bg-[#F4F7FE] border-2 border-dashed border-[#E0E5F2] flex items-center justify-center overflow-hidden transition-all group-hover:border-blue-400">
                            <template x-if="!photoPreview">
                                @if($etudiant->user->photo_path)
                                    <img src="{{ asset('storage/' . $etudiant->user->photo_path) }}" class="h-full w-full object-cover">
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
                        <h3 class="text-xl font-black text-[#1B254B] uppercase tracking-tight mb-1">Photo de l'étudiant</h3>
                        <p class="text-xs text-[#A3AED0] font-medium">Laissez vide pour conserver la photo actuelle.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="nom" :value="__('Nom de famille')" />
                        <x-text-input id="nom" name="nom" type="text" class="block w-full" :value="old('nom', $etudiant->user->nom)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                    </div>

                    <div class="group">
                        <x-input-label for="prenom" :value="__('Prénoms')" />
                        <x-text-input id="prenom" name="prenom" type="text" class="block w-full" value="{{ old('prenom', $etudiant->user->prenom) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="email" :value="__('Adresse Email')" />
                        <x-text-input id="email" name="email" type="email" class="block w-full" value="{{ old('email', $etudiant->user->email) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="group">
                        <x-input-label for="telephone" :value="__('Téléphone')" />
                        <x-text-input id="telephone" name="telephone" type="text" class="block w-full" value="{{ old('telephone', $etudiant->user->telephone) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
                    </div>
                </div>

                <div class="pt-8 border-t border-[#F4F7FE]">
                    <h3 class="text-lg font-black text-[#1B254B] mb-6">Informations Académiques</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group">
                            <x-input-label for="matricule" :value="__('Matricule Étudiant')" />
                            <x-text-input id="matricule" name="matricule" type="text" class="block w-full" :value="old('matricule', $etudiant->matricule)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('matricule')" />
                        </div>

                        <div class="group">
                            <x-input-label for="niveau" :value="__('Niveau d\'étude')" />
                            <select id="niveau" name="niveau" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold" required>
                                <option value="Licence 3 (Bachelor)" {{ old('niveau', $etudiant->niveau) == 'Licence 3 (Bachelor)' ? 'selected' : '' }}>Licence 3</option>
                                <option value="Master 2" {{ old('niveau', $etudiant->niveau) == 'Master 2' ? 'selected' : '' }}>Master 2</option>
                                <option value="Doctorat" {{ old('niveau', $etudiant->niveau) == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('niveau')" />
                        </div>
                    </div>

                    <div class="group mt-8">
                        <x-input-label for="filiere" :value="__('Filière / Spécialité')" />
                        <select id="filiere" name="filiere" class="block w-full select2-field" required>
                            <option value="">Sélectionnez une filière</option>
                            <option value="Génie Logiciel" {{ old('filiere', $etudiant->filiere) == 'Génie Logiciel' ? 'selected' : '' }}>Génie Logiciel</option>
                            <option value="Cybersécurité" {{ old('filiere', $etudiant->filiere) == 'Cybersécurité' ? 'selected' : '' }}>Cybersécurité</option>
                            <option value="Réseaux et Télécommunications" {{ old('filiere', $etudiant->filiere) == 'Réseaux et Télécommunications' ? 'selected' : '' }}>Réseaux et Télécommunications</option>
                            <option value="Intelligence Artificielle" {{ old('filiere', $etudiant->filiere) == 'Intelligence Artificielle' ? 'selected' : '' }}>Intelligence Artificielle</option>
                            <option value="Data Science" {{ old('filiere', $etudiant->filiere) == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                            <option value="Informatique de Gestion" {{ old('filiere', $etudiant->filiere) == 'Informatique de Gestion' ? 'selected' : '' }}>Informatique de Gestion</option>
                            <option value="Développement Web et Mobile" {{ old('filiere', $etudiant->filiere) == 'Développement Web et Mobile' ? 'selected' : '' }}>Développement Web et Mobile</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('filiere')" />
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit" class="btn-premium px-12">
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
            tags: true // Permet à l'utilisateur de saisir une valeur non présente
        });
    });
</script>
@endsection
