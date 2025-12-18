@php use App\Models\Accessibilite;use App\Models\Conclusion;use App\Models\Rythme; @endphp
@extends("layout.app")

@section('contenu')

    {{-- CSS Spécifique pour l'ambiance --}}
    <style>
        /* Animation subtile pour que le fond ne soit pas trop statique */
        @keyframes pulse-grid {
            0%, 100% {
                opacity: 0.8;
            }
            50% {
                opacity: 1;
            }
        }

        .bg-pulse {
            animation: pulse-grid 8s ease-in-out infinite;
        }
    </style>

    {{-- 1. BACKGROUND : Bannière Importée --}}
    <div class="fixed inset-0 z-0 overflow-hidden bg-black">
        {{-- Image de fond : La bannière prend tout l'écran, ancrée en bas --}}
        <img
                src="{{ asset('images/bannière.png') }}"
                alt="Synthwave Grid Background"
                class="absolute inset-0 w-full h-full object-cover object-bottom bg-pulse"
        >

        {{-- Overlay léger pour que le texte reste lisible sur le dégradé --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-transparent to-black/40"></div>
    </div>

    {{-- 2. CONTENU PRINCIPAL --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 py-10 space-y-20">

        {{-- BARRE DE RECHERCHE --}}
        @php
            // Récupérer les données nécessaires pour la barre de recherche
            $accessibilites = Accessibilite::all();
            $conclusions = Conclusion::all();
            $rythmes = Rythme::all();
        @endphp

        <x-search-bar :accessibilites="$accessibilites" :conclusions="$conclusions" :rythmes="$rythmes"/>



        {{-- SECTION 1 : HIGH SCORES (Thème Bleu #2858bb / #bed2ff) --}}
        @if(isset($articlesPlusVus) && count($articlesPlusVus) > 0)
            <section>
                {{-- Titre de section --}}
                <div class="flex items-end gap-4 mb-8 border-b-4 border-[#2858bb] pb-2 pr-10 shadow-[0_4px_20px_rgba(40,88,187,0.3)] w-fit backdrop-blur-sm bg-black/30 px-4 rounded-t-lg">
                    <div>
                        <h2 class="text-3xl md:text-5xl font-black font-orbitron text-transparent bg-clip-text bg-gradient-to-r from-[#bed2ff] to-white uppercase italic transform -skew-x-6 drop-shadow-[0_2px_0px_#2858bb]">
                            Top Articles
                        </h2>
                        <span class="font-bold text-[#bed2ff] text-sm md:text-lg tracking-widest uppercase">> Les plus vus</span>
                    </div>
                </div>

                {{-- Grille Articles Bleu --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articlesPlusVus as $article)
                        <div class="group relative bg-black/60 backdrop-blur-md rounded-xl border border-[#2858bb]/30 p-2 hover:border-[#2858bb] hover:shadow-[0_0_25px_rgba(40,88,187,0.4)] transition-all duration-300 hover:-translate-y-2">

                            <x-article-card :article="$article"/>

                            <div class="absolute -top-1 -left-1 w-4 h-4 border-t-2 border-l-2 border-[#bed2ff] opacity-50 group-hover:opacity-100 transition-opacity shadow-[0_0_10px_#bed2ff]"></div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 border-b-2 border-r-2 border-[#bed2ff] opacity-50 group-hover:opacity-100 transition-opacity shadow-[0_0_10px_#bed2ff]"></div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- SECTION 2 : FAN FAVORITES (Thème Rose #c2006d) --}}
        @if(isset($articlesPlusLikes) && count($articlesPlusLikes) > 0)
            <section>
                {{-- Titre de section --}}
                <div class="flex items-end gap-4 mb-8 border-b-4 border-[#c2006d] pb-2 pr-10 shadow-[0_4px_20px_rgba(194,0,109,0.3)] w-fit backdrop-blur-sm bg-black/30 px-4 rounded-t-lg ml-auto md:ml-0">
                    <div class="text-right md:text-left">
                        <h2 class="text-3xl md:text-5xl font-black font-orbitron text-transparent bg-clip-text bg-gradient-to-r from-[#ff8dc7] to-white uppercase italic transform -skew-x-6 drop-shadow-[0_2px_0px_#c2006d]">
                            Top Articles
                        </h2>
                        <span class="font-bold text-[#c2006d] text-sm md:text-lg tracking-widest uppercase text-right">> Les plus likés</span>
                    </div>
                </div>

                {{-- Grille Articles Rose --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articlesPlusLikes as $article)
                        <div class="group relative bg-black/60 backdrop-blur-md rounded-xl border border-[#c2006d]/30 p-2 hover:border-[#c2006d] hover:shadow-[0_0_25px_rgba(194,0,109,0.4)] transition-all duration-300 hover:-translate-y-2">

                            <x-article-card :article="$article"/>

                            <div class="absolute -top-1 -left-1 w-4 h-4 border-t-2 border-l-2 border-[#c2006d] opacity-50 group-hover:opacity-100 transition-opacity shadow-[0_0_10px_#c2006d]"></div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 border-b-2 border-r-2 border-[#c2006d] opacity-50 group-hover:opacity-100 transition-opacity shadow-[0_0_10px_#c2006d]"></div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection