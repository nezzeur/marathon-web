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
                        <div class="group relative bg-black/60 backdrop-blur-md rounded-xl border border-[#2858bb]/30 p-2 hover:border-[#2858bb] hover:shadow-[0_0_25px_rgba(40,88,187,0.4)] transition-all duration-300 hover:-translate-y-2">

                            <x-article-card :article="$article" />

                            <div class="absolute -top-1 -left-1 w-4 h-4 border-t-2 border-l-2 border-[#bed2ff] opacity-50 group-hover:opacity-100 transition-opacity shadow-[0_0_10px_#bed2ff]"></div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 border-b-2 border-r-2 border-[#bed2ff] opacity-50 group-hover:opacity-100 transition-opacity shadow-[0_0_10px_#bed2ff]"></div>
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