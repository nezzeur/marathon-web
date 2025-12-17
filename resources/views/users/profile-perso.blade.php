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
@endsection

