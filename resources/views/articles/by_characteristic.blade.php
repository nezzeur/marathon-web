@extends('layout.app')

@section('contenu')
    <div class="max-w-6xl mx-auto px-5 py-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">
                🔎 Articles avec :
                <span class="text-blue-600">
                    @if($type === 'accessibilite')
                        ♿ {{ $characteristic->texte }}
                    @elseif($type === 'rythme')
                        ⏱️ {{ $characteristic->texte }}
                    @elseif($type === 'conclusion')
                        ✓ {{ $characteristic->texte }}
                    @endif
                </span>
            </h1>
            <p class="text-gray-600 mt-3">{{ $articles->count() }} article{{ $articles->count() !== 1 ? 's' : '' }} trouvé{{ $articles->count() !== 1 ? 's' : '' }}</p>
        </div>

        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($articles as $article)
                    <article class="bg-white rounded-lg shadow-md border border-gray-200 p-5 hover:shadow-lg transition-shadow">
                        <h2 class="text-lg font-bold text-gray-900 mb-2">
                            <a href="{{ route('articles.show', $article->id) }}" class="hover:text-blue-600 transition-colors">
                                {{ $article->titre }}
                            </a>
                        </h2>
                        <p class="text-sm text-gray-600 mb-3">
                            Par <strong>{{ $article->editeur->name }}</strong> •
                            {{ $article->created_at->format('d/m/Y') }} •
                            👁️ {{ $article->nb_vues }}
                        </p>
                        <p class="text-gray-700 mb-4 line-clamp-3">
                            {{ Str::limit($article->resume, 100) }}
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded font-semibold">
                                ♿ {{ $article->accessibilite->texte ?? 'Non renseigné' }}
                            </span>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-semibold">
                                ⏱️ {{ $article->rythme->texte ?? 'Non renseigné' }}
                            </span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-semibold">
                                ✓ {{ $article->conclusion->texte ?? 'Non renseigné' }}
                            </span>
                        </div>
                        <a href="{{ route('articles.show', $article->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded font-bold hover:bg-blue-700 transition-colors text-sm">
                            Lire →
                        </a>
                    </article>
                @endforeach
            </div>
            
            <div class="mt-8 flex justify-center">
                {{ $articles->links() }}
            </div>
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-6">
                <p class="text-yellow-900 font-bold text-lg">⚠️ Aucun article trouvé</p>
                <p class="text-yellow-800">Il n'y a pas d'articles avec cette caractéristique pour le moment.</p>
            </div>
        @endif
        
        <div class="mt-12">
            <a href="{{ route('accueil') }}" class="inline-block bg-gray-500 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-600 transition-colors">
                ← Retour à l'accueil
            </a>
        </div>
    </div>
@endsection