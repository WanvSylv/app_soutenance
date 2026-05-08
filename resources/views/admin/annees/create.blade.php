<x-app-layout>
    @section('header', 'Nouvelle Session Académique')

    <div class="max-w-2xl mx-auto animate-fade-in">
        <div class="mb-8">
            <a href="{{ route('admin.annees-academiques.index') }}" class="inline-flex items-center text-sm font-bold text-blue-500 hover:text-blue-400 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour à la liste des sessions
            </a>
        </div>

        <div class="glass-card p-10">
            <form action="{{ route('admin.annees-academiques.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="group">
                    <x-input-label for="libelle" :value="__('Libellé de la session')" />
                    <x-text-input id="libelle" name="libelle" type="text" class="block w-full" :value="old('libelle')" required placeholder="Ex: 2025 - 2026" />
                    <x-input-error class="mt-2" :messages="$errors->get('libelle')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="date_debut" :value="__('Date de début')" />
                        <x-text-input id="date_debut" name="date_debut" type="date" class="block w-full" :value="old('date_debut')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('date_debut')" />
                    </div>

                    <div class="group">
                        <x-input-label for="date_fin" :value="__('Date de fin')" />
                        <x-text-input id="date_fin" name="date_fin" type="date" class="block w-full" :value="old('date_fin')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('date_fin')" />
                    </div>
                </div>

                <div class="p-6 bg-blue-50 rounded-2xl flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-[#1B254B]">Définir comme session active</p>
                        <p class="text-xs text-[#A3AED0] font-medium mt-1">Toutes les autres sessions seront désactivées.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="active" value="1" class="sr-only peer" {{ old('active') ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit" class="btn-premium px-12">
                        Enregistrer la session
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
