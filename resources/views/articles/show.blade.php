@extends('layout.app')

@section('contenu')
    <div class="max-w-4xl mx-auto p-5">
        {{-- En-tête avec titre et actions --}}
        <div class="flex flex-col md:flex-row justify-between items-start gap-5 mb-8">
            <h1 class="text-4xl font-bold text-gray-900 flex-1">{{ $article->titre }}</h1>

            @if(Auth::check() && Auth::id() === $article->user_id)
                <div class="flex gap-3 flex-shrink-0">
                    <a href="{{ route('articles.edit', $article) }}" class="inline-block px-4 py-2 rounded-lg font-bold text-white bg-green-600 hover:bg-green-700 transition-colors">
                        ✏️ Éditer
                    </a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block px-4 py-2 rounded-lg font-bold text-white bg-red-600 hover:bg-red-700 transition-colors">
                            🗑️ Supprimer
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Auteur & date --}}
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded">
            <p class="text-gray-700">
                <strong>{{ $article->editeur->name }}</strong> •
                {{ $article->created_at->format('d/m/Y') }} •
                👁️ {{ $article->nb_vues }} {{ $article->nb_vues > 1 ? 'vues' : 'vue' }}
            </p>
        </div>

        {{-- Image --}}
        @if($article->image)
            <div class="my-8 text-center">
                @if(str_contains($article->image, 'images/'))
                    <img src="{{ asset($article->image) }}" alt="Image de l'article" class="max-w-full h-auto rounded-lg shadow-lg">
                @else
                    <img src="{{ asset('storage/' . $article->image) }}" alt="Image de l'article" class="max-w-full h-auto rounded-lg shadow-lg">
                @endif
            </div>
        @endif

        {{-- Résumé --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-blue-600">📄 Résumé</h2>
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed bg-gray-50 p-6 rounded-lg">
                {!! $article->getResumeHtmlAttribute() !!}
            </div>
        </section>

        {{-- Texte principal --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-blue-600">📚 Contenu</h2>
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! $article->getTexteHtmlAttribute() !!}
            </div>
        </section>

        {{-- Média --}}
        @if($article->media)
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-blue-600">🎵 Média associé</h2>
                <audio controls class="w-full my-4 rounded-lg">
                    <source src="{{ asset('storage/' . $article->media) }}" type="audio/mpeg">
                    Votre navigateur ne supporte pas la balise audio.
                </audio>
            </section>
        @endif

        {{-- Caractéristiques --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-blue-600">🏷️ Caractéristiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <h3 class="font-bold text-purple-900 mb-2">♿ Accessibilité</h3>
                    @if($article->accessibilite)
                        <a href="{{ route('articles.byAccessibilite', $article->accessibilite->id) }}" class="text-blue-600 font-semibold hover:underline">
                            {{ $article->accessibilite->texte }}
                        </a>
                    @else
                        <p class="text-gray-600">Non renseigné</p>
                    @endif
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="font-bold text-green-900 mb-2">⏱️ Rythme</h3>
                    @if($article->rythme)
                        <a href="{{ route('articles.byRythme', $article->rythme->id) }}" class="text-blue-600 font-semibold hover:underline">
                            {{ $article->rythme->texte }}
                        </a>
                    @else
                        <p class="text-gray-600">Non renseigné</p>
                    @endif
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="font-bold text-yellow-900 mb-2">✓ Conclusion</h3>
                    @if($article->conclusion)
                        <a href="{{ route('articles.byConclusion', $article->conclusion->id) }}" class="text-blue-600 font-semibold hover:underline">
                            {{ $article->conclusion->texte }}
                        </a>
                    @else
                        <p class="text-gray-600">Non renseigné</p>
                    @endif
                </div>
            </div>
        </section>

        {{-- Likes --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-blue-600">👍 Réactions</h2>
            <div class="flex gap-6 mb-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex-1 text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $article->likes->where('pivot.nature', true)->count() }}</p>
                    <p class="text-gray-600 font-semibold">J'aime</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex-1 text-center">
                    <p class="text-3xl font-bold text-red-600">{{ $article->likes->where('pivot.nature', false)->count() }}</p>
                    <p class="text-gray-600 font-semibold">Je n'aime pas</p>
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
                        <button type="submit" class="w-full px-4 py-3 rounded-lg font-bold transition-colors {{ $currentNature === true ? 'bg-green-600 text-white hover:bg-green-700' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                            👍 J'aime {{ $currentNature === true ? '(actif)' : '' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('articles.toggleLike', $article->id) }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="nature" value="dislike">
                        <button type="submit" class="w-full px-4 py-3 rounded-lg font-bold transition-colors {{ $currentNature === false ? 'bg-red-600 text-white hover:bg-red-700' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                            👎 Je n'aime pas {{ $currentNature === false ? '(actif)' : '' }}
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-gray-700">
                        <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Connectez-vous</a> pour réagir à cet article.
                    </p>
                </div>
            @endauth
        </section>

        {{-- Commentaires --}}
        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-blue-600">💬 Commentaires ({{ $article->avis->count() }})</h2>

            @forelse($article->avis as $avis)
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <p class="font-bold text-gray-900">{{ $avis->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $avis->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <p class="text-gray-700">{{ $avis->contenu }}</p>
                </div>
            @empty
                <p class="text-gray-600 italic">Aucun commentaire pour le moment.</p>
            @endforelse

            {{-- Formulaire d'ajout de commentaire --}}
            @auth
                <div class="mt-8 bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Ajouter un commentaire</h3>

                    <form action="{{ route('avis.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->id }}">

                        <div class="mb-4">
                            <textarea name="contenu" rows="4" required placeholder="Écrivez votre commentaire..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"></textarea>
                        </div>

                        <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                            💬 Publier le commentaire
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                    <p class="text-gray-700 mb-4">
                        Vous devez être connecté pour laisser un commentaire.
                    </p>
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="bg-green-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-green-700 transition-colors">
                            S'inscrire
                        </a>
                    </div>
                </div>
            @endauth
        </section>

    </div>
@endsection
