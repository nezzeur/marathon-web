<nav>
    <a href="{{route('accueil')}}">Accueil</a>
    <a href="{{route('test-vite')}}">Test Vite</a>
    <a href="#">Contact</a>

    @auth
        {{Auth::user()->name}}
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

