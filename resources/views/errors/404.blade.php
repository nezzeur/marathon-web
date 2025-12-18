@php
    // Pas de modèles nécessaires pour une page d'erreur statique
@endphp

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

    {{-- 2. CONTENU DE L'ERREUR 404 --}}
    <div class="relative z-10 flex items-center justify-center min-h-screen text-center text-white px-4">

        <div class="space-y-8 max-w-4xl p-8 backdrop-blur-md bg-black/50 rounded-xl border border-[#2858bb]/50 shadow-[0_0_30px_rgba(40,88,187,0.4)]">

            {{-- Titre "404" avec effet néon bleu --}}
            <h1 class="text-7xl md:text-9xl font-black font-orbitron text-transparent bg-clip-text bg-gradient-to-r from-[#bed2ff] to-white uppercase italic transform -skew-x-6 drop-shadow-[0_4px_0px_#2858bb]">
                404
            </h1>

            {{-- Sous-titre avec effet néon rose --}}
            <h2 class="text-2xl md:text-3xl font-bold text-[#ff8dc7] tracking-widest uppercase drop-shadow-[0_2px_10px_rgba(194,0,109,0.5)]">
                Page Introuvable
            </h2>

            {{-- Message d'explication --}}
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto">
                Oups ! Il semble que vous ayez atteint une zone non cartographiée de la grille. La page que vous cherchez a peut-être été déplacée, archivée ou n'a jamais existé.
            </p>

            {{-- Bouton de retour à l'accueil --}}
            <div>
                <a href="{{ url('/') }}"
                   class="inline-block mt-4 px-8 py-3 font-bold text-lg text-white uppercase bg-gradient-to-r from-[#c2006d] to-[#2858bb] rounded-md border-2 border-transparent hover:border-white transition-all duration-300 transform hover:scale-105 shadow-[0_0_20px_rgba(194,0,109,0.5),_0_0_20px_rgba(40,88,187,0.5)]">
                    Retour à l'Accueil
                </a>
            </div>
        </div>

    </div>

@endsection
