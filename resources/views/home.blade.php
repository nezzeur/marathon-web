@extends("layout.app")

@section('contenu')
    <div class="articles-container">
        <h1>Articles disponibles</h1>

        @if($articles->isEmpty())
            <p>Aucun article pour le moment.</p>
        @else
            <div class="articles-grid">
                @foreach($articles as $article)
                    <article class="article-card">
                        @if($article->image)
                            <div class="article-image">
                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre ?? 'Image de l\'article' }}" />
                            </div>
                        @endif
                        <div class="article-content">
                            <h2>{{ $article->titre ?? 'Sans titre' }}</h2>
                            @if($article->editeur)
                                <p class="author">Par <strong>{{ $article->editeur->name }}</strong></p>
                            @endif
                            @if($article->created_at)
                                <p class="date">{{ $article->created_at->format('d/m/Y') }}</p>
                            @endif
                            <p class="excerpt">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 150) }}</p>
                            <a href="{{ route('articles.show', $article) }}" class="btn-read-more">Lire la suite</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Top 3 articles les plus vus -->
    @if(isset($articlesPlusVus) && count($articlesPlusVus) > 0)
        <div class="categories-section">
            <h2 class="section-title">🔥 Top 3 articles les plus vus</h2>
            <div class="articles-grid">
                @foreach($articlesPlusVus as $article)
                    <article class="article-card">
                        <h2>{{ $article->titre ?? 'Sans titre' }}</h2>
                        @if($article->editeur)
                            <p class="author">Par <strong>{{ $article->editeur->name }}</strong></p>
                        @endif
                        <p class="date">{{ $article->created_at->format('d/m/Y') }}</p>
                        <p class="excerpt">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 150) }}</p>
                        <p class="article-stats">{{ $article->nb_vues }} vues</p>
                        <a href="{{ route('articles.show', $article) }}" class="btn-read-more">Lire la suite</a>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Top 3 articles les plus aimés -->
    @if(isset($articlesPlusLikes) && count($articlesPlusLikes) > 0)
        <div class="categories-section">
            <h2 class="section-title">❤️ Top 3 articles les plus aimés</h2>
            <div class="articles-grid">
                @foreach($articlesPlusLikes as $article)
                    <article class="article-card">
                        <h2>{{ $article->titre ?? 'Sans titre' }}</h2>
                        @if($article->editeur)
                            <p class="author">Par <strong>{{ $article->editeur->name }}</strong></p>
                        @endif
                        <p class="date">{{ $article->created_at->format('d/m/Y') }}</p>
                        <p class="excerpt">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 150) }}</p>
                        <p class="article-stats">{{ $article->likes_count }} likes</p>
                        <a href="{{ route('articles.show', $article) }}" class="btn-read-more">Lire la suite</a>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
@endsection
