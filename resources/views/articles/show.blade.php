@extends('layout.app')

@section('contenu')
    <div class="article-detail-page">
        {{-- En-tête avec titre et actions --}}
        <div class="article-header">
            <h1>{{ $article->titre }}</h1>

            @if(Auth::check() && Auth::id() === $article->user_id)
                <div class="article-owner-actions">
                    <a href="{{ route('articles.edit', $article) }}" class="btn btn-edit">✏️ Éditer</a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">🗑️ Supprimer</button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Auteur & date --}}
        <p class="article-meta">
            Rédigé par <strong>{{ $article->editeur->name }}</strong>
            • {{ $article->created_at->format('d/m/Y') }}
            • 👁️ {{ $article->nb_vues }} {{ $article->nb_vues > 1 ? 'vues' : 'vue' }}
        </p>

        {{-- Image --}}
        @if($article->image)
            <div class="article-image">
                <img src="{{ asset('storage/' . $article->image) }}" alt="Image de l'article">
            </div>
        @endif

        {{-- Résumé --}}
        <h3>Résumé</h3>
        <div class="article-resume">
            {!! $article->resume_html !!}
        </div>

        {{-- Texte principal --}}
        <h3>Contenu</h3>
        <div class="article-body">
            {!! $article->texte_html !!}
        </div>
        {{-- Média --}}
        @if($article->media)
            <h3>Média associé</h3>
            <audio controls style="width: 100%; margin: 20px 0;">
                <source src="{{ asset('storage/' . $article->media) }}" type="audio/mpeg">
                Votre navigateur ne supporte pas la balise audio.
            </audio>
        @endif

        {{-- Caractéristiques --}}
        <h3>Caractéristiques</h3>
        <ul>
            <li>
                Accessibilité : 
                @if($article->accessibilite)
                    <a href="{{ route('articles.byAccessibilite', $article->accessibilite->id) }}">
                        {{ $article->accessibilite->texte }}
                    </a>
                @else
                    Non renseigné
                @endif
            </li>
            <li>
                Rythme : 
                @if($article->rythme)
                    <a href="{{ route('articles.byRythme', $article->rythme->id) }}">
                        {{ $article->rythme->texte }}
                    </a>
                @else
                    Non renseigné
                @endif
            </li>
            <li>
                Conclusion : 
                @if($article->conclusion)
                    <a href="{{ route('articles.byConclusion', $article->conclusion->id) }}">
                        {{ $article->conclusion->texte }}
                    </a>
                @else
                    Non renseigné
                @endif
            </li>
        </ul>

        {{-- Likes --}}
        <h3>Réactions</h3>
        <p>
            👍 {{ $article->likes->where('pivot.nature', 'like')->count() }}
            |
            👎 {{ $article->likes->where('pivot.nature', 'dislike')->count() }}
        </p>

        {{-- Commentaires --}}
        <h3>Commentaires ({{ $article->avis->count() }})</h3>

        @forelse($article->avis as $avis)
            <div>
                <p>
                    <strong>{{ $avis->user->name }}</strong>
                    • {{ $avis->created_at->format('d/m/Y H:i') }}
                </p>
                <p>{{ $avis->contenu }}</p>
            </div>
        @empty
            <p>Aucun commentaire pour le moment.</p>
        @endforelse

    </div>

    <style>
        .article-detail-page {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .article-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 20px;
        }

        .article-header h1 {
            margin: 0;
            flex: 1;
        }

        .article-owner-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
            font-size: 0.9em;
            white-space: nowrap;
        }

        .btn-edit {
            background: #28a745;
            color: white;
        }

        .btn-edit:hover {
            background: #218838;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .article-meta {
            color: #666;
            margin: 10px 0 20px 0;
        }

        .article-image {
            margin: 20px 0;
            text-align: center;
        }

        .article-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        h3 {
            margin-top: 30px;
            margin-bottom: 15px;
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        li:last-child {
            border-bottom: none;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
