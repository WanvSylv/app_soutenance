<x-app-layout>
    @section('header', 'Ajouter une Salle')

    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.salles.index') }}" class="text-sm text-blue-500 hover:underline flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour à la liste
            </a>
        </div>

        <div class="glass-card p-8">
            <form action="{{ route('admin.salles.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="code" :value="__('Code de la salle')" />
                        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code')" required placeholder="ex: SALLE-01" />
                        <x-input-error class="mt-2" :messages="$errors->get('code')" />
                    </div>

                    <div>
                        <x-input-label for="nom" :value="__('Nom complet')" />
                        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom')" required placeholder="ex: Amphithéâtre A" />
                        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="capacite" :value="__('Capacité (personnes)')" />
                        <x-text-input id="capacite" name="capacite" type="number" class="mt-1 block w-full" :value="old('capacite')" min="1" />
                        <x-input-error class="mt-2" :messages="$errors->get('capacite')" />
                    </div>

                    <div>
                        <x-input-label for="localisation" :value="__('Localisation / Bâtiment')" />
                        <x-text-input id="localisation" name="localisation" type="text" class="mt-1 block w-full" :value="old('localisation')" placeholder="ex: Bâtiment B, 1er étage" />
                        <x-input-error class="mt-2" :messages="$errors->get('localisation')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="equipements" :value="__('Équipements (optionnel)')" />
                    <textarea id="equipements" name="equipements" rows="3" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold" placeholder="Ex: Vidéoprojecteur, Tableau blanc, etc.">{{ old('equipements') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('equipements')" />
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="btn-premium px-8">
                        Enregistrer la salle
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
