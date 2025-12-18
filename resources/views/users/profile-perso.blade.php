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

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-primary/10 p-4 rounded-lg border border-primary/30">
                            <div class="text-2xl font-bold text-primary">{{ $user->articles->count() }}</div>
                            <div class="text-muted-foreground text-sm">Articles</div>
                        </div>
                        <div class="bg-green-500/10 p-4 rounded-lg border border-green-500/30">
                            <div class="text-2xl font-bold text-green-400">{{ $user->suivis->count() }}</div>
                            <div class="text-muted-foreground text-sm">Suivis</div>
                        </div>
                        <div class="bg-purple-500/10 p-4 rounded-lg border border-purple-500/30">
                            <div class="text-2xl font-bold text-purple-400">{{ $user->suiveurs->count() }}</div>
                            <div class="text-muted-foreground text-sm">Suiveurs</div>
                        </div>
                    </div>

                    <a href="{{ route('user.edit') }}" class="hidden md:inline-block font-mono text-xs px-4 py-3 bg-primary text-primary-foreground hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1">
                        MODIFIER
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border-l-4 border-green-500 p-4 mb-8 rounded">
                <p class="text-green-400 font-semibold">✓ {{ session('success') }}</p>
            </div>
        @endif

        <!-- Onglets -->
        <div class="bg-card rounded-lg shadow-lg shadow-primary/20 overflow-hidden border border-border">
            <div class="border-b border-border">
                <div class="flex flex-wrap">
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-muted-foreground hover:bg-card/50 transition-colors border-b-4 border-transparent active" data-tab="articles">
                        Mes articles
                    </button>
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-muted-foreground hover:bg-card/50 transition-colors border-b-4 border-transparent" data-tab="brouillons">
                        Brouillons
                    </button>
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-muted-foreground hover:bg-card/50 transition-colors border-b-4 border-transparent" data-tab="aimes">
                        Articles aimés
                    </button>
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-muted-foreground hover:bg-card/50 transition-colors border-b-4 border-transparent" data-tab="suivis">
                        Mes suivis
                    </button>
                </div>
            </div>

            <div class="p-8 scanline-content">
                <!-- Onglet : Mes articles publiés -->
                <div class="tab-content active" id="tab-articles">
                    <h2 class="text-2xl font-bold text-primary mb-6">Mes articles publiés</h2>

                    @if($articlesPublies->count() > 0)
                        <div class="space-y-4">
                            @foreach($articlesPublies as $article)
                                <div class="border border-border rounded-lg p-6 hover:shadow-md hover:shadow-primary/20 transition-shadow bg-card/30">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-foreground">
                                                <a href="{{ route('articles.show', $article) }}" class="hover:text-primary transition-colors hover:animate-glow-pulse">{{ $article->titre }}</a>
                                            </h3>
                                            <p class="text-sm text-muted-foreground">{{ $article->created_at->format('d/m/Y à H:i') }}</p>
                                        </div>
                                        <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-semibold border border-green-500/30">✓ Publié</span>
                                    </div>
                                    <p class="text-muted-foreground mb-4">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 200) }}</p>
                                    <div class="flex gap-3">
                                        <x-nav-button type="link" href="{{ route('articles.show', $article) }}" size="sm" color="card" class="border-b-2 border-primary/50 active:translate-y-0.5">
                                            VIEW →
                                        </x-nav-button>
                                        <x-nav-button type="link" href="{{ route('articles.edit', $article) }}" size="sm" color="card" class="text-green-400 border-b-2 border-green-400/50 active:translate-y-0.5">
                                            EDIT
                                        </x-nav-button>
                                        <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-nav-button type="submit" size="sm" color="card" class="text-red-400 border-b-2 border-red-400/50 active:translate-y-0.5">
                                                DELETE
                                            </x-nav-button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-card/30 border-2 border-dashed border-border rounded-lg p-12 text-center">
                            <p class="text-muted-foreground text-lg">Aucun article publié pour le moment.</p>
                            <a href="{{ route('articles.create') }}" class="hidden md:inline-block font-mono text-xs px-4 py-3 bg-primary text-primary-foreground hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1">
                                CRÉER UN ARTICLE
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Onglet : Brouillons -->
                <div class="tab-content hidden" id="tab-brouillons">
                    <h2 class="text-2xl font-bold text-primary mb-6">fait Mes brouillons</h2>

                    @if($articlesBrouillons->count() > 0)
                        <div class="space-y-4">
                            @foreach($articlesBrouillons as $article)
                                <div class="border border-border rounded-lg p-6 hover:shadow-md hover:shadow-primary/20 transition-shadow bg-card/30">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-foreground">{{ $article->titre ?? $article->title }}</h3>
                                            <p class="text-sm text-muted-foreground">Créé le {{ $article->created_at->format('d/m/Y à H:i') }}</p>
                                        </div>
                                        <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-sm font-semibold border border-yellow-500/30">📝 Brouillon</span>
                                    </div>
                                    <p class="text-muted-foreground mb-4">{{ Illuminate\Support\Str::limit(strip_tags($article->texte ?? $article->resume ?? ''), 200) }}</p>
                                    <div class="flex gap-3">
                                        <x-nav-button type="link" href="{{ route('articles.edit', $article) }}" size="sm" color="card" class="text-green-400 border-b-2 border-green-400/50 active:translate-y-0.5">
                                            CONTINUE
                                        </x-nav-button>
                                        <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-nav-button type="submit" size="sm" color="card" icon="🗑️" class="text-red-400 border-b-2 border-red-400/50 active:translate-y-0.5">
                                                DELETE
                                            </x-nav-button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-card/30 border-2 border-dashed border-border rounded-lg p-12 text-center">
                            <p class="text-muted-foreground text-lg">📭 Aucun brouillon pour le moment.</p>
                        </div>
                    @endif
                </div>

                <!-- Onglet : Articles aimés -->
                <div class="tab-content hidden" id="tab-aimes">
                    <h2 class="text-2xl font-bold text-primary mb-6">Articles que j'ai aimés</h2>

                    @if($articlesAimes->count() > 0)
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
                                        READ_MORE →
                                    </x-nav-button>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-card/30 border-2 border-dashed border-border rounded-lg p-12 text-center">
                            <p class="text-muted-foreground text-lg">Vous n'avez encore aimé aucun article.</p>
                        </div>
                    @endif
                </div>

                <!-- Onglet : Mes suivis -->
                <div class="tab-content hidden" id="tab-suivis">
                    <h2 class="text-2xl font-bold text-primary mb-6">Personnes que je suis</h2>

                    @if($user->suivis->count() > 0)
                        <div class="space-y-4">
                            @foreach($user->suivis as $suivi)
                                <div class="border border-border rounded-lg p-6 flex items-center gap-6 hover:shadow-md hover:shadow-primary/20 transition-shadow bg-card/30">
                                    <div class="flex-shrink-0">
                                        @if($suivi->avatar)
                                            <img src="{{ asset('storage/' . $suivi->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-primary">
                                        @else
                                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-foreground text-2xl font-bold border-2 border-primary">
                                                {{ strtoupper(substr($suivi->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-foreground">
                                            <a href="{{ route('user.profile', $suivi->id) }}" class="hover:text-primary transition-colors hover:animate-glow-pulse">{{ $suivi->name }}</a>
                                        </h3>
                                        <p class="text-sm text-muted-foreground">{{ $suivi->articles->count() }} articles publiés</p>
                                    </div>
                                    <x-nav-button type="link" href="{{ route('user.profile', $suivi->id) }}">
                                        VIEW_PROFILE
                                    </x-nav-button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-card/30 border-2 border-dashed border-border rounded-lg p-12 text-center">
                            <p class="text-muted-foreground text-lg">Vous ne suivez personne pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>
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

                // Ajouter la classe active au bouton cliqué
                this.classList.add('active');
                this.classList.remove('text-muted-foreground');
                this.classList.add('text-primary');

                // Afficher le contenu correspondant
                const tabId = 'tab-' + this.getAttribute('data-tab');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });
    </script>

    {{-- Section des utilisateurs recommandés --}}
    @if(isset($recommendedUsers) && $recommendedUsers->count() > 0)
    <div class="mt-12">
        <x-user-recommendations :recommendedUsers="$recommendedUsers" title="🔍 Utilisateurs similaires" />
    </div>
    @endif
@endsection

