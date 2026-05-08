<x-app-layout>
    @section('header', 'Créer un Nouvel Utilisateur')

    <div class="max-w-4xl mx-auto animate-fade-in">
        <div class="mb-8">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm font-bold text-blue-500 hover:text-blue-400 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour à la liste des comptes
            </a>
        </div>

        <div class="glass-card p-10">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ photoPreview: null }">
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
                        <h3 class="text-xl font-black text-[#1B254B] uppercase tracking-tight mb-1">Photo de l'utilisateur</h3>
                        <p class="text-xs text-[#A3AED0] font-medium">Format JPG, PNG. Taille max 2Mo.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="nom" :value="__('Nom de famille')" />
                        <x-text-input id="nom" name="nom" type="text" class="block w-full" :value="old('nom')" required placeholder="Ex: WANVOEGBE" />
                        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                    </div>

                    <div class="group">
                        <x-input-label for="prenom" :value="__('Prénoms')" />
                        <x-text-input id="prenom" name="prenom" type="text" class="block w-full" :value="old('prenom')" required placeholder="Ex: Sylvain" />
                        <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="email" :value="__('Adresse Email')" />
                        <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email')" required placeholder="contact@universite.bj" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="group">
                        <x-input-label for="role" :value="__('Rôle de l\'utilisateur')" />
                        <select id="role" name="role" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold" required>
                            <option value="">Sélectionner un rôle</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                            <option value="enseignant" {{ old('role') == 'enseignant' ? 'selected' : '' }}>Jury</option>
                            <option value="etudiant" {{ old('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                    </div>
                </div>

                <div class="group">
                    <x-input-label for="telephone" :value="__('Numéro de Téléphone')" />
                    <x-text-input id="telephone" name="telephone" type="text" class="block w-full" :value="old('telephone')" placeholder="+229 ..." />
                    <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
                </div>

                <div class="p-6 bg-amber-500/5 border border-amber-500/10 rounded-2xl">
                    <div class="flex items-start">
                        <div class="p-2 bg-amber-500/20 rounded-lg mr-4">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-amber-500 mb-1">Génération automatique</p>
                            <p class="text-xs text-amber-200/60 leading-relaxed font-medium">Un mot de passe sécurisé sera généré automatiquement et envoyé par email à l'utilisateur. Il pourra le modifier après sa première connexion.</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit" class="btn-premium px-12">
                        Enregistrer l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
