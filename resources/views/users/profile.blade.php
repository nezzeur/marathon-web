@extends('layout.app')

@section('contenu')
    <div class="profile-container">
        @auth
            <meta name="csrf-token" content="{{ csrf_token() }}">
        @endauth
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
                        <strong class="followers-count">{{ $user->suiveurs->count() }}</strong>
                        <span>Suiveurs</span>
                    </div>
                </div>
                <div class="profile-actions">
                    @auth
                        @if(Auth::id() !== $user->id)
                            @php
                                $isFollowing = Auth::user()->suivis()->where('suivi_id', $user->id)->exists();
                            @endphp
                            <button class="btn btn-follow-toggle" 
                                    data-user-id="{{ $user->id }}"
                                    data-is-following="{{ $isFollowing ? 'true' : 'false' }}">
                                {{ $isFollowing ? 'Ne plus suivre' : 'Suivre' }}
                            </button>
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

    @auth
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const followButtons = document.querySelectorAll('.btn-follow-toggle');
                
                // Initialiser l'état des boutons au chargement
                followButtons.forEach(button => {
                    const isFollowing = button.getAttribute('data-is-following') === 'true';
                    if (isFollowing) {
                        button.classList.add('following');
                    }
                });
                
                followButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const userId = this.getAttribute('data-user-id');
                        const isFollowing = this.getAttribute('data-is-following') === 'true';
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        fetch(`/profile/${userId}/toggle-follow`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                _method: 'POST'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Mettre à jour le texte du bouton
                                this.textContent = data.isFollowing ? 'Ne plus suivre' : 'Suivre';
                                this.setAttribute('data-is-following', data.isFollowing);
                                
                                // Mettre à jour la classe CSS
                                if (data.isFollowing) {
                                    this.classList.add('following');
                                } else {
                                    this.classList.remove('following');
                                }
                                
                                // Mettre à jour le compteur de suiveurs
                                const followersCountElement = document.querySelector('.followers-count');
                                if (followersCountElement) {
                                    followersCountElement.textContent = data.followersCount;
                                }
                                
                                // Afficher un message de succès
                                alert(data.message);
                            } else {
                                alert(data.message || 'Une erreur est survenue');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Une erreur est survenue lors de la tentative de suivi');
                        });
                    });
                });
            });
        </script>
    @endauth

@endsection

