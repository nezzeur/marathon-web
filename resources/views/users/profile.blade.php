@extends('layout.app')

@section('contenu')
    <div class="profile-container">
        <!-- En-tête du profil public -->
        <div class="profile-header">
            <div class="profile-avatar">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar de {{ $user->name }}" class="avatar-large">
                @else
                    <div class="avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
            </div>
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <div class="stats">
                    <div class="stat">
                        <strong>{{ $user->articles->count() }}</strong>
                        <span>Articles</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $user->suiveurs->count() }}</strong>
                        <span>Suiveurs</span>
                    </div>
                </div>
                <div class="profile-actions">
                    @auth
                        @if(Auth::id() !== $user->id)
                            <a href="#" class="btn btn-follow">Suivre</a>
                        @endif
                    @else
                        <p><a href="{{ route('login') }}">Se connecter</a> pour suivre cet utilisateur.</p>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Articles publiés -->
        <div class="profile-section">
            <h2>Articles publiés</h2>
            @if($user->articles->count() > 0)
                <div class="articles-grid">
                    @foreach($user->articles as $article)
                        <div class="article-card">
                            <h3><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h3>
                            <p class="date">{{ $article->created_at->format('d/m/Y') }}</p>
                            <p class="excerpt">{{ Illuminate\Support\Str::limit(strip_tags($article->description ?? ''), 150) }}</p>
                            <a href="{{ route('articles.show', $article) }}" class="btn-read-more">Lire la suite</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="empty-state">Aucun article publié.</p>
            @endif
        </div>

        <a href="{{ route('accueil') }}" class="btn-back">← Retour</a>
    </div>

@endsection

