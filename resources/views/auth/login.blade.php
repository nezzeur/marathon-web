@extends('layout.app')

@section('contenu')
    {{-- CSS Spécifique --}}
    <style>
        /* Animation lente du fond */
        @keyframes float-bg { 0% { transform: scale(1); } 50% { transform: scale(1.02); } 100% { transform: scale(1); } }
        .bg-animate { animation: float-bg 20s ease-in-out infinite; }

        /* Styles des inputs hérités */
        .neon-border-cyan:focus-within { border-color: #2BE7C6; box-shadow: 0 0 15px rgba(43, 231, 198, 0.5); }
        .neon-border-pink:focus-within { border-color: #C2006D; box-shadow: 0 0 15px rgba(194, 0, 109, 0.5); }
    </style>

    {{-- 1. BACKGROUND : Bannière Lumineuse --}}
    <div class="fixed inset-0 z-0 overflow-hidden bg-[#050505]">
        <img
                src="{{ asset('images/bannière.png') }}"
                alt="Synthwave Grid Background"
                class="absolute inset-0 w-full h-full object-cover object-bottom bg-animate"
        >
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-transparent to-black/40"></div>
    </div>

    {{-- 2. CONTENU PRINCIPAL --}}
    <div class="relative z-10 min-h-screen flex flex-col justify-center items-center px-4 py-12">

        {{-- Titre principal --}}
        <div class="mb-10 text-center">
            <h1 class="text-5xl md:text-7xl font-black italic uppercase tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-[#2BE7C6] via-[#2B5BBB] to-[#C2006D]"
                style="filter: drop-shadow(0 0 10px rgba(43, 91, 187, 0.5));">
                MARATHON
            </h1>
            <p class="text-[#2BE7C6] font-bold tracking-[0.5em] text-sm md:text-base mt-2 uppercase drop-shadow-[0_0_5px_rgba(43,231,198,0.8)]">
                System Access
            </p>
        </div>

        {{-- Conteneur style "Carte Article" --}}
        <div class="w-full max-w-md group relative">

            {{-- Le cadre principal avec le style Article (Bleu/System) --}}
            <div class="relative bg-black/60 backdrop-blur-md rounded-xl border border-[#2858bb]/30 p-1 hover:border-[#2858bb] hover:shadow-[0_0_25px_rgba(40,88,187,0.4)] transition-all duration-300">

                {{-- Contenu du formulaire --}}
                <div class="bg-black/40 rounded-lg overflow-hidden">

                    {{-- Header du cadre --}}
                    <div class="pt-8 pb-4 text-center border-b border-[#2858bb]/30" style="background: linear-gradient(180deg, rgba(40, 88, 187, 0.1) 0%, transparent 100%);">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-[#2858bb]/40 to-[#bed2ff]/10 border border-[#bed2ff]/50 mb-4 shadow-[0_0_15px_rgba(40,88,187,0.3)]">
                            <span class="text-3xl">🔐</span>
                        </div>
                        <h3 class="text-2xl font-black font-orbitron text-white uppercase tracking-widest drop-shadow-md">Connexion</h3>
                    </div>

                    {{-- Formulaire --}}
                    <form action="{{ route('login') }}" method="post" class="p-8 space-y-6">
                        @csrf

                        <div class="group/input neon-border-cyan rounded-xl transition-all duration-300">
                            <label for="email" class="block text-[10px] font-bold text-[#2BE7C6] mb-1 uppercase tracking-widest pl-1">Identifiant</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#2B5BBB] group-focus-within/input:text-[#2BE7C6] transition-colors">@</span>
                                </div>
                                <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        required
                                        placeholder="user@marathon.web"
                                        class="w-full pl-10 pr-4 py-3 bg-black/70 border border-[#2BE7C6]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-black transition-all font-mono text-sm"
                                        value="{{ old('email') }}"
                                />
                            </div>
                            @error('email')
                            <p class="text-[#C2006D] text-xs mt-2 font-bold animate-pulse pl-1">⚠️ {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="group/input neon-border-pink rounded-xl transition-all duration-300">
                            <label for="password" class="block text-[10px] font-bold text-[#C2006D] mb-1 uppercase tracking-widest pl-1">Mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#2B5BBB] group-focus-within/input:text-[#C2006D] transition-colors">#</span>
                                </div>
                                <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        required
                                        placeholder="••••••••••••"
                                        class="w-full pl-10 pr-4 py-3 bg-black/70 border border-[#C2006D]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-black transition-all font-mono text-sm"
                                />
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-2 pl-1">
                            <label class="flex items-center space-x-3 cursor-pointer group/check">
                                <div class="relative">
                                    <input type="checkbox" name="remember" class="peer sr-only">
                                    <div class="w-5 h-5 border border-[#2B5BBB] rounded bg-black/50 peer-checked:bg-[#2BE7C6] peer-checked:border-[#2BE7C6] peer-checked:shadow-[0_0_10px_rgba(43,231,198,0.6)] transition-all"></div>
                                    <div class="absolute inset-0 flex items-center justify-center text-black font-bold opacity-0 peer-checked:opacity-100 transform scale-50 peer-checked:scale-100 transition-all text-xs">✓</div>
                                </div>
                                <span class="text-xs font-bold text-gray-400 group-hover/check:text-[#2BE7C6] transition-colors uppercase">Rester connecté</span>
                            </label>
                        </div>

                        <button type="submit" class="relative w-full group/btn overflow-hidden rounded-xl p-[2px] focus:outline-none mt-4 shadow-[0_4px_20px_rgba(40,88,187,0.3)]">
                            <span class="absolute inset-0 bg-gradient-to-r from-[#2BE7C6] via-[#2B5BBB] to-[#C2006D] group-hover/btn:from-[#C2006D] group-hover/btn:to-[#2BE7C6] transition-all duration-500"></span>
                            <span class="relative flex items-center justify-center w-full py-4 bg-black rounded-[10px] group-hover/btn:bg-opacity-0 transition-all duration-200">
                                <span class="font-black text-white uppercase tracking-widest text-sm md:text-base group-hover/btn:scale-105 transition-transform font-orbitron">
                                    INITIALISER LA SESSION
                                </span>
                            </span>
                        </button>
                    </form>

                    {{-- Footer du cadre --}}
                    <div class="px-8 py-4 bg-black/40 border-t border-[#2858bb]/20 text-center">
                        <p class="text-gray-400 text-xs font-medium">
                            Nouvel utilisateur ?
                            <a href="{{ route('register') }}" class="text-[#bed2ff] hover:text-[#2BE7C6] font-bold uppercase transition-colors ml-1 hover:underline decoration-2 underline-offset-4">
                                S'inscrire >
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="absolute -top-1 -left-1 w-5 h-5 border-t-2 border-l-2 border-[#bed2ff] opacity-60 group-hover:opacity-100 transition-opacity duration-300 shadow-[0_0_10px_#bed2ff]"></div>
            <div class="absolute -bottom-1 -right-1 w-5 h-5 border-b-2 border-r-2 border-[#bed2ff] opacity-60 group-hover:opacity-100 transition-opacity duration-300 shadow-[0_0_10px_#bed2ff]"></div>
        </div>
    </div>
@endsection