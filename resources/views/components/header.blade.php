@props(['class' => ''])

<nav {{ $attributes->merge(['class' => '' . $class]) }} class="bg-white border-b-4 shadow-lg" style="border-color: #2BE7C6">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-8">
        <!-- Logo à gauche -->
        <a href="{{ route('accueil') }}" class="flex-shrink-0">
            <img src="{{ asset('images/logo_long.svg') }}" alt="Logo Marathon" class="h-12 w-auto hover:opacity-80 transition-opacity" />
        </a>

        <!-- Liens centraux -->
        <div class="flex items-center gap-6 flex-1 justify-center">
            <a href="{{ route('accueil') }}" class="font-bold transition-colors hover:opacity-80" style="color: #2B5BBB">
                🏠 Accueil
            </a>
            <a href="{{ route('contact') }}" class="font-bold transition-colors hover:opacity-80" style="color: #2B5BBB">
                📞 Contact
            </a>

            @auth
                <a href="{{ route('articles.create') }}" class="font-bold transition-colors hover:opacity-80" style="color: #2BE7C6">
                    ✍️ Créer un article
                </a>
            @endauth
        </div>

        <!-- Authentification à droite -->
        <div class="flex items-center gap-4">
            @auth
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.me') }}" class="font-bold px-3 py-2 rounded-lg transition-opacity hover:opacity-80" style="background-color: #2BE7C6; color: #2B5BBB">
                        👤 {{ Auth::user()->name }}
                    </a>

                    <form id="logout" action="{{ route('logout') }}" method="post" style="display: inline;">
                        @csrf
                        <button type="submit" class="font-bold px-4 py-2 rounded-lg text-white transition-opacity hover:opacity-90" style="background-color: #C2006D">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="font-bold px-4 py-2 rounded-lg text-white transition-opacity hover:opacity-90" style="background-color: #2B5BBB">
                    🔐 Login
                </a>
                <a href="{{ route('register') }}" class="font-bold px-4 py-2 rounded-lg text-white transition-opacity hover:opacity-90" style="background-color: #2BE7C6; color: #2B5BBB">
                    📝 Register
                </a>
            @endauth
        </div>
    </div>
</nav>