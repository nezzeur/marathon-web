@extends("layout.app")

@section('contenu')
    {{-- CSS Spécifique pour la page des articles --}}
    <style>
        .articles-container {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .article-card-index {
            transition: all 0.3s ease;
        }
        
        .article-card-index:hover {
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
                Tous les articles
            </h1>
            
            <p class="text-gray-300 mb-6 max-w-3xl">
                Explorez notre collection complète d'articles. Utilisez la barre de recherche ci-dessous pour filtrer par titre, accessibilité, conclusion ou rythme.
            </p>
            
            {{-- Barre de recherche --}}
            <x-search-bar :accessibilites="$accessibilites" :conclusions="$conclusions" :rythmes="$rythmes" />
        </div>
        
        {{-- Liste des articles --}}
        <div class="articles-container rounded-2xl p-6">
            @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($articles as $article)
                        <div class="article-card-index bg-black/50 rounded-xl border border-white/10 overflow-hidden">
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
                    {{ $articles->links() }}
                </div>
                
            @else
                <div class="text-center py-12">
                    <h3 class="text-2xl font-bold text-white mb-4">Aucun article trouvé</h3>
                    <p class="text-gray-300 mb-6">Il n'y a pas encore d'articles publiés.</p>
                    
                    @auth
                        <a href="{{ route('articles.create') }}" 
                           class="bg-gradient-to-r from-[#2858bb] to-[#c2006d] text-white px-6 py-2 rounded-lg font-medium hover:opacity-90 transition-opacity">
                            Publier le premier article
                        </a>
                    @else
                        <p class="text-gray-400">Connectez-vous pour publier des articles.</p>
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <script>
        // Animation pour les cartes
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.article-card-index').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
@endsection