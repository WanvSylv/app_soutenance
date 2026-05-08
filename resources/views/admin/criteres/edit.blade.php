<x-app-layout>
    @section('header', 'Modifier le Critère')

    <div class="max-w-2xl mx-auto animate-fade-in">
        <div class="mb-8">
            <a href="{{ route('admin.criteres.index') }}" class="inline-flex items-center text-sm font-bold text-blue-500 hover:text-blue-400 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour à la liste des critères
            </a>
        </div>

        <div class="glass-card p-10">
            <form action="{{ route('admin.criteres.update', $critere->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="group">
                    <x-input-label for="libelle" :value="__('Libellé du critère')" />
                    <x-text-input id="libelle" name="libelle" type="text" class="block w-full" :value="old('libelle', $critere->libelle)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('libelle')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <x-input-label for="coefficient" :value="__('Coefficient')" />
                        <x-text-input id="coefficient" name="coefficient" type="number" step="0.1" class="block w-full" :value="old('coefficient', $critere->coefficient)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('coefficient')" />
                    </div>

                    <div class="group">
                        <x-input-label for="ordre" :value="__('Ordre d\'affichage')" />
                        <x-text-input id="ordre" name="ordre" type="number" class="block w-full" :value="old('ordre', $critere->ordre)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('ordre')" />
                    </div>
                </div>

                <div class="group">
                    <x-input-label for="description" :value="__('Description (optionnel)')" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold">{{ old('description', $critere->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-[#F4F7FE]">
                    <label class="flex items-center space-x-4 cursor-pointer">
                        <input type="hidden" name="actif" value="0">
                        <input type="checkbox" id="actif" name="actif" value="1" {{ old('actif', $critere->actif) ? 'checked' : '' }}
                            class="w-5 h-5 rounded-lg border-[#E0E5F2] text-[#2D60FF] focus:ring-[#2D60FF]/20">
                        <div>
                            <span class="font-black text-[#1B254B] text-sm">Critère actif</span>
                            <p class="text-xs text-[#A3AED0] mt-0.5">Les critères inactifs ne sont pas utilisés lors des évaluations.</p>
                        </div>
                    </label>
                    <button type="submit" class="btn-premium px-12">
                        Mettre à jour le critère
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
