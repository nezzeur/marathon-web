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
@endsection
