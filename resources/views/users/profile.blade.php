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

    <style>
        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-header {
            display: flex;
            gap: 30px;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 30px;
            align-items: flex-start;
        }

        .profile-avatar {
            flex-shrink: 0;
        }

        .avatar-large {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0066cc;
        }

        .avatar-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #0066cc;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3em;
            font-weight: bold;
        }

        .profile-info {
            flex: 1;
        }

        .profile-info h1 {
            margin: 0 0 20px 0;
            font-size: 2em;
        }

        .stats {
            display: flex;
            gap: 30px;
            margin: 20px 0;
        }

        .stat {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat strong {
            font-size: 1.5em;
            color: #0066cc;
        }

        .stat span {
            font-size: 0.9em;
            color: #666;
        }

        .profile-actions {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn-follow {
            background: #0066cc;
            color: white;
        }

        .btn-follow:hover {
            background: #0052a3;
        }

        .profile-section {
            margin: 40px 0;
        }

        .profile-section h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .article-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background: #f9f9f9;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .article-card h3 {
            margin: 0 0 10px 0;
            font-size: 1.1em;
        }

        .article-card h3 a {
            color: #0066cc;
            text-decoration: none;
        }

        .article-card h3 a:hover {
            text-decoration: underline;
        }

        .article-card .date {
            font-size: 0.9em;
            color: #666;
            margin: 5px 0;
        }

        .article-card .excerpt {
            margin: 10px 0;
            line-height: 1.5;
        }

        .btn-read-more {
            display: inline-block;
            background: #0066cc;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn-read-more:hover {
            background: #0052a3;
        }

        .empty-state {
            padding: 30px;
            text-align: center;
            color: #999;
            background: #f9f9f9;
            border-radius: 6px;
        }

        .btn-back {
            display: inline-block;
            background: #666;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 20px;
            transition: background 0.2s;
        }

        .btn-back:hover {
            background: #333;
        }
    </style>
@endsection

