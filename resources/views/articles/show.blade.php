@extends('layout.app')

@section('contenu')
    <div class="max-w-4xl mx-auto p-5 article-container">
        <div class="flex flex-col md:flex-row justify-between items-start gap-5 mb-8">
            <h1 class="text-4xl font-bold text-foreground flex-1 chrome-text animate-glow-pulse">{{ $article->titre }}</h1>
            @if(Auth::check() && Auth::id() === $article->user_id)
                <div class="flex gap-3 flex-shrink-0">
                    <a href="{{ route('articles.edit', $article) }}" class="inline-block px-4 py-2 rounded-lg font-bold text-foreground bg-green-600 hover:bg-green-700 transition-colors border border-green-400 hover:animate-glow-pulse">
                        Éditer
                    </a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block px-4 py-2 rounded-lg font-bold text-foreground bg-red-600 hover:bg-red-700 transition-colors border border-red-400 hover:animate-glow-pulse">
                            Supprimer
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Auteur & date --}}
        <div class="bg-card/50 border-l-4 border-primary p-4 mb-8 rounded">
            <p class="text-muted-foreground">
                <strong class="text-primary">{{ $article->editeur->name }}</strong> •
                {{ $article->created_at->format('d/m/Y') }} •
                {{ $article->nb_vues }} {{ $article->nb_vues > 1 ? 'vues' : 'vue' }}
            </p>
        </div>

        {{-- Image --}}
        @if($article->image)
            <div class="my-8">
                @if(str_contains($article->image, 'images/'))
                    <img src="{{ asset($article->image) }}" alt="Image de l'article" class="article-image max-w-full h-auto rounded-lg shadow-lg shadow-primary/20 border border-primary/30">
                @else
                    <img src="{{ asset('storage/' . $article->image) }}" alt="Image de l'article" class="article-image max-w-full h-auto rounded-lg shadow-lg shadow-primary/20 border border-primary/30">
                @endif
            </div>
        @endif

        {{-- Résumé --}}
        <section class="mb-8 article-section">
            <h2 class="text-2xl font-bold text-primary mb-4 pb-2 border-b-2 border-primary">Résumé</h2>
            <div class="prose prose-lg max-w-none text-muted-foreground leading-relaxed bg-card/30 p-6 rounded-lg border border-border scanline-content">
                {!! $article->getResumeHtmlAttribute() !!}
            </div>
        </section>

        {{-- Texte principal --}}
        <section class="mb-8 article-section">
            <h2 class="text-2xl font-bold text-primary mb-4 pb-2 border-b-2 border-primary">Contenu</h2>
            <div class="prose prose-lg max-w-none text-muted-foreground leading-relaxed bg-card/30 p-6 rounded-lg border border-border scanline-content">
                {!! $article->getTexteHtmlAttribute() !!}
            </div>
        </section>

        {{-- Média --}}
        @if($article->media)
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-primary mb-4 pb-2 border-b-2 border-primary">Média associé</h2>
                <audio controls class="w-full my-4 rounded-lg bg-card border border-border">
                    <source src="{{ asset('storage/' . $article->media) }}" type="audio/mpeg">
                    Votre navigateur ne supporte pas la balise audio.
                </audio>
            </section>
        @endif

        {{-- Caractéristiques --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-primary mb-4 pb-2 border-b-2 border-primary">Caractéristiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-purple-500/20 border border-purple-500/30 rounded-lg p-4">
                    <h3 class="font-bold text-purple-400 mb-2">Accessibilité</h3>
                    @if($article->accessibilite)
                        <a href="{{ route('articles.byAccessibilite', $article->accessibilite->id) }}" class="text-primary font-semibold hover:underline hover:animate-glow-pulse">
                            {{ $article->accessibilite->texte }}
                        </a>
                    @else
                        <p class="text-muted-foreground">Non renseigné</p>
                    @endif
                </div>

                <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4">
                    <h3 class="font-bold text-green-400 mb-2">Rythme</h3>
                    @if($article->rythme)
                        <a href="{{ route('articles.byRythme', $article->rythme->id) }}" class="text-primary font-semibold hover:underline hover:animate-glow-pulse">
                            {{ $article->rythme->texte }}
                        </a>
                    @else
                        <p class="text-muted-foreground">Non renseigné</p>
                    @endif
                </div>

                <div class="bg-yellow-500/20 border border-yellow-500/30 rounded-lg p-4">
                    <h3 class="font-bold text-yellow-400 mb-2">Conclusion</h3>
                    @if($article->conclusion)
                        <a href="{{ route('articles.byConclusion', $article->conclusion->id) }}" class="text-primary font-semibold hover:underline hover:animate-glow-pulse">
                            {{ $article->conclusion->texte }}
                        </a>
                    @else
                        <p class="text-muted-foreground">Non renseigné</p>
                    @endif
                </div>
            </div>
        </section>

        {{-- Likes --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-primary mb-4 pb-2 border-b-2 border-primary">Réactions</h2>
            <div class="flex gap-6 mb-4">
                <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4 flex-1 text-center">
                    <p class="text-3xl font-bold text-green-400">{{ $article->likes->where('pivot.nature', true)->count() }}</p>
                    <p class="text-muted-foreground font-semibold">J'aime</p>
                </div>
                <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4 flex-1 text-center">
                    <p class="text-3xl font-bold text-red-400">{{ $article->likes->where('pivot.nature', false)->count() }}</p>
                    <p class="text-muted-foreground font-semibold">Je n'aime pas</p>
                </div>
            </div>

            @auth
                <div class="flex gap-3">
                    @php
                        $userLike = auth()->user()->likes->where('article_id', $article->id)->first();
                        $currentNature = $userLike ? $userLike->pivot->nature : null;
                    @endphp

                    <form method="POST" action="{{ route('articles.toggleLike', $article->id) }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="nature" value="like">
                        <button type="submit" class="w-full px-4 py-3 rounded-lg font-bold transition-colors {{ $currentNature === true ? 'bg-green-500 text-foreground hover:bg-green-600' : 'bg-card border border-green-500 text-green-400 hover:bg-green-500/20' }} hover:animate-glow-pulse">
                            J'aime {{ $currentNature === true ? '(actif)' : '' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('articles.toggleLike', $article->id) }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="nature" value="dislike">
                        <button type="submit" class="w-full px-4 py-3 rounded-lg font-bold transition-colors {{ $currentNature === false ? 'bg-red-500 text-foreground hover:bg-red-600' : 'bg-card border border-red-500 text-red-400 hover:bg-red-500/20' }} hover:animate-glow-pulse">
                            Je n'aime pas {{ $currentNature === false ? '(actif)' : '' }}
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-card/50 border border-border rounded-lg p-4">
                    <p class="text-muted-foreground">
                        <a href="{{ route('login') }}" class="text-primary font-bold hover:underline hover:animate-glow-pulse">Connectez-vous</a> pour réagir à cet article.
                    </p>
                </div>
            @endauth
        </section>

        {{-- Commentaires --}}
        <section>
            <h2 class="text-2xl font-bold text-primary mb-4 pb-2 border-b-2 border-primary">Commentaires ({{ $article->avis->count() }})</h2>

            @forelse($article->avis as $avis)
                <div class="bg-card/30 border border-border rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <p class="font-bold text-primary">{{ $avis->user->name }}</p>
                        <p class="text-sm text-muted-foreground">{{ $avis->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <p class="text-muted-foreground">{{ $avis->contenu }}</p>
                </div>
            @empty
                <p class="text-muted-foreground italic">Aucun commentaire pour le moment.</p>
            @endforelse

            {{-- Formulaire d'ajout de commentaire --}}
            @auth
                <div class="mt-8 bg-card border border-border rounded-lg p-6">
                    <h3 class="text-xl font-bold text-primary mb-4">Ajouter un commentaire</h3>

                    <form action="{{ route('avis.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->id }}">

                        <div class="mb-4">
                            <textarea name="contenu" rows="4" required placeholder="Écrivez votre commentaire..."
                                      class="w-full px-4 py-3 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-vertical text-foreground"></textarea>
                        </div>

                        <button type="submit" class="bg-primary text-primary-foreground font-bold py-3 px-6 rounded-lg hover:bg-primary/80 transition-colors border border-primary/50 hover:animate-glow-pulse">
                            Publier le commentaire
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-8 bg-card/50 border border-border rounded-lg p-6 text-center">
                    <p class="text-muted-foreground mb-4">
                        Vous devez être connecté pour laisser un commentaire.
                    </p>
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('login') }}" class="bg-primary text-primary-foreground font-bold py-2 px-6 rounded-lg hover:bg-primary/80 transition-colors border border-primary/50 hover:animate-glow-pulse">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="bg-secondary text-secondary-foreground font-bold py-2 px-6 rounded-lg hover:bg-secondary/80 transition-colors border border-secondary/50 hover:animate-glow-pulse">
                            S'inscrire
                        </a>
                    </div>
                </div>
            @endauth
        </section>

    </div>
@endsection
