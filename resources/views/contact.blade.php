@extends('layout.app')

@section('contenu')

    {{-- CSS Spécifique pour l'ambiance (identique au modèle) --}}
    <style>
        /* Animation subtile pour que le fond ne soit pas trop statique */
        @keyframes pulse-grid {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }
        .bg-pulse {
            animation: pulse-grid 8s ease-in-out infinite;
        }
    </style>

    {{-- 1. BACKGROUND : Bannière Importée --}}
    <div class="fixed inset-0 z-0 overflow-hidden bg-black">
        {{-- Image de fond --}}
        <img
                src="{{ asset('images/bannière.png') }}"
                alt="Synthwave Grid Background"
                class="absolute inset-0 w-full h-full object-cover object-bottom bg-pulse"
        >
        {{-- Overlay sombre --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-transparent to-black/40"></div>
    </div>

    {{-- 2. CONTENU PRINCIPAL --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 py-10 space-y-20">

        {{-- HEADER DE PAGE : COMMS_LINK (Style Bleu #2858bb) --}}
        <div class="flex flex-col items-center md:items-start">
            <div class="flex items-end gap-4 mb-8 border-b-4 border-[#2858bb] pb-2 pr-10 shadow-[0_4px_20px_rgba(40,88,187,0.3)] w-fit backdrop-blur-sm bg-black/30 px-4 rounded-t-lg">
                <div>
                    <h1 class="text-4xl md:text-6xl font-black font-orbitron text-transparent bg-clip-text bg-gradient-to-r from-[#bed2ff] to-white uppercase italic transform -skew-x-6 drop-shadow-[0_2px_0px_#2858bb]">
                        COMMS_LINK
                    </h1>
                    <p class="font-bold text-[#bed2ff] text-sm md:text-lg tracking-widest uppercase animate-pulse">
                        > ESTABLISHING CONNECTION...
                    </p>
                </div>
            </div>
        </div>

        {{-- SECTION 1 : THE DEV SQUAD (Style Rose #c2006d - Comme Fan Favorites) --}}
        <section>
            {{-- Sous-titre de section --}}
            <div class="flex items-end gap-4 mb-8 border-b-4 border-[#c2006d] pb-2 pr-10 shadow-[0_4px_20px_rgba(194,0,109,0.3)] w-fit backdrop-blur-sm bg-black/30 px-4 rounded-t-lg ml-auto md:ml-0">
                <div class="text-right md:text-left">
                    <h2 class="text-2xl md:text-4xl font-black font-orbitron text-transparent bg-clip-text bg-gradient-to-r from-[#ff8dc7] to-white uppercase italic transform -skew-x-6 drop-shadow-[0_2px_0px_#c2006d]">
                        The Dev Squad
                    </h2>
                    <span class="font-bold text-[#c2006d] text-xs md:text-sm tracking-widest uppercase text-right">> Choisis ton développeur (8/8)</span>
                </div>
            </div>

            {{-- Grille Membres --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                    $names = ['Néo Huyghe', 'Luka Blanchard', 'Quentin Baillet', 'Noa Peru', 'Kenza Salmi', 'Lola Delannoy', 'Anélie Coustenoble', 'Erwan Caudron'];
                    $roles = ['Cyber-Mage', 'Net-Runner', 'Code-Ninja', 'Sys-Admin', 'Data-Broker', 'Glitch-Hunter', 'Pixel-Artist', 'Bot-Master'];
                    // Couleurs néons adaptées au fond sombre
                    $colors = ['text-[#bed2ff]', 'text-[#ff8dc7]', 'text-cyan-400', 'text-green-400', 'text-orange-400', 'text-red-500', 'text-purple-400', 'text-white'];
                @endphp

                @foreach(range(1, 8) as $index)
                    <div class="group relative bg-black/60 backdrop-blur-md rounded-xl border border-[#c2006d]/30 p-4 hover:border-[#c2006d] hover:shadow-[0_0_25px_rgba(194,0,109,0.4)] transition-all duration-300 hover:-translate-y-2 flex flex-col items-center">

                        {{-- Avatar Container (CARRÉ + SCANLINE) --}}
                        {{-- Changement ici : rounded-lg au lieu de rounded-full --}}
                        <div class="w-24 h-24 md:w-32 md:h-32 mb-4 relative border-2 border-[#c2006d]/50 group-hover:border-[#ff8dc7] rounded-lg overflow-hidden shadow-[inset_0_0_20px_rgba(0,0,0,1)] group-hover:shadow-[0_0_20px_rgba(255,106,213,0.5)] transition-all duration-300">

                            <!-- Effet Scanline (Lignes TV) -->
                            <div class="absolute inset-0 z-20 bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.25)_50%),linear-gradient(90deg,rgba(255,0,0,0.06),rgba(0,255,0,0.02),rgba(0,0,255,0.06))] bg-[length:100%_4px] pointer-events-none opacity-80"></div>

                            <!-- Image -->
                            <img src="{{ asset('images/team/member-' . $index . '.webp') }}"
                                 alt="Member {{ $index }}"
                                 class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-300">
                        </div>

                        {{-- Info --}}
                        <div class="text-center z-10">
                            <p class="font-orbitron {{ $colors[$index-1] }} text-xs md:text-sm font-bold opacity-90 group-hover:text-white transition-colors group-hover:drop-shadow-[0_0_5px_currentColor]">
                                {{ $names[$index-1] }}
                            </p>
                            <p class="text-[10px] uppercase text-gray-400 tracking-widest mt-1 group-hover:text-[#ff8dc7]">
                                {{ $roles[$index-1] }}
                            </p>
                        </div>

                        {{-- Décorations Coins (Rose) --}}
                        <div class="absolute -top-1 -left-1 w-3 h-3 border-t-2 border-l-2 border-[#ff8dc7] opacity-50 group-hover:opacity-100 transition-opacity shadow-[0_0_10px_#ff8dc7]"></div>
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 border-b-2 border-r-2 border-[#ff8dc7] opacity-50 group-hover:opacity-100 transition-opacity shadow-[0_0_10px_#ff8dc7]"></div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Footer décoratif --}}
        <div class="text-center border-t border-[#2858bb]/20 pt-8 mt-12">
            <p class="text-[10px] font-mono text-[#bed2ff]/50 uppercase tracking-[0.2em] animate-pulse">End of transmission // Signal lost</p>
            <div class="mt-4">
                <a href="{{ route('wiki') }}" class="inline-block font-mono text-xs px-4 py-2 bg-[#2858bb] text-white hover:brightness-110 border-b-2 border-[#bed2ff]/30 active:border-b-0 active:translate-y-0.5 transition-all">
                    📚 ACCÉDER AU WIKI
                </a>
            </div>
        </div>

    </div>
@endsection
