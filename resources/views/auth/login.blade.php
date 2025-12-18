@extends('layout.app')

@section('contenu')
    {{-- CSS Spécifique pour l'ambiance Synthwave --}}
    <style>
        .neon-text-shadow {
            text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 20px #ec4899, 0 0 30px #ec4899, 0 0 40px #ec4899;
        }
        .neon-border:focus-within {
            box-shadow: 0 0 10px rgba(43, 231, 198, 0.6), inset 0 0 5px rgba(43, 231, 198, 0.2);
            border-color: #2be7c6;
        }
        /* Animation lente de la bannière pour un effet de profondeur */
        @keyframes float-bg {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        .bg-animate {
            animation: float-bg 20s ease-in-out infinite;
        }
    </style>

    {{-- 1. BACKGROUND : La Bannière Synthwave --}}
    <div class="fixed inset-0 z-0 overflow-hidden bg-black">
        {{-- L'image couvre tout l'écran, centrée en bas pour garder la grille au sol --}}
        <img
                src="{{ asset('images/bannière.png') }}"
                alt="Synthwave Grid Background"
                class="absolute inset-0 w-full h-full object-cover object-bottom opacity-90 bg-animate"
        >

        {{-- Overlay sombre pour que le formulaire reste lisible par dessus l'image --}}
        <div class="absolute inset-0 bg-black/30 bg-gradient-to-t from-black/80 via-transparent to-black/60"></div>
    </div>

    {{-- 2. CONTENU PRINCIPAL --}}
    <div class="relative z-10 min-h-screen flex flex-col justify-center items-center px-4 py-12">

        {{-- Titre Glitch / Logo au dessus du form --}}
        <div class="mb-8 text-center">
            <h1 class="text-5xl md:text-7xl font-black italic uppercase tracking-tighter text-transparent bg-clip-text bg-gradient-to-b from-cyan-300 via-white to-purple-500 drop-shadow-[0_0_15px_rgba(168,85,247,0.5)]">
                MARATHON
            </h1>
            <p class="text-cyan-400 font-bold tracking-[0.5em] text-sm md:text-base mt-2 uppercase drop-shadow-[0_0_5px_rgba(34,211,238,0.8)]">
                System Access
            </p>
        </div>

        {{-- Conteneur du Formulaire (Centré) --}}
        <div class="w-full max-w-md">
            <div class="relative group">

                {{-- Lueur néon animée derrière le cadre --}}
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 via-purple-500 to-pink-500 rounded-2xl blur opacity-40 group-hover:opacity-75 transition duration-1000 animate-pulse"></div>

                {{-- Le cadre Glassmorphism --}}
                <div class="relative bg-[#050505]/80 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden">

                    {{-- Header du cadre --}}
                    <div class="pt-8 pb-4 text-center border-b border-white/5">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-purple-900/50 to-pink-900/50 border border-white/10 mb-4 shadow-[0_0_15px_rgba(236,72,153,0.3)]">
                            <span class="text-3xl">🔐</span>
                        </div>
                        <h3 class="text-2xl font-black text-white uppercase tracking-widest">Connexion</h3>
                    </div>

                    {{-- Formulaire --}}
                    <form action="{{ route('login') }}" method="post" class="p-8 space-y-6">
                        @csrf

                        <div class="group neon-border rounded-xl transition-all duration-300">
                            <label for="email" class="block text-[10px] font-bold text-cyan-400 mb-1 uppercase tracking-widest pl-1">Identifiant</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 group-focus-within:text-cyan-400 transition-colors">@</span>
                                </div>
                                <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        required
                                        placeholder="user@synth.net"
                                        class="w-full pl-10 pr-4 py-3 bg-black/60 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:bg-black/90 transition-all font-mono text-sm"
                                        value="{{ old('email') }}"
                                />
                            </div>
                            @error('email')
                            <p class="text-pink-500 text-xs mt-2 font-bold animate-pulse">⚠️ {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="group neon-border rounded-xl transition-all duration-300">
                            <label for="password" class="block text-[10px] font-bold text-pink-500 mb-1 uppercase tracking-widest pl-1">Mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 group-focus-within:text-pink-500 transition-colors">#</span>
                                </div>
                                <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        required
                                        placeholder="••••••••••••"
                                        class="w-full pl-10 pr-4 py-3 bg-black/60 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:bg-black/90 transition-all font-mono text-sm"
                                />
                            </div>
                            @error('password')
                            <p class="text-pink-500 text-xs mt-2 font-bold animate-pulse">⚠️ {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mt-2">
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" name="remember" class="peer sr-only">
                                    {{-- Checkbox personnalisée --}}
                                    <div class="w-5 h-5 border border-gray-600 rounded bg-black/50 peer-checked:bg-cyan-500 peer-checked:border-cyan-500 peer-checked:shadow-[0_0_10px_rgba(6,182,212,0.6)] transition-all"></div>
                                    <div class="absolute inset-0 flex items-center justify-center text-black font-bold opacity-0 peer-checked:opacity-100 transform scale-50 peer-checked:scale-100 transition-all text-xs">
                                        ✓
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-gray-400 group-hover:text-cyan-400 transition-colors uppercase">Rester connecté</span>
                            </label>
                        </div>

                        <button
                                type="submit"
                                class="relative w-full group overflow-hidden rounded-xl p-[2px] focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 focus:ring-offset-[#0a0a0a] mt-4"
                        >
                            {{-- Bordure animée du bouton --}}
                            <span class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 group-hover:from-pink-600 group-hover:via-purple-600 group-hover:to-blue-600 transition-all duration-500"></span>

                            {{-- Intérieur du bouton --}}
                            <span class="relative flex items-center justify-center w-full py-4 bg-[#0a0a0a] rounded-[10px] group-hover:bg-opacity-0 transition-all duration-200">
                                <span class="font-black text-white uppercase tracking-widest text-sm md:text-base group-hover:text-shadow transition-transform group-hover:scale-105">
                                    Initialiser la session
                                </span>
                            </span>
                        </button>

                        @if($errors->any())
                            <div class="mt-4 p-3 rounded bg-red-500/10 border border-red-500/30">
                                <p class="text-red-400 text-xs font-mono text-center">🚫 ACCÈS REFUSÉ : Données invalides</p>
                            </div>
                        @endif

                    </form>

                    {{-- Footer du cadre --}}
                    <div class="px-8 py-4 bg-white/5 border-t border-white/5 text-center">
                        <p class="text-gray-400 text-xs font-medium">
                            Nouvel utilisateur ?
                            <a href="{{ route('register') }}" class="text-cyan-400 hover:text-pink-500 font-bold uppercase transition-colors ml-1 hover:underline decoration-2 underline-offset-4">
                                S'inscrire >
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection