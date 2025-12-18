@extends("layout.app")

@section('contenu')
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
    <div class="relative z-10 min-h-screen flex flex-col justify-center items-center px-4 py-8">

        <div class="mb-6 text-center">
            <h1 class="text-5xl md:text-6xl font-black italic uppercase tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-[#2BE7C6] via-[#2B5BBB] to-[#C2006D]"
                style="filter: drop-shadow(0 0 10px rgba(43, 91, 187, 0.5));">
                NEW CHALLENGER
            </h1>
            <p class="text-[#2BE7C6] font-bold tracking-[0.3em] text-sm mt-1 uppercase drop-shadow-[0_0_5px_rgba(43,231,198,0.8)]">
                Join the Grid
            </p>
        </div>

        <div class="w-full max-w-lg">
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-[#2BE7C6] via-[#2B5BBB] to-[#C2006D] rounded-2xl blur-md opacity-50 group-hover:opacity-80 transition duration-1000 animate-pulse"></div>

                <div class="relative bg-black/90 backdrop-blur-xl rounded-2xl border border-[#2BE7C6]/30 shadow-2xl overflow-hidden">

                    <div class="pt-6 pb-2 text-center border-b border-[#2BE7C6]/20" style="background: linear-gradient(180deg, rgba(43, 91, 187, 0.2) 0%, transparent 100%);">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-[#2B5BBB]/40 to-[#C2006D]/40 border border-[#2BE7C6]/50 mb-3 shadow-[0_0_15px_rgba(43,231,198,0.3)]">
                            <span class="text-2xl">📝</span>
                        </div>
                        <h3 class="text-xl font-black text-white uppercase tracking-widest">Création de profil</h3>
                    </div>

                    <form action="{{ route('register') }}" method="post" class="p-6 space-y-5">
                        @csrf

                        <div class="group neon-border-cyan rounded-xl transition-all duration-300">
                            <label for="name" class="block text-[10px] font-bold text-[#2BE7C6] mb-1 uppercase tracking-widest pl-1">Pseudo</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#2B5BBB] group-focus-within:text-[#2BE7C6] transition-colors">👤</span>
                                </div>
                                <input type="text" name="name" id="name" required placeholder="RetroGamer88" class="w-full pl-10 pr-4 py-3 bg-black/70 border border-[#2BE7C6]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-black transition-all font-mono text-sm" value="{{ old('name') }}"/>
                            </div>
                            @error('name') <p class="text-[#C2006D] text-xs mt-1 font-bold pl-1">⚠️ {{ $message }}</p> @enderror
                        </div>

                        <div class="group neon-border-blue rounded-xl transition-all duration-300">
                            <label for="email" class="block text-[10px] font-bold text-[#2B5BBB] mb-1 uppercase tracking-widest pl-1">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#2B5BBB] group-focus-within:text-[#2B5BBB] transition-colors">@</span>
                                </div>
                                <input type="email" name="email" id="email" required placeholder="player@one.com" class="w-full pl-10 pr-4 py-3 bg-black/70 border border-[#2B5BBB]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-black transition-all font-mono text-sm" value="{{ old('email') }}"/>
                            </div>
                            @error('email') <p class="text-[#C2006D] text-xs mt-1 font-bold pl-1">⚠️ {{ $message }}</p> @enderror
                        </div>

                        <div class="group neon-border-pink rounded-xl transition-all duration-300">
                            <label for="password" class="block text-[10px] font-bold text-[#C2006D] mb-1 uppercase tracking-widest pl-1">Mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#2B5BBB] group-focus-within:text-[#C2006D] transition-colors">🔑</span>
                                </div>
                                <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-3 bg-black/70 border border-[#C2006D]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-black transition-all font-mono text-sm"/>
                            </div>
                            @error('password') <p class="text-[#C2006D] text-xs mt-1 font-bold pl-1">⚠️ {{ $message }}</p> @enderror
                        </div>

                        <div class="group neon-border-pink rounded-xl transition-all duration-300">
                            <label for="password_confirmation" class="block text-[10px] font-bold text-[#C2006D] mb-1 uppercase tracking-widest pl-1">Confirmer</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#2B5BBB] group-focus-within:text-[#C2006D] transition-colors">🔐</span>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" class="w-full pl-10 pr-4 py-3 bg-black/70 border border-[#C2006D]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-black transition-all font-mono text-sm"/>
                            </div>
                        </div>

                        <button type="submit" class="relative w-full group overflow-hidden rounded-xl p-[2px] focus:outline-none mt-6 shadow-[0_4px_20px_rgba(43,91,187,0.2)]">
                            <span class="absolute inset-0 bg-gradient-to-r from-[#2BE7C6] via-[#2B5BBB] to-[#C2006D] group-hover:from-[#C2006D] group-hover:to-[#2BE7C6] transition-all duration-500"></span>
                            <span class="relative flex items-center justify-center w-full py-4 bg-black rounded-[10px] group-hover:bg-opacity-0 transition-all duration-200">
                                <span class="font-black text-white uppercase tracking-widest text-sm md:text-base group-hover:scale-105 transition-transform">
                                    PRESS START TO REGISTER
                                </span>
                            </span>
                        </button>
                    </form>

                    <div class="px-8 py-4 bg-black/40 border-t border-[#2BE7C6]/20 text-center">
                        <p class="text-gray-400 text-xs font-medium">
                            Déjà membre du club ?
                            <a href="{{ route('login') }}" class="text-[#2BE7C6] hover:text-[#C2006D] font-bold uppercase transition-colors ml-1 hover:underline decoration-2 underline-offset-4">
                                Se connecter >
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection