@extends("layout.app")

@section('contenu')
    <div class="profile-container">
        <h1>Profil de {{ $user->name }}</h1>

        <div class="profile-info">
            @if($user->avatar)
                <img src="{{ asset($user->avatar) }}" alt="Avatar de {{ $user->name }}" style="width: 150px; border-radius: 50%;">
            @else
                <img src="{{ asset('storage/images/default-avatar.png') }}" alt="Avatar par défaut" style="width: 150px;">
            @endif

            <p>Membre depuis le : {{ $user->created_at->format('d/m/Y') }}</p>
        </div>

        <h3>Ses activités</h3>
    </div>
@endsection