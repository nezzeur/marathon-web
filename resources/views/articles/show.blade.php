@extends("layout.app")

@section('contenu')
    <div class="article-detail-container">
        <a href="{{ route('accueil') }}" class="btn-back">← Retour à l'accueil</a>

        <article class="article-detail">
            <h1>{{ $article->title ?? 'Sans titre' }}</h1>

            @if($article->editeur)
                <p class="article-meta">
                    <strong>Auteur :</strong> {{ $article->editeur->name }}
                </p>
            @endif

            @if($article->created_at)
                <p class="article-meta">
                    <strong>Publié le :</strong> {{ $article->created_at->format('d/m/Y à H:i') }}
                </p>
            @endif

            <div class="article-content">
                {!! nl2br(e($article->description ?? '')) !!}
            </div>

            @if($article->likes)
                <p class="article-stats">
                    <strong>❤️ {{ $article->likes->count() }} likes</strong>
                </p>
            @endif

            @if($article->avis)
                <div class="article-avis">
                    <h3>Avis ({{ $article->avis->count() }})</h3>
                    @if($article->avis->count() > 0)
                        <ul>
                            @foreach($article->avis as $avis)
                                <li>{{ $avis->contenu ?? 'Avis sans contenu' }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Aucun avis pour le moment.</p>
                    @endif
                </div>
            @endif
        </article>

        <a href="{{ route('accueil') }}" class="btn-back">← Retour à l'accueil</a>
    </div>

    <style>
        .article-detail-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .btn-back {
            display: inline-block;
            background: #666;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            margin-bottom: 20px;
            transition: background 0.2s;
        }

        .btn-back:hover {
            background: #333;
        }

        .article-detail {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .article-detail h1 {
            margin-top: 0;
            font-size: 2em;
            margin-bottom: 20px;
        }

        .article-meta {
            color: #666;
            font-size: 0.95em;
            margin: 8px 0;
        }

        .article-content {
            margin: 30px 0;
            line-height: 1.8;
            font-size: 1.05em;
        }

        .article-stats {
            margin: 20px 0;
            font-size: 1.1em;
            color: #e74c3c;
        }

        .article-avis {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
        }

        .article-avis h3 {
            margin-bottom: 15px;
        }

        .article-avis ul {
            list-style: none;
            padding: 0;
        }

        .article-avis li {
            background: #fff;
            padding: 12px;
            margin: 10px 0;
            border-left: 4px solid #0066cc;
            border-radius: 4px;
        }
    </style>
@endsection

