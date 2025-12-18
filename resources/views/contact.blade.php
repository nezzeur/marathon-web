@extends('layout.app')

@section('contenu')
    <div class="max-w-6xl mx-auto px-5 py-12 relative z-10">

        {{-- Main Container --}}
        <div class="bg-card/80 backdrop-blur-md border border-primary shadow-[0_0_50px_rgba(0,255,255,0.15)] relative overflow-hidden group rounded-xl">

            {{-- Decorative top bar --}}
            <div class="h-2 bg-gradient-to-r from-primary via-secondary to-primary animate-shine bg-[length:200%_100%]"></div>

            {{-- Header Section --}}
            <div class="p-8 text-center border-b border-border bg-black/40">
                <h1 class="text-4xl md:text-5xl font-black italic chrome-text mb-4 transform -skew-x-6">
                    📞 COMMS_LINK
                </h1>
                <p class="font-mono text-primary text-sm md:text-base animate-pulse tracking-widest">
                    <span class="text-muted-foreground opacity-50">[</span> ESTABLISHING CONNECTION... <span class="text-muted-foreground opacity-50">]</span>
                </p>
            </div>

            <div class="p-8 space-y-12">

                {{-- Section: Dev Team / Creators (8 Members) --}}
                <div class="relative p-6 border-2 border-dashed border-secondary/50 rounded-lg bg-background/50">
                    <!-- Label "Insert Coin" style -->
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-card px-4 py-1 border border-secondary text-secondary font-mono text-xs uppercase shadow-[0_0_10px_rgba(255,106,213,0.5)] whitespace-nowrap">
                        Select Your Character (8/8)
                    </div>

                    <h2 class="text-2xl font-mono text-white text-center mb-8 uppercase text-shadow-neon mt-4">
                        👾 The Dev Squad
                    </h2>

                    <!-- Grille 4 colonnes pour 8 membres -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @php
                            $names = ['Néo Huyghe', 'Luka Blanchard', 'Quentin Baillet', 'Noa Peru', 'Kenza Salmi', 'Lola Delannoy', 'Anélie Coustenoble', 'Erwan Caudron'];
                            $roles = ['Cyber-Mage', 'Net-Runner', 'Code-Ninja', 'Sys-Admin', 'Data-Broker', 'Glitch-Hunter', 'Pixel-Artist', 'Bot-Master'];
                            $colors = ['text-primary', 'text-secondary', 'text-accent', 'text-green-400', 'text-orange-400', 'text-red-500', 'text-purple-400', 'text-white'];
                            $icons = ['🧙‍♂️', '🥷', '👩‍💻', '🤖', '📡', '👾', '🎨', '🕹️'];
                        @endphp

                        @foreach(range(1, 8) as $index)
                            <div class="flex flex-col items-center group/char cursor-pointer hover:-translate-y-2 transition-transform duration-300">
                                <div class="w-24 h-24 md:w-32 md:h-32 border-2 border-muted group-hover/char:border-white bg-black flex items-center justify-center transition-all duration-300 shadow-[inset_0_0_20px_rgba(0,0,0,1)] group-hover/char:shadow-[0_0_20px_rgba(255,255,255,0.5)] relative overflow-hidden rounded-sm">

                                    <!-- Scanline effect inside avatar -->
                                    <div class="animate-scanline absolute inset-0 z-20 bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.25)_50%),linear-gradient(90deg,rgba(255,0,0,0.06),rgba(0,255,0,0.02),rgba(0,0,255,0.06))] pointer-events-none bg-[length:100%_4px]"></div>

                                    {{--
                                        POUR VOS VRAIES IMAGES :
                                        Utilisez la ligne ci-dessous et commentez celle de DiceBear.
                                        Nommez vos images member-1.jpg, member-2.jpg, etc.
                                    --}}
                                    <img src="{{ asset('images/team/member-' . $index . '.webp') }}" alt="Member {{ $index }}" class="w-full h-full object-cover filter grayscale group-hover/char:grayscale-0 transition-all duration-300">
                                </div>

                                <!-- Name & Role -->
                                <div class="mt-3 text-center">
                                    <p class="font-mono {{ $colors[$index-1] }} text-xs md:text-sm font-bold opacity-70 group-hover/char:opacity-100 group-hover/char:text-glow">
                                        {{ $names[$index-1] }}
                                    </p>
                                    <p class="text-[10px] uppercase text-muted-foreground tracking-widest hidden md:block">
                                        {{ $roles[$index-1] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Contact Grid (HUD Panels) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Email --}}
                    <div class="relative bg-card border border-primary/30 p-6 text-center group hover:bg-primary/5 hover:border-primary transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">📧</div>
                        <h3 class="font-mono text-lg text-primary mb-2 uppercase">Transmitter</h3>
                        <p class="font-sans text-lg text-foreground break-all hover:text-primary transition-colors">contact@marathon.local</p>
                    </div>

                    {{-- Address --}}
                    <div class="relative bg-card border border-secondary/30 p-6 text-center group hover:bg-secondary/5 hover:border-secondary transition-all duration-300 hover:-translate-y-1">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">📍</div>
                        <h3 class="font-mono text-lg text-secondary mb-2 uppercase">Base Coordinates</h3>
                        <p class="font-sans text-lg text-foreground">IUT de Lens, FR</p>
                    </div>

                    {{-- Hours --}}
                    <div class="relative bg-card border border-accent/30 p-6 text-center group hover:bg-accent/5 hover:border-accent transition-all duration-300 hover:-translate-y-1">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">⏰</div>
                        <h3 class="font-mono text-lg text-accent mb-2 uppercase">Server Uptime</h3>
                        <p class="font-sans text-lg text-foreground">Mon - Fri <br> 09:00 - 17:00</p>
                    </div>
                </div>

            </div>

            {{-- Decorative footer within card --}}
            <div class="h-1 bg-gradient-to-r from-transparent via-border to-transparent opacity-50"></div>
            <div class="p-2 text-center">
                <p class="text-[10px] font-mono text-muted-foreground uppercase">End of transmission // Signal lost</p>
            </div>
        </div>
    </div>
@endsection
