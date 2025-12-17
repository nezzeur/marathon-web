@extends('layout.app')

@section('contenu')
    <div class="profile-container">
        <!-- En-tête du profil -->
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
                <p class="email">{{ $user->email }}</p>
                <div class="stats">
                    <div class="stat">
                        <strong>{{ $user->articles->count() }}</strong>
                        <span>Articles</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $user->suivis->count() }}</strong>
                        <span>Suivis</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $user->suiveurs->count() }}</strong>
                        <span>Suiveurs</span>
                    </div>
                </div>
                <a href="{{ route('user.edit') }}" class="btn btn-primary">Modifier mon profil</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Contenu : Onglets -->
        <div class="profile-tabs">
            <div class="tabs-nav">
                <button class="tab-btn active" data-tab="articles">Mes articles</button>
                <button class="tab-btn" data-tab="brouillons">Brouillons</button>
                <button class="tab-btn" data-tab="aimes">Articles aimés</button>
                <button class="tab-btn" data-tab="suivis">Mes suivis</button>
            </div>

            <!-- Onglet : Mes articles publiés -->
            <div class="tab-content active" id="tab-articles">
                <h2>Mes articles publiés</h2>
                @if($articlesPublies->count() > 0)
                    <div class="articles-list">
                        @foreach($articlesPublies as $article)
                            <div class="article-item">
                                <div class="article-header">
                                    <h3><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h3>
                                    <span class="badge badge-published">Publié</span>
                                </div>
                                <p class="article-date">{{ $article->created_at->format('d/m/Y à H:i') }}</p>
                                <p class="article-excerpt">{{ Illuminate\Support\Str::limit(strip_tags($article->description ?? ''), 200) }}</p>
                                <div class="article-actions">
                                    <a href="{{ route('articles.show', $article) }}" class="btn-small">Voir</a>
                                    <a href="#" class="btn-small btn-edit">Éditer</a>
                                    <a href="#" class="btn-small btn-delete">Supprimer</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="empty-state">Aucun article publié pour le moment.</p>
                @endif
            </div>

            <!-- Onglet : Brouillons -->
            <div class="tab-content" id="tab-brouillons">
                <h2>Mes brouillons</h2>
                @if($articlesBrouillons->count() > 0)
                    <div class="articles-list">
                        @foreach($articlesBrouillons as $article)
                            <div class="article-item">
                                <div class="article-header">
                                    <h3>{{ $article->title }}</h3>
                                    <span class="badge badge-draft">Brouillon</span>
                                </div>
                                <p class="article-date">Créé le {{ $article->created_at->format('d/m/Y à H:i') }}</p>
                                <p class="article-excerpt">{{ Illuminate\Support\Str::limit(strip_tags($article->description ?? ''), 200) }}</p>
                                <div class="article-actions">
                                    <a href="#" class="btn-small btn-edit">Éditer</a>
                                    <a href="#" class="btn-small btn-delete">Supprimer</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="empty-state">Aucun brouillon pour le moment.</p>
                @endif
            </div>

            <!-- Onglet : Articles aimés -->
            <div class="tab-content" id="tab-aimes">
                <h2>Articles que j'ai aimés</h2>
                @if($articlesAimes->count() > 0)
                    <div class="articles-grid">
                        @foreach($articlesAimes as $article)
                            <div class="article-card">
                                <h3><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h3>
                                <p class="author">Par <strong>{{ $article->editeur->name ?? 'Inconnu' }}</strong></p>
                                <p class="date">{{ $article->created_at->format('d/m/Y') }}</p>
                                <p class="excerpt">{{ Illuminate\Support\Str::limit(strip_tags($article->description ?? ''), 150) }}</p>
                                <a href="{{ route('articles.show', $article) }}" class="btn-read-more">Lire la suite</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="empty-state">Vous n'avez encore aimé aucun article.</p>
                @endif
            </div>

            <!-- Onglet : Mes suivis -->
            <div class="tab-content" id="tab-suivis">
                <h2>Personnes que je suis</h2>
                @if($user->suivis->count() > 0)
                    <div class="users-list">
                        @foreach($user->suivis as $suivi)
                            <div class="user-item">
                                <div class="user-avatar">
                                    @if($suivi->avatar)
                                        <img src="{{ asset('storage/' . $suivi->avatar) }}" alt="Avatar">
                                    @else
                                        <div class="avatar-placeholder-small">{{ strtoupper(substr($suivi->name, 0, 1)) }}</div>
                                    @endif
                                </div>
                                <div class="user-info">
                                    <h3><a href="{{ route('user.profile', $suivi->id) }}">{{ $suivi->name }}</a></h3>
                                    <p class="articles-count">{{ $suivi->articles->count() }} articles</p>
                                </div>
                                <a href="{{ route('user.profile', $suivi->id) }}" class="btn-small">Voir profil</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="empty-state">Vous ne suivez personne pour le moment.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Retirer la classe active de tous les boutons et contenus
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                // Ajouter la classe active au bouton cliqué
                this.classList.add('active');

                // Afficher le contenu correspondant
                const tabId = 'tab-' + this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>

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
            margin: 0 0 5px 0;
            font-size: 2em;
        }

        .profile-info .email {
            color: #666;
            margin: 0 0 20px 0;
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

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #0066cc;
            color: white;
        }

        .btn-primary:hover {
            background: #0052a3;
        }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .profile-tabs {
            margin-top: 30px;
        }

        .tabs-nav {
            display: flex;
            gap: 10px;
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
        }

        .tab-btn {
            padding: 12px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
            color: #666;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            color: #0066cc;
        }

        .tab-btn.active {
            color: #0066cc;
            border-bottom-color: #0066cc;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .tab-content h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .articles-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .article-item {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 20px;
            transition: box-shadow 0.2s;
        }

        .article-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .article-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .article-header h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .article-header h3 a {
            color: #0066cc;
            text-decoration: none;
        }

        .article-header h3 a:hover {
            text-decoration: underline;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .badge-published {
            background: #d4edda;
            color: #155724;
        }

        .badge-draft {
            background: #fff3cd;
            color: #856404;
        }

        .article-date {
            color: #999;
            font-size: 0.9em;
            margin: 5px 0;
        }

        .article-excerpt {
            margin: 10px 0;
            line-height: 1.5;
            color: #333;
        }

        .article-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-small {
            display: inline-block;
            padding: 6px 12px;
            background: #0066cc;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9em;
            transition: background 0.2s;
        }

        .btn-small:hover {
            background: #0052a3;
        }

        .btn-edit {
            background: #28a745;
        }

        .btn-edit:hover {
            background: #218838;
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
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

        .article-card .author,
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

        .users-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .user-item {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            transition: box-shadow 0.2s;
        }

        .user-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-avatar img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .avatar-placeholder-small {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #0066cc;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .user-info {
            flex: 1;
        }

        .user-info h3 {
            margin: 0 0 5px 0;
        }

        .user-info h3 a {
            color: #0066cc;
            text-decoration: none;
        }

        .user-info h3 a:hover {
            text-decoration: underline;
        }

        .articles-count {
            color: #999;
            font-size: 0.9em;
            margin: 0;
        }

        .empty-state {
            padding: 30px;
            text-align: center;
            color: #999;
            background: #f9f9f9;
            border-radius: 6px;
        }
    </style>
@endsection

