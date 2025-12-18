@extends("layout.app")

@section('contenu')

    @php
        $cartridgeColor = '#f72585';
    @endphp

    <style>
        @keyframes float-bg { 0% { transform: scale(1); } 50% { transform: scale(1.02); } 100% { transform: scale(1); } }
        .bg-animate { animation: float-bg 20s ease-in-out infinite; }
        .neon-border-cyan:focus-within { border-color: #2BE7C6; box-shadow: 0 0 15px rgba(43, 231, 198, 0.5); }
        .neon-border-blue:focus-within { border-color: #2B5BBB; box-shadow: 0 0 15px rgba(43, 91, 187, 0.5); }
        .neon-border-pink:focus-within { border-color: #C2006D; box-shadow: 0 0 15px rgba(194, 0, 109, 0.5); }
    </style>

    {{-- 1. BACKGROUND : Bannière Lumineuse --}}
    <div class="fixed inset-0 z-0 overflow-hidden bg-[#050505]">
        <img
                src="{{ asset('images/bannière.png') }}"
                alt="Synthwave Grid Background"
                class="absolute inset-0 w-full h-full object-cover object-bottom bg-animate"
        >
        <div class="absolute inset-0 bg-radial-gradient from-transparent via-transparent to-black/80"></div>
    </div>

    {{-- 2. CONTENU PRINCIPAL --}}
    <div class="relative z-10 min-h-screen flex flex-col justify-center items-center px-4 py-12">
        {{-- Cartouche --}}
        <div class="relative transition-all duration-300 group-hover:drop-shadow-[0_0_25px_{{ $cartridgeColor }}]">
            <div class="relative overflow-hidden"
                 style="background-color: {{ $cartridgeColor }};
                    border-radius: 8px 8px 4px 4px;
                    border: 3px solid #1a1a1a;
                    box-shadow: inset -4px -4px 0 rgba(0,0,0,0.3), inset 4px 4px 0 rgba(255,255,255,0.1);">

                {{-- Grip --}}
                <div class="h-4 bg-black/20 flex items-center justify-center gap-1 px-4">
                    @for($i = 0; $i < 12; $i++)
                        <div class="w-1 h-2 bg-black/30 rounded-sm"></div>
                    @endfor
                </div>

                {{-- Formulaire --}}
                <div class="mx-3 my-4 p-4 relative overflow-hidden bg-[#0f0f23]" style="border: 2px solid #000; border-radius: 2px; box-shadow: inset 0 0 20px rgba(0,0,0,0.5);">
                    <form action="{{ route('login') }}" method="post" class="p-8 space-y-8">
                        @csrf

                        <div class="group neon-border-cyan rounded-xl transition-all duration-300">
                            <label for="name" class="block text-[10px] font-bold text-[#ffffff] mb-1 uppercase tracking-widest pl-1">Pseudo</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#2B5BBB] group-focus-within:text-[#2BE7C6] transition-colors"></span>
                                </div>
                                <input type="text" name="name" id="name" required placeholder="RetroGamer88" class="w-full pl-10 pr-4 py-3 bg-black/70 border border-[#2BE7C6]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-black transition-all font-mono text-sm" value="{{ old('name') }}"/>
                            </div>
                            @error('name') <p class="text-[#C2006D] text-xs mt-1 font-bold pl-1"> {{ $message }}</p> @enderror
                        </div>

                        <div class="group neon-border-blue rounded-xl transition-all duration-300">
                            <label for="email" class="block text-[10px] font-bold text-[#ffffff] mb-1 uppercase tracking-widest pl-1">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#2B5BBB] group-focus-within:text-[#2B5BBB] transition-colors"></span>
                                </div>
                                <input type="email" name="email" id="email" required placeholder="player@one.com" class="w-full pl-10 pr-4 py-3 bg-black/70 border border-[#2B5BBB]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-black transition-all font-mono text-sm" value="{{ old('email') }}"/>
                            </div>
                            @error('email') <p class="text-[#C2006D] text-xs mt-1 font-bold pl-1">️ {{ $message }}</p> @enderror
                        </div>

                        <div class="group neon-border-pink rounded-xl transition-all duration-300">
                            <label for="password" class="block text-[10px] font-bold text-[#ffffff] mb-1 uppercase tracking-widest pl-1">Mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#2B5BBB] group-focus-within:text-[#C2006D] transition-colors"></span>
                                </div>
                                <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-3 bg-black/70 border border-[#C2006D]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-black transition-all font-mono text-sm"/>
                            </div>
                            @error('password') <p class="text-[#C2006D] text-xs mt-1 font-bold pl-1">️ {{ $message }}</p> @enderror
                        </div>

                        <div class="group neon-border-pink rounded-xl transition-all duration-300">
                            <label for="password_confirmation" class="block text-[10px] font-bold text-[#ffffff] mb-1 uppercase tracking-widest pl-1">Confirmer</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#2B5BBB] group-focus-within:text-[#C2006D] transition-colors"></span>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" class="w-full pl-10 pr-4 py-3 bg-black/70 border border-[#C2006D]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-black transition-all font-mono text-sm"/>
                            </div>
                        </div>

                        <button
                                type="submit"
                                class="block mx-auto mt-8 mb-6 font-mono text-xs px-6 py-3 bg-primary text-primary-foreground hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1">
                            S'INSCRIRE
                        </button>

                        {{-- Contraintes de mot de passe --}}
                        <div class="mt-6 p-3 bg-black/30 border border-[#2B5BBB]/20 rounded-lg">
                            <p class="text-[#2BE7C6] text-xs font-bold mb-2 uppercase tracking-wider">
                                ⚡ Exigences de sécurité du mot de passe
                            </p>
                            <ul class="text-gray-300 text-xs space-y-1 pl-4">
                                <li class="flex items-start gap-2">
                                    <span class="text-[#2BE7C6] mt-0.5">•</span>
                                    <span>Minimum 8 caractères de longueur</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#2BE7C6] mt-0.5">•</span>
                                    <span>Au moins une lettre majuscule (A-Z)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#2BE7C6] mt-0.5">•</span>
                                    <span>Au moins une lettre minuscule (a-z)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#2BE7C6] mt-0.5">•</span>
                                    <span>Au moins un chiffre (0-9)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#2BE7C6] mt-0.5">•</span>
                                    <span>Au moins un caractère spécial (!@#$%^&*)</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Footer du cadre --}}
                        <p class="mt-6 text-center text-gray-400 text-xs font-medium">
                            Déjà membre du club ?
                            <a href="{{ route('login') }}"
                               class="text-[#bed2ff] hover:text-[#2BE7C6] font-bold uppercase transition-colors ml-1 hover:underline decoration-2 underline-offset-4">
                                Se connecter >
                            </a>
                        </p>
                    </form>
                </div>
                {{-- Pins --}}
                <div class="h-6 bg-[#1a1a1a] flex items-end justify-center gap-0.5 pb-1 mx-2 mb-2 rounded-b">
                    @for($i = 0; $i < 30; $i++)
                        <div class="w-1 h-3 rounded-t-sm transition-colors duration-200 bg-[#3a3a3a] group-hover:bg-[#ffd60a]"></div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
@endsection