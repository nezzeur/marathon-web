@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Titre --}}
        <h1 class="mb-3">{{ $article->titre }}</h1>

        {{-- Auteur & date --}}
        <p class="text-muted">
            Rédigé par <strong>{{ $article->editeur->name }}</strong>
            • {{ $article->created_at->format('d/m/Y') }}
        </p>

        {{-- Image --}}
        @if($article->image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $article->image) }}"
                     class="img-fluid rounded"
                     alt="Image de l'article">
            </div>
        @endif

        {{-- Résumé --}}
        <div class="mb-4">
            <h3>Résumé</h3>
            <p>{{ $article->resume }}</p>
        </div>

        {{-- Texte principal --}}
        <div class="mb-4">
            <h3>Contenu</h3>
            <p>{!! nl2br(e($article->texte)) !!}</p>
        </div>

        {{-- Média --}}
        @if($article->media)
            <div class="mb-4">
                <h3>Média associé</h3>
                <a href="{{ $article->media }}" target="_blank" class="btn btn-outline-primary">
                    Voir le média
                </a>
            </div>
        @endif

        {{-- Caractéristiques --}}
        <div class="mb-4">
            <h3>Caractéristiques</h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Accessibilité :</strong>
                    {{ $article->accessibilite->libelle ?? 'Non renseigné' }}
                </li>
                <li class="list-group-item">
                    <strong>Rythme :</strong>
                    {{ $article->rythme->libelle ?? 'Non renseigné' }}
                </li>
                <li class="list-group-item">
                    <strong>Conclusion :</strong>
                    {{ $article->conclusion->libelle ?? 'Non renseigné' }}
                </li>
            </ul>
        </div>

        {{-- Likes --}}
        <div class="mb-4">
            <h3>Réactions</h3>
            <p>
                👍 {{ $article->likes->where('pivot.nature', 'like')->count() }}
                |
                👎 {{ $article->likes->where('pivot.nature', 'dislike')->count() }}
            </p>
        </div>

        {{-- Commentaires --}}
        <div class="mb-4">
            <h3>Commentaires ({{ $article->avis->count() }})</h3>

            @forelse($article->avis as $avis)
                <div class="card mb-2">
                    <div class="card-body">
                        <p class="mb-1">
                            <strong>{{ $avis->user->name }}</strong>
                            <span class="text-muted">
                            • {{ $avis->created_at->format('d/m/Y H:i') }}
                        </span>
                        </p>
                        <p class="mb-0">{{ $avis->contenu }}</p>
                    </div>
                </div>
            @empty
                <p class="text-muted">Aucun commentaire pour le moment.</p>
            @endforelse
        </div>

    </div>
@endsection
