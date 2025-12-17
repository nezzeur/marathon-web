@extends('layout.app')

@section('contenu')
    <div>

        {{-- Titre --}}
        <h1>{{ $article->titre }}</h1>

        {{-- Auteur & date --}}
        <p>
            Rédigé par <strong>{{ $article->editeur->name }}</strong>
            • {{ $article->created_at->format('d/m/Y') }}
            • 👁️ {{ $article->nb_vues }} {{ $article->nb_vues > 1 ? 'vues' : 'vue' }}
        </p>

        {{-- Image --}}
        @if($article->image)
            <div>
                <img src="{{ asset('storage/' . $article->image) }}" alt="Image de l'article">
            </div>
        @endif

        {{-- Résumé --}}
        <h3>Résumé</h3>
        <p>{{ $article->resume }}</p>

        {{-- Texte principal --}}
        <h3>Contenu</h3>
        <p>{!! nl2br(e($article->texte)) !!}</p>

        {{-- Média --}}
        @if($article->media)
            <h3>Média associé</h3>
            <a href="{{ $article->media }}" target="_blank">Voir le média</a>
        @endif

        {{-- Caractéristiques --}}
        <h3>Caractéristiques</h3>
        <ul>
            <li>
                Accessibilité : 
                @if($article->accessibilite)
                    <a href="{{ route('articles.byAccessibilite', $article->accessibilite->id) }}">
                        {{ $article->accessibilite->libelle }}
                    </a>
                @else
                    Non renseigné
                @endif
            </li>
            <li>
                Rythme : 
                @if($article->rythme)
                    <a href="{{ route('articles.byRythme', $article->rythme->id) }}">
                        {{ $article->rythme->libelle }}
                    </a>
                @else
                    Non renseigné
                @endif
            </li>
            <li>
                Conclusion : 
                @if($article->conclusion)
                    <a href="{{ route('articles.byConclusion', $article->conclusion->id) }}">
                        {{ $article->conclusion->libelle }}
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
@endsection
