@extends('layout.app')

@section('contenu')
    <div class="max-w-4xl mx-auto p-5">
        {{-- En-tête avec titre et actions --}}
        <div class="flex justify-between items-start mb-5 gap-5">
            <h1 class="m-0 flex-1">{{ $article->titre }}</h1>

            @if(Auth::check() && Auth::id() === $article->user_id)
                <div class="flex gap-2.5 flex-shrink-0">
                    <a href="{{ route('articles.edit', $article) }}" class="inline-block px-2 py-2 rounded text-decoration-none font-bold transition-colors duration-200 border-0 cursor-pointer text-sm whitespace-nowrap bg-green-500 text-white hover:bg-green-600">✏️ Éditer</a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block px-2 py-2 rounded text-decoration-none font-bold transition-colors duration-200 border-0 cursor-pointer text-sm whitespace-nowrap bg-red-600 text-white hover:bg-red-700">🗑️ Supprimer</button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Auteur & date --}}
        <p class="text-gray-600 m-2.5 mb-5">
            Rédigé par <strong>{{ $article->editeur->name }}</strong>
            • {{ $article->created_at->format('d/m/Y') }}
            • 👁️ {{ $article->nb_vues }} {{ $article->nb_vues > 1 ? 'vues' : 'vue' }}
        </p>

        {{-- Image --}}
        @if($article->image)
            <div class="my-5 text-center">
                <img src="{{ asset('storage/' . $article->image) }}" alt="Image de l'article" class="max-w-full h-auto rounded-lg">
            </div>
        @endif

        {{-- Résumé --}}
        <h3 class="mt-7 mb-4 text-gray-800">Résumé</h3>
        <div class="whitespace-pre-wrap">
            {!! $article->getResumeHtmlAttribute() !!}
        </div>

        {{-- Texte principal --}}
        <h3 class="mt-7 mb-4 text-gray-800">Contenu</h3>
        <div class="whitespace-pre-wrap">
            {!! $article->getTexteHtmlAttribute() !!}
        </div>
        {{-- Média --}}
        @if($article->media)
            <h3 class="mt-7 mb-4 text-gray-800">Média associé</h3>
            <audio controls class="w-full my-5">
                <source src="{{ asset('storage/' . $article->media) }}" type="audio/mpeg">
                Votre navigateur ne supporte pas la balise audio.
            </audio>
        @endif

        {{-- Caractéristiques --}}
        <h3 class="mt-7 mb-4 text-gray-800">Caractéristiques</h3>
        <ul class="list-none p-0">
            <li class="py-2 border-b border-gray-200">
                Accessibilité :
                @if($article->accessibilite)
                    <a href="{{ route('articles.byAccessibilite', $article->accessibilite->id) }}" class="text-blue-600 no-underline hover:underline">
                        {{ $article->accessibilite->texte }}
                    </a>
                @else
                    Non renseigné
                @endif
            </li>
            <li class="py-2 border-b border-gray-200">
                Rythme :
                @if($article->rythme)
                    <a href="{{ route('articles.byRythme', $article->rythme->id) }}" class="text-blue-600 no-underline hover:underline">
                        {{ $article->rythme->texte }}
                    </a>
                @else
                    Non renseigné
                @endif
            </li>
            <li class="py-2">
                Conclusion :
                @if($article->conclusion)
                    <a href="{{ route('articles.byConclusion', $article->conclusion->id) }}" class="text-blue-600 no-underline hover:underline">
                        {{ $article->conclusion->texte }}
                    </a>
                @else
                    Non renseigné
                @endif
            </li>
        </ul>

        {{-- Likes --}}
        <h3 class="mt-7 mb-4 text-gray-800">Réactions</h3>
        <div>
            <p>
                👍 {{ $article->likes->where('pivot.nature', true)->count() }}
                |
                👎 {{ $article->likes->where('pivot.nature', false)->count() }}
            </p>

            @auth
                <div>
                    @php
                        $userLike = auth()->user()->likes->where('article_id', $article->id)->first();
                        $currentNature = $userLike ? $userLike->pivot->nature : null;
                    @endphp

                    @if($currentNature === true)
                        <form method="POST" action="{{ route('articles.toggleLike', $article->id) }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="nature" value="like">
                            <button type="submit">👍 J'aime (actif)</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('articles.toggleLike', $article->id) }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="nature" value="like">
                            <button type="submit">👍 J'aime</button>
                        </form>
                    @endif

                    @if($currentNature === false)
                        <form method="POST" action="{{ route('articles.toggleLike', $article->id) }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="nature" value="dislike">
                            <button type="submit">👎 Je n'aime pas (actif)</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('articles.toggleLike', $article->id) }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="nature" value="dislike">
                            <button type="submit">👎 Je n'aime pas</button>
                        </form>
                    @endif
                </div>
            @else
                <p>
                    <a href="{{ route('login') }}" class="text-blue-600 no-underline hover:underline">Connectez-vous</a> pour réagir à cet article.
                </p>
            @endauth
        </div>

        {{-- Commentaires --}}
        <h3 class="mt-7 mb-4 text-gray-800">Commentaires ({{ $article->avis->count() }})</h3>

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

        {{-- Formulaire d'ajout de commentaire --}}
        @auth
            <h3 class="mt-7 mb-4 text-gray-800">Ajouter un commentaire</h3>

            <form action="{{ route('avis.store') }}" method="POST">
                @csrf

                <input type="hidden" name="article_id" value="{{ $article->id }}">

                <div>
                    <textarea name="contenu" rows="4" required class="w-full px-2.5 py-2.5 border border-gray-300 rounded-md text-base box-border font-sans resize-vertical font-mono focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200"></textarea>
                </div>

                <button type="submit" class="inline-block px-5 py-2.5 rounded-md text-decoration-none font-bold transition-colors duration-200 border-0 cursor-pointer text-base bg-blue-600 text-white hover:bg-blue-700 mt-4">
                    Publier le commentaire
                </button>
            </form>
        @else
            <p>
                Vous devez être connecté pour laisser un commentaire.
                <a href="{{ route('login') }}" class="text-blue-600 no-underline hover:underline">Connectez-vous</a>
                ou
                <a href="{{ route('register') }}" class="text-blue-600 no-underline hover:underline">inscrivez-vous</a>.
            </p>
        @endauth

    </div>
@endsection
