<x-app-layout>
    @section('header', 'Mon Mémoire')

    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-500 rounded-xl animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-500 rounded-xl animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        @if(!$anneeActive)
            <div class="glass-card p-12 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>La période de dépôt des mémoires n'est pas encore ouverte.</p>
            </div>
        @elseif(!$eligible)
            <div class="glass-card p-12 text-center">
                <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-[#1B254B] mb-4">Dépôt non autorisé</h3>
                <p class="text-[#A3AED0] font-medium max-w-md mx-auto mb-8">
                    Votre dossier n'a pas encore été validé par l'administration. Vous devez obtenir votre <strong>quitus</strong> pour pouvoir déposer votre mémoire.
                </p>
                <div class="inline-flex items-center px-6 py-3 bg-[#F4F7FE] rounded-2xl text-sm font-bold text-[#1B254B]">
                    Statut actuel : <span class="ml-2 px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-xs uppercase">En attente de quitus</span>
                </div>
            </div>
        @elseif($memoire)
            <div class="glass-card p-8 mb-8 border-l-4 border-green-500">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded text-xs font-bold uppercase mb-4 inline-block">DÉPOSÉ</span>
                        <h3 class="text-2xl font-bold mb-2">{{ $memoire->titre }}</h3>
                        <p class="text-sm text-gray-500 mb-6">Déposé le {{ \Carbon\Carbon::parse($memoire->date_depot)->format('d/m/Y à H:i') }}</p>
                        
                        <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl mb-6">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Résumé</h4>
                            <p class="text-gray-700 dark:text-gray-300">{{ $memoire->resume ?? 'Aucun résumé fourni.' }}</p>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('etudiant.memoire.view') }}" target="_blank" class="btn-premium mr-3">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Voir le fichier
                            </a>
                            <a href="{{ route('etudiant.memoire.download') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Télécharger
                            </a>
                            <span class="text-xs text-gray-400 italic">Taille du fichier : {{ $memoire->taille_fichier_ko }} Ko</span>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-24 h-24 text-green-500/20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </div>
            
            <div class="p-6 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                <p class="text-blue-600 dark:text-blue-400 text-sm">
                    <strong>Note :</strong> Votre mémoire a bien été reçu. Vous recevrez une convocation par email une fois que l'administration aura planifié votre soutenance. Assurez-vous que votre <strong>quitus</strong> a été validé.
                </p>
            </div>
        @else
            <div class="glass-card p-8">
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">Déposer mon mémoire</h3>
                    <p class="text-sm text-gray-500">Année Académique Active : <span class="font-bold text-gray-900 dark:text-white">{{ $anneeActive->libelle }}</span></p>
                </div>

                <form action="{{ route('etudiant.memoire.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="titre" :value="__('Titre complet du mémoire')" />
                        <x-text-input id="titre" name="titre" type="text" class="mt-1 block w-full" :value="old('titre')" required placeholder="Entrez le titre officiel de votre mémoire" />
                        <x-input-error class="mt-2" :messages="$errors->get('titre')" />
                    </div>

                    <div>
                        <x-input-label for="resume" :value="__('Résumé / Abstract (optionnel)')" />
                        <textarea id="resume" name="resume" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Décrivez brièvement le contenu de votre travail...">{{ old('resume') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('resume')" />
                    </div>

                    <div class="p-8 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl text-center">
                        <x-input-label for="fichier" :value="__('Fichier du mémoire (PDF uniquement)')" class="sr-only" />
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <input id="fichier" name="fichier" type="file" accept="application/pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required />
                            <p class="mt-2 text-xs text-gray-400">PDF uniquement, taille maximum {{ $maxMo }} Mo</p>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('fichier')" />
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="btn-premium px-12 py-3">
                            Déposer le mémoire
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
