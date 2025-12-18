@extends("layout.app")

@section('contenu')
    {{-- CSS Spécifique pour la page de résultats --}}
    <style>
        .search-results-container {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .filter-badge {
            background: linear-gradient(135deg, #2858bb, #c2006d);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .article-card-search {
            transition: all 0.3s ease;
        }
        
        .article-card-search:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(194, 0, 109, 0.2);
        }
    </style>

    {{-- Background --}}
    <div class="fixed inset-0 z-0 overflow-hidden bg-black">
        <img src="{{ asset('images/bannière.png') }}" alt="Synthwave Grid Background"
             class="absolute inset-0 w-full h-full object-cover object-bottom opacity-50">
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-transparent to-black/60"></div>
    </div>

    {{-- Contenu Principal --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 py-10">
        
        {{-- En-tête avec barre de recherche --}}
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-black font-orbitron text-transparent bg-clip-text bg-gradient-to-r from-[#bed2ff] to-[#ff8dc7] uppercase italic transform -skew-x-3 drop-shadow-[0_3px_0px_rgba(194,0,109,0.3)] mb-4">
                Résultats de recherche
            </h1>
            
            {{-- Afficher les filtres actifs --}}
            @if(request()->filled('title') || request()->filled('accessibilite') || request()->filled('conclusion') || request()->filled('rythme'))
                <div class="flex flex-wrap gap-3 mb-6">
                    @if(request()->filled('title'))
                        <span class="filter-badge">
                            <span class="text-white">Titre:</span>
                            <span class="text-yellow-200">"{{ request()->input('title') }}"</span>
                        </span>
                    @endif
                    
                    @if(request()->filled('accessibilite') && $accessibilites->where('id', request()->input('accessibilite'))->first())
                        <span class="filter-badge">
                            <span class="text-white">Accessibilité:</span>
                            <span class="text-yellow-200">{{ $accessibilites->where('id', request()->input('accessibilite'))->first()->nom }}</span>
                        </span>
                    @endif
                    
                    @if(request()->filled('conclusion') && $conclusions->where('id', request()->input('conclusion'))->first())
                        <span class="filter-badge">
                            <span class="text-white">Conclusion:</span>
                            <span class="text-yellow-200">{{ $conclusions->where('id', request()->input('conclusion'))->first()->nom }}</span>
                        </span>
                    @endif
                    
                    @if(request()->filled('rythme') && $rythmes->where('id', request()->input('rythme'))->first())
                        <span class="filter-badge">
                            <span class="text-white">Rythme:</span>
                            <span class="text-yellow-200">{{ $rythmes->where('id', request()->input('rythme'))->first()->nom }}</span>
                        </span>
                    @endif
                </div>
            @endif
            
            {{-- Barre de recherche (réutilisation du composant) --}}
            <x-search-bar :accessibilites="$accessibilites" :conclusions="$conclusions" :rythmes="$rythmes" />
        </div>
        
        {{-- Résultats --}}
        <div class="search-results-container rounded-2xl p-6">
            @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($articles as $article)
                        <div class="article-card-search bg-black/50 rounded-xl border border-white/10 overflow-hidden">
                            <div class="p-4">
                                <h3 class="text-xl font-bold text-white mb-2 truncate">
                                    {{ $article->titre }}
                                </h3>
                                
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @if($article->accessibilite)
                                        <span class="bg-[#2858bb]/20 text-[#bed2ff] text-xs px-2 py-1 rounded">
                                            {{ $article->accessibilite->nom }}
                                        </span>
                                    @endif
                                    
                                    @if($article->conclusion)
                                        <span class="bg-[#c2006d]/20 text-[#ff8dc7] text-xs px-2 py-1 rounded">
                                            {{ $article->conclusion->nom }}
                                        </span>
                                    @endif
                                    
                                    @if($article->rythme)
                                        <span class="bg-[#8b5cf6]/20 text-[#c4b5fd] text-xs px-2 py-1 rounded">
                                            {{ $article->rythme->nom }}
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-gray-300 text-sm mb-4 line-clamp-3">
                                    {{ $article->resume ?? Str::limit(strip_tags($article->texte), 100) }}
                                </p>
                                
                                <div class="flex justify-between items-center text-sm text-gray-400">
                                    <span>Auteur: {{ $article->editeur->name ?? 'Inconnu' }}</span>
                                    <span>{{ $article->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="px-4 pb-4">
                                <a href="{{ route('articles.show', $article->id) }}" 
                                   class="w-full block text-center bg-gradient-to-r from-[#2858bb] to-[#c2006d] text-white py-2 rounded-lg font-medium hover:from-[#3a6bdd] hover:to-[#d81a7f] transition-all">
                                    Lire l'article
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $articles->appends(request()->query())->links() }}
                </div>
                
            @else
                <div class="text-center py-12">
                    <h3 class="text-2xl font-bold text-white mb-4">Aucun article trouvé</h3>
                    <p class="text-gray-300 mb-6">Essayez d'ajuster vos critères de recherche.</p>
                    
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('home') }}" 
                           class="bg-gradient-to-r from-[#2858bb] to-[#c2006d] text-white px-6 py-2 rounded-lg font-medium hover:opacity-90 transition-opacity">
                            Retour à l'accueil
                        </a>
                        
                        <button onclick="history.back()"
                                class="bg-black/50 text-white px-6 py-2 rounded-lg font-medium hover:bg-black/60 transition-colors">
                            Retour en arrière
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Animation pour les badges de filtre
        document.addEventListener('DOMContentLoaded', function() {
            const badges = document.querySelectorAll('.filter-badge');
            badges.forEach((badge, index) => {
                badge.style.animationDelay = `${index * 0.1}s`;
                badge.style.animation = 'fadeIn 0.5s ease-out forwards';
            });
        });
        
        // Animation pour les cartes
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.article-card-search').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
@endsection