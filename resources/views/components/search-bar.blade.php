@props([
    'accessibilites' => [],
    'conclusions' => [],
    'rythmes' => []
])

<div class="relative z-20 mb-12">
    <div class="bg-black/70 backdrop-blur-md rounded-2xl border-2 border-gradient-from-[#2858bb] border-gradient-to-[#c2006d] p-1">
        <div class="bg-black/80 rounded-xl p-6">
            <form action="{{ route('articles.search') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <!-- Champ de recherche par titre -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-[#bed2ff] mb-1">
                            Rechercher par titre
                        </label>
                        <input type="text" name="title" id="title" 
                               placeholder="Entrez un titre ou des mots-clés..."
                               class="w-full bg-black/50 border border-[#2858bb]/50 rounded-lg py-2 px-4 text-white placeholder-[#bed2ff]/70 focus:outline-none focus:border-[#bed2ff] focus:ring-1 focus:ring-[#bed2ff] transition-all">
                    </div>

                    <!-- Filtre par Accessibilité -->
                    <div>
                        <label for="accessibilite" class="block text-sm font-medium text-[#ff8dc7] mb-1">
                            Accessibilité
                        </label>
                        <select name="accessibilite" id="accessibilite"
                                class="w-full bg-black/50 border border-[#c2006d]/50 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-[#ff8dc7] focus:ring-1 focus:ring-[#ff8dc7] transition-all">
                            <option value="">Toutes</option>
                            @foreach($accessibilites as $accessibilite)
                                <option value="{{ $accessibilite->id }}">{{ $accessibilite->texte }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtre par Conclusion -->
                    <div>
                        <label for="conclusion" class="block text-sm font-medium text-[#bed2ff] mb-1">
                            Conclusion
                        </label>
                        <select name="conclusion" id="conclusion"
                                class="w-full bg-black/50 border border-[#2858bb]/50 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-[#bed2ff] focus:ring-1 focus:ring-[#bed2ff] transition-all">
                            <option value="">Toutes</option>
                            @foreach($conclusions as $conclusion)
                                <option value="{{ $conclusion->id }}">{{ $conclusion->texte }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <!-- Filtre par Rythme -->
                    <div>
                        <label for="rythme" class="block text-sm font-medium text-[#ff8dc7] mb-1">
                            Rythme
                        </label>
                        <select name="rythme" id="rythme"
                                class="w-full bg-black/50 border border-[#c2006d]/50 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-[#ff8dc7] focus:ring-1 focus:ring-[#ff8dc7] transition-all">
                            <option value="">Tous</option>
                            @foreach($rythmes as $rythme)
                                <option value="{{ $rythme->id }}">{{ $rythme->texte }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bouton de recherche -->
                    <div class="md:col-span-1 flex md:justify-end">
                        <button type="submit" 
                                class="w-full md:w-auto bg-gradient-to-r from-[#2858bb] to-[#c2006d] hover:from-[#3a6bdd] hover:to-[#d81a7f] text-white font-bold py-3 px-8 rounded-lg transform hover:scale-105 transition-all duration-200 shadow-[0_4px_15px_rgba(194,0,109,0.3)] hover:shadow-[0_6px_20px_rgba(194,0,109,0.4)]">
                            RECHERCHER
                        </button>
                    </div>

                    <!-- Bouton de réinitialisation -->
                    <div class="md:col-span-2 flex md:justify-start">
                        <a href="{{ route('home') }}" 
                           class="w-full md:w-auto bg-black/50 hover:bg-black/60 text-[#bed2ff] font-medium py-3 px-6 rounded-lg border border-[#2858bb]/30 hover:border-[#2858bb] transition-all duration-200">
                            RÉINITIALISER
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>