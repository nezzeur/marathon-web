@extends('layout.app')

@section('contenu')
    <style>
        .profile-container {
            background: linear-gradient(135deg, rgba(13, 2, 33, 0.8) 0%, rgba(26, 5, 51, 0.6) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(43, 231, 198, 0.2);
            box-shadow: 0 0 20px rgba(43, 231, 198, 0.1);
        }
        
        .profile-section {
            border-left: 3px solid var(--primary);
            padding-left: 1rem;
            margin-bottom: 2rem;
        }
        
        .scanline-content {
            background-image: repeating-linear-gradient(
                to bottom,
                transparent 0px,
                rgba(43, 231, 198, 0.05) 1px,
                transparent 2px
            );
        }
        
        .tab-btn.active {
            border-bottom-color: var(--primary) !important;
            color: var(--primary) !important;
        }
        
        .stats-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(43, 231, 198, 0.2);
        }
    </style>

    <div class="max-w-6xl mx-auto p-5 profile-container">
        <div class="bg-card rounded-lg shadow-lg shadow-primary/20 p-8 mb-8 border border-border">
            <div class="flex flex-col md:flex-row items-start gap-8 mb-8">
                <div class="flex-shrink-0">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar de {{ $user->name }}" class="w-40 h-40 rounded-full object-cover border-4 border-primary">
                    @else
                        <div class="w-40 h-40 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-foreground text-6xl font-bold border-4 border-primary">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-foreground mb-2 chrome-text animate-glow-pulse">{{ $user->name }}</h1>
                    <p class="text-muted-foreground mb-6">{{ $user->email }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div class="stats-card bg-primary/10 p-4 rounded-lg border border-primary/30">
                            <div class="text-2xl font-bold text-primary">{{ $user->articles->count() }}</div>
                            <div class="text-muted-foreground text-sm">Articles</div>
                        </div>
                        <div class="stats-card bg-green-500/10 p-4 rounded-lg border border-green-500/30">
                            <div class="text-2xl font-bold text-green-400">{{ $user->suiveurs->count() }}</div>
                            <div class="text-muted-foreground text-sm">Suiveurs</div>
                        </div>
                        <div class="stats-card bg-purple-500/10 p-4 rounded-lg border border-purple-500/30">
                            <div class="text-2xl font-bold text-purple-400">{{ $user->suivis->count() }}</div>
                            <div class="text-muted-foreground text-sm">Suivis</div>
                        </div>
                    </div>

                    @auth
                        @if(Auth::id() !== $user->id)
                            @php
                                $isFollowing = Auth::user()->suivis()->where('suivi_id', $user->id)->exists();
                            @endphp
                            <button class="btn-follow-toggle px-6 py-3 rounded-lg font-bold text-white transition-all duration-200 {{ $isFollowing ? 'bg-red-600 hover:bg-red-700' : 'bg-blue-600 hover:bg-blue-700' }}"
                                    data-user-id="{{ $user->id }}"
                                    data-is-following="{{ $isFollowing ? 'true' : 'false' }}">
                                {{ $isFollowing ? 'Ne plus suivre' : 'Suivre' }}
                            </button>
                        @endif
                    @else
                        <p class="text-muted-foreground"><a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Se connecter</a> pour suivre cet utilisateur.</p>
                    @endauth
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border-l-4 border-green-500 p-4 mb-8 rounded">
                <p class="text-green-400 font-semibold">Succes: {{ session('success') }}</p>
            </div>
        @endif

        <!-- Articles publies -->
        <div class="bg-card rounded-lg shadow-lg shadow-primary/20 overflow-hidden border border-border">
            <div class="border-b border-border">
                <div class="flex flex-wrap">
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-muted-foreground hover:bg-card/50 transition-colors border-b-4 border-transparent active" data-tab="articles">
                        Articles publies
                    </button>
                    @auth
                        @if(Auth::id() === $user->id)
                            <button class="tab-btn flex-1 py-4 px-6 font-bold text-muted-foreground hover:bg-card/50 transition-colors border-b-4 border-transparent" data-tab="aimes">
                                Articles aimes
                            </button>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="p-8 scanline-content">
                <!-- Onglet : Articles publies -->
                <div class="tab-content active" id="tab-articles">
                    <h2 class="text-2xl font-bold text-primary mb-6">Articles publies</h2>

                    @if($user->articles->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($user->articles as $article)
                                <article class="bg-card border border-border rounded-lg p-5 hover:shadow-lg hover:shadow-primary/20 transition-shadow">
                                    @if($article->image)
                                        <div class="w-full h-40 overflow-hidden bg-card/50 mb-4 rounded-md">
                                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre }}" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                    <h3 class="text-lg font-bold text-foreground mb-2">
                                        <a href="{{ route('articles.show', $article) }}" class="hover:text-primary transition-colors hover:animate-glow-pulse">{{ $article->titre }}</a>
                                    </h3>
                                    <p class="text-sm text-muted-foreground mb-2">Publie le {{ $article->created_at->format('d/m/Y a H:i') }}</p>
                                    <p class="text-sm text-muted-foreground mb-3">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 100) }}</p>
                                    <x-nav-button type="link" href="{{ route('articles.show', $article) }}" size="sm" color="card" class="border-b-2 border-primary/50 active:translate-y-0.5">
                                        LIRE →
                                    </x-nav-button>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-card/30 border-2 border-dashed border-border rounded-lg p-12 text-center">
                            <p class="text-muted-foreground text-lg">Aucun article publie pour le moment.</p>
                        </div>
                    @endif
                </div>

                <!-- Onglet : Articles aimes (uniquement pour le proprietaire) -->
                @auth
                    @if(Auth::id() === $user->id)
                        <div class="tab-content hidden" id="tab-aimes">
                            <h2 class="text-2xl font-bold text-primary mb-6">Articles que j'ai aimes</h2>

                            @if(isset($articlesAimes) && $articlesAimes->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($articlesAimes as $article)
                                        <article class="bg-card border border-border rounded-lg p-5 hover:shadow-lg hover:shadow-primary/20 transition-shadow">
                                            @if($article->image)
                                                <div class="w-full h-40 overflow-hidden bg-card/50 mb-4 rounded-md">
                                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre }}" class="w-full h-full object-cover">
                                                </div>
                                            @endif
                                            <h3 class="text-lg font-bold text-foreground mb-2">
                                                <a href="{{ route('articles.show', $article) }}" class="hover:text-primary transition-colors hover:animate-glow-pulse">{{ $article->titre }}</a>
                                            </h3>
                                            <p class="text-sm text-muted-foreground mb-2">Par <strong>{{ $article->editeur->name ?? 'Inconnu' }}</strong></p>
                                            <p class="text-xs text-muted-foreground mb-3">{{ $article->created_at->format('d/m/Y') }}</p>
                                            <p class="text-sm text-muted-foreground">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 100) }}</p>
                                            <x-nav-button type="link" href="{{ route('articles.show', $article) }}" size="sm" color="card" class="border-b-2 border-primary/50 active:translate-y-0.5">
                                                LIRE →
                                            </x-nav-button>
                                        </article>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-card/30 border-2 border-dashed border-border rounded-lg p-12 text-center">
                                    <p class="text-muted-foreground text-lg">Vous n'avez encore aime aucun article.</p>
                                </div>
                            @endif
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('accueil') }}" class="inline-block font-mono text-xs px-4 py-3 bg-primary text-primary-foreground hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1">
                ← RETOUR AU L'ACCUEIL
            </a>
        </div>
    </div>

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Retirer la classe active de tous les boutons
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active');
                    b.classList.add('text-muted-foreground');
                });

                // Masquer tous les onglets
                document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));

                // Ajouter la classe active au bouton clique
                this.classList.add('active');
                this.classList.remove('text-muted-foreground');
                this.classList.add('text-primary');

                // Afficher le contenu correspondant
                const tabId = 'tab-' + this.getAttribute('data-tab');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });
    </script>

    @auth
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const followButtons = document.querySelectorAll('.btn-follow-toggle');
                
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
                                this.textContent = data.isFollowing ? 'Ne plus suivre' : 'Suivre';
                                this.setAttribute('data-is-following', data.isFollowing);
                                
                                // Mettre a jour les couleurs
                                if (data.isFollowing) {
                                    this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                                    this.classList.add('bg-red-600', 'hover:bg-red-700');
                                } else {
                                    this.classList.remove('bg-red-600', 'hover:bg-red-700');
                                    this.classList.add('bg-blue-600', 'hover:bg-blue-700');
                                }
                                
                                const followersCountElement = document.querySelector('.followers-count');
                                if (followersCountElement) {
                                    followersCountElement.textContent = data.followersCount;
                                }
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    });
                });
            });
        </script>
    @endauth

    {{-- Section des utilisateurs recommandes --}}
    @if(isset($recommendedUsers) && $recommendedUsers->count() > 0)
    <div class="mt-12 max-w-6xl mx-auto p-5">
        <x-user-recommendations :recommendedUsers="$recommendedUsers" title="Utilisateurs recommandes" />
    </div>
    @endif
@endsection
