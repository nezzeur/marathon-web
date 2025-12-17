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
                        <h2>{{ $article->title ?? 'Sans titre' }}</h2>
                        @if($article->editeur)
                            <p class="author">Par <strong>{{ $article->editeur->name }}</strong></p>
                        @endif
                        @if($article->created_at)
                            <p class="date">{{ $article->created_at->format('d/m/Y') }}</p>
                        @endif
                        <p class="excerpt">{{ Illuminate\Support\Str::limit(strip_tags($article->description ?? ''), 150) }}</p>
                        <a href="{{ route('articles.show', $article) }}" class="btn-read-more">Lire la suite</a>
                    </article>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .articles-container {
            padding: 20px;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
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

        .article-card h2 {
            margin: 0 0 10px 0;
            font-size: 1.3em;
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
    </style>
@endsection