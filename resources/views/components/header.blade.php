@props(['class' => ''])

<style>
    @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap');

    :root {
        --font-vt323: "VT323", monospace;
        --font-press-start: "Press Start 2P", cursive;
    }
</style>

<nav class="bg-background/90 backdrop-blur-md border-b border-border sticky top-0 z-50 shadow-[0_0_20px_rgba(0,255,255,0.15)]">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between gap-8">

        <!-- Logo Hyper Vyper Style avec effet Chrome -->
        <a href="{{ route('accueil') }}" class="flex-shrink-0 group">
            <img src="{{ asset('images/logo.png') }}" alt="OKARINA" class="h-12 object-contain hover:opacity-80 transition-opacity duration-300">
        </a>

        <!-- Liens centraux -->
        <div class="hidden md:flex items-center gap-8 flex-1 justify-center">
            <a href="{{ route('accueil') }}" class="font-sans text-2xl uppercase text-white hover:text-primary hover:animate-glow-pulse transition-colors">
                <span class="mr-1 opacity-50">[</span>Accueil<span class="ml-1 opacity-50">]</span>
            </a>
            <a href="{{ route('contact') }}" class="font-sans text-2xl uppercase text-white hover:text-secondary hover:animate-glow-pulse transition-colors">
                <span class="mr-1 opacity-50">[</span>Contact<span class="ml-1 opacity-50">]</span>
            </a>

            @auth
                <a href="{{ route('articles.create') }}" class="font-sans text-2xl uppercase text-white hover:text-primary hover:animate-glow-pulse transition-colors">
                    <span class="mr-1 opacity-50">[</span>Publier<span class="ml-1 opacity-50">]</span>
                </a>
            @endauth
        </div>

        <!-- Authentification à droite -->
        <div class="flex items-center gap-4">
            @auth
                <div class="flex items-center gap-4">
                    <a href="{{ route('user.me') }}" class="font-sans text-xl px-4 py-2 border border-secondary text-secondary bg-card hover:bg-secondary hover:text-secondary-foreground transition-all uppercase truncate max-w-[150px]">
                        P1: {{ Auth::user()->name }}
                    </a>

                    <form id="logout" action="{{ route('logout') }}" method="post" style="display: inline;">
                        @csrf
                        <button type="submit" class="font-mono text-xs px-3 py-3 bg-destructive text-destructive-foreground hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1">
                            QUITTER
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="hidden md:inline-block font-mono text-xs px-4 py-3 bg-primary text-primary-foreground hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1">
                    START
                </a>

            @endauth
        </div>
    </div>
</nav>
