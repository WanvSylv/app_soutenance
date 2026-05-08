<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-white tracking-tight mb-3">Inscription</h2>
        <div class="h-1.5 w-16 bg-blue-500 mx-auto rounded-full"></div>
        <p class="text-slate-400 mt-4 font-medium">Rejoignez la promotion 2026</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Nom -->
            <div class="group">
                <x-input-label for="nom" :value="__('Nom')" class="text-slate-300 font-bold mb-2 block group-focus-within:text-blue-400 transition-colors" />
                <input id="nom" type="text" name="nom" :value="old('nom')" required autofocus class="block w-full px-5 py-4 bg-slate-900/50 border border-slate-700 rounded-2xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300" placeholder="Ex: TRAORE">
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>

            <!-- Prénom -->
            <div class="group">
                <x-input-label for="prenom" :value="__('Prénom')" class="text-slate-300 font-bold mb-2 block group-focus-within:text-blue-400 transition-colors" />
                <input id="prenom" type="text" name="prenom" :value="old('prenom')" required class="block w-full px-5 py-4 bg-slate-900/50 border border-slate-700 rounded-2xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300" placeholder="Ex: Moussa">
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>
        </div>

        <!-- Email -->
        <div class="group">
            <x-input-label for="email" :value="__('Adresse Email')" class="text-slate-300 font-bold mb-2 block group-focus-within:text-blue-400 transition-colors" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-400 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" type="email" name="email" :value="old('email')" required class="block w-full pl-12 pr-4 py-4 bg-slate-900/50 border border-slate-700 rounded-2xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300" placeholder="exemple@horebip.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Matricule -->
            <div class="group">
                <x-input-label for="matricule" :value="__('Matricule')" class="text-slate-300 font-bold mb-2 block group-focus-within:text-blue-400 transition-colors" />
                <input id="matricule" type="text" name="matricule" :value="old('matricule')" required class="block w-full px-5 py-4 bg-slate-900/50 border border-slate-700 rounded-2xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300" placeholder="Ex: 2026IP001">
                <x-input-error :messages="$errors->get('matricule')" class="mt-2" />
            </div>

            <!-- Niveau -->
            <div class="group">
                <x-input-label for="niveau" :value="__('Niveau d\'étude')" class="text-slate-300 font-bold mb-2 block group-focus-within:text-blue-400 transition-colors" />
                <select id="niveau" name="niveau" class="block w-full px-5 py-4 bg-slate-900/50 border border-slate-700 rounded-2xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300 appearance-none">
                    <option value="L3" class="bg-slate-900">Licence 3 (Bachelor)</option>
                    <option value="M1" class="bg-slate-900">Master 1</option>
                    <option value="M2" class="bg-slate-900">Master 2</option>
                </select>
            </div>
        </div>

        <!-- Filière -->
        <div class="group">
            <x-input-label for="filiere" :value="__('Filière')" class="text-slate-300 font-bold mb-2 block group-focus-within:text-blue-400 transition-colors" />
            <input id="filiere" type="text" name="filiere" :value="old('filiere')" required class="block w-full px-5 py-4 bg-slate-900/50 border border-slate-700 rounded-2xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300" placeholder="Ex: Intelligence Artificielle">
            <x-input-error :messages="$errors->get('filiere')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Password -->
            <div class="group">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-slate-300 font-bold mb-2 block group-focus-within:text-blue-400 transition-colors" />
                <input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full px-5 py-4 bg-slate-900/50 border border-slate-700 rounded-2xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="group">
                <x-input-label for="password_confirmation" :value="__('Confirmation')" class="text-slate-300 font-bold mb-2 block group-focus-within:text-blue-400 transition-colors" />
                <input id="password_confirmation" type="password" name="password_confirmation" required class="block w-full px-5 py-4 bg-slate-900/50 border border-slate-700 rounded-2xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full btn-premium py-5 text-xl tracking-tight">
                {{ __('Créer mon compte étudiant') }}
            </button>
        </div>

        <div class="text-center mt-10">
            <p class="text-slate-500 font-medium">
                Déjà membre du portail ? 
                <a href="{{ route('login') }}" class="text-blue-400 font-bold hover:text-blue-300 transition decoration-2 underline-offset-4">
                    Se connecter ici
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
