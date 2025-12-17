<nav>
    <a href="{{route('accueil')}}">Accueil</a>
    <a href="{{route('test-vite')}}">Test Vite</a>
    <a href="{{route('contact')}}">Contact</a>

    @auth
        <a href="{{ route('articles.create') }}">Créer un article</a>
    @endauth

    @auth
        <a href="{{ route('user.me') }}" style="font-weight: bold;">
            {{ Auth::user()->name }}
        </a>

        <a href="{{route("logout")}}"
           onclick="document.getElementById('logout').submit(); return false;">Logout</a>
        <form id="logout" action="{{route("logout")}}" method="post">
            @csrf
        </form>
    @else
        <a href="{{route("login")}}">Login</a>
        <a href="{{route("register")}}">Register</a>
    @endauth
</nav>