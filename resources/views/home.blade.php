@extends("layout.app")

@section('contenu')

    {{-- Fond Grille 3D utilisant les variables CSS --}}
    <div class="fixed inset-0 z-0 pointer-events-none bg-background">
    </div>

    <!-- Grid Floor -->
    <div class="fixed bottom-0 left-0 right-0 h-[45vh] z-0 pointer-events-none opacity-40"
         style="
            background-image:
                linear-gradient(0deg, transparent 24%, var(--border) 25%, var(--border) 26%, transparent 27%, transparent 74%, var(--border) 75%, var(--border) 76%, transparent 77%, transparent),
                linear-gradient(90deg, transparent 24%, var(--border) 25%, var(--border) 26%, transparent 27%, transparent 74%, var(--border) 75%, var(--border) 76%, transparent 77%, transparent);
            background-size: 50px 50px;
            perspective: 1000px;
            transform: perspective(500px) rotateX(60deg) translateY(100px) scale(2);
         ">
    </div>

    {{-- Contenu Principal --}}
    <div class="relative z-10 max-w-6xl mx-auto p-5 mt-10 space-y-24">

        @if(isset($articlesPlusVus) && count($articlesPlusVus) > 0)
            <section>
                <div class="flex items-center gap-4 mb-8 border-b-2 border-primary pb-2 w-fit pr-10 shadow-[0_4px_20px_rgba(0,255,255,0.2)]">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-orbitron font-bold text-primary uppercase italic transform -skew-x-6" style="text-shadow: 2px 2px 0px var(--muted);">
                            High Scores
                        </h2>
                        <span class="font-montserrat text-xl text-muted-foreground">> Most Viewed Data</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articlesPlusVus as $article)
                        <div class="group relative bg-card border border-border p-1 hover:border-primary hover:shadow-[0_0_25px_rgba(0,255,255,0.3)] transition-all duration-300 hover:-translate-y-1">
                            <x-article-card :article="$article" />

                            <!-- Corner Accents -->
                            <div class="absolute -top-1 -left-1 w-3 h-3 border-t-2 border-l-2 border-primary opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 border-b-2 border-r-2 border-primary opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if(isset($articlesPlusLikes) && count($articlesPlusLikes) > 0)
            <section>
                <div class="flex items-center gap-4 mb-8 border-b-2 border-secondary pb-2 w-fit pr-10 shadow-[0_4px_20px_rgba(255,106,213,0.2)]">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-orbitron font-bold text-secondary uppercase italic transform -skew-x-6" style="text-shadow: 2px 2px 0px var(--muted);">
                            Fan Favorites
                        </h2>
                        <span class="font-montserrat text-xl text-muted-foreground">> Top Rated</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articlesPlusLikes as $article)
                        <div class="group relative bg-card border border-border p-1 hover:border-secondary hover:shadow-[0_0_25px_rgba(255,106,213,0.3)] transition-all duration-300 hover:-translate-y-1">
                            <x-article-card :article="$article" />

                            <!-- Corner Accents -->
                            <div class="absolute -top-1 -left-1 w-3 h-3 border-t-2 border-l-2 border-secondary opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 border-b-2 border-r-2 border-secondary opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
