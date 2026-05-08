<x-app-layout>
    @section('header', 'Modifier la Salle')

    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.salles.index') }}" class="text-sm text-blue-500 hover:underline flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour à la liste
            </a>
        </div>

        <div class="glass-card p-8">
            <form action="{{ route('admin.salles.update', $salle) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="code" :value="__('Code de la salle')" />
                        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $salle->code)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('code')" />
                    </div>

                    <div>
                        <x-input-label for="nom" :value="__('Nom complet')" />
                        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom', $salle->nom)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="capacite" :value="__('Capacité (personnes)')" />
                        <x-text-input id="capacite" name="capacite" type="number" class="mt-1 block w-full" :value="old('capacite', $salle->capacite)" min="1" />
                        <x-input-error class="mt-2" :messages="$errors->get('capacite')" />
                    </div>

                    <div>
                        <x-input-label for="localisation" :value="__('Localisation / Bâtiment')" />
                        <x-text-input id="localisation" name="localisation" type="text" class="mt-1 block w-full" :value="old('localisation', $salle->localisation)" />
                        <x-input-error class="mt-2" :messages="$errors->get('localisation')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="equipements" :value="__('Équipements')" />
                    <textarea id="equipements" name="equipements" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('equipements', $salle->equipements) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('equipements')" />
                </div>

                <div class="flex items-center space-x-2 mt-4">
                    <input type="checkbox" id="disponible" name="disponible" value="1" {{ $salle->disponible ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <x-input-label for="disponible" :value="__('Salle disponible pour les soutenances')" />
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="btn-premium px-8">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
