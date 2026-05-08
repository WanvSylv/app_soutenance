<x-app-layout>
    @section('header', 'Modifier le Compte')

    <div class="max-w-4xl mx-auto animate-fade-in">
        <div class="mb-8">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm font-bold text-blue-500 hover:text-blue-400 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour à la liste des comptes
            </a>
        </div>

        <div class="glass-card p-10">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ photoPreview: null }">
                @csrf
                @method('PUT')

                <div class="flex flex-col md:flex-row items-center gap-8 mb-12">
                    <div class="relative group">
                        <div class="h-32 w-32 rounded-[2rem] bg-[#F4F7FE] border-2 border-dashed border-[#E0E5F2] flex items-center justify-center overflow-hidden transition-all group-hover:border-blue-400">
                            <template x-if="!photoPreview">
                                @if($user->photo_path)
                                    <img src="{{ asset('storage/' . $user->photo_path) }}" class="h-full w-full object-cover">
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
                        <h3 class="text-xl font-black text-[#1B254B] uppercase tracking-tight mb-1">Photo de l'utilisateur</h3>
                        <p class="text-xs text-[#A3AED0] font-medium">Laissez vide pour conserver la photo actuelle.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="nom" :value="__('Nom de famille')" />
                        <x-text-input id="nom" name="nom" type="text" class="block w-full" :value="old('nom', $user->nom)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                    </div>

                    <div class="group">
                        <x-input-label for="prenom" :value="__('Prénoms')" />
                        <x-text-input id="prenom" name="prenom" type="text" class="block w-full" :value="old('prenom', $user->prenom)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="email" :value="__('Adresse Email')" />
                        <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $user->email)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="group">
                        <x-input-label for="role" :value="__('Rôle de l\'utilisateur')" />
                        <select id="role" name="role" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold" required>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                            <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="enseignant" {{ old('role', $user->role) == 'enseignant' ? 'selected' : '' }}>Jury</option>
                            <option value="etudiant" {{ old('role', $user->role) == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="telephone" :value="__('Numéro de Téléphone')" />
                        <x-text-input id="telephone" name="telephone" type="text" class="block w-full" :value="old('telephone', $user->telephone)" />
                        <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
                    </div>

                    <div class="p-6 bg-blue-50 rounded-2xl flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-[#1B254B]">État du compte</p>
                            <p class="text-xs text-[#A3AED0] font-medium mt-1">Désactiver le compte bloquera tout accès.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="actif" value="0">
                            <input type="checkbox" name="actif" value="1" class="sr-only peer" {{ old('actif', $user->actif) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>

                <div class="pt-8 border-t border-[#F4F7FE]">
                    <h3 class="text-lg font-black text-[#1B254B] mb-6">Changer le mot de passe (Optionnel)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group">
                            <x-input-label for="password" :value="__('Nouveau mot de passe')" />
                            <x-text-input id="password" name="password" type="password" class="block w-full" placeholder="Laissez vide pour ne pas changer" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div class="group">
                            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit" class="btn-premium px-12">
                        Mettre à jour le compte
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
