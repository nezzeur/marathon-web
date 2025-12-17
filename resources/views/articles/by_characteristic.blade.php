@extends('layout.app')

@section('contenu')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">
            Articles avec la caractéristique : 
            <span class="text-blue-600">
                @if($type === 'accessibilite')
                    {{ $characteristic->texte }}
                @elseif($type === 'rythme')
                    {{ $characteristic->texte }}
                @elseif($type === 'conclusion')
                    {{ $characteristic->texte }}
                @endif
            </span>
        </h1>

        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold mb-2">
                                <a href="{{ route('articles.show', $article->id) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $article->titre }}
                                </a>
                            </h2>
                            <p class="text-gray-600 text-sm mb-2">
                                Par {{ $article->editeur->name }} • 
                                {{ $article->created_at->format('d/m/Y') }} • 
                                👁️ {{ $article->nb_vues }} {{ $article->nb_vues > 1 ? 'vues' : 'vue' }}
                            </p>
                            <p class="text-gray-700 mb-4">
                                {{ Str::limit($article->resume, 150) }}
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                    {{ $article->accessibilite->libelle ?? 'Non renseigné' }}
                                </span>
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                    {{ $article->rythme->texte ?? 'Non renseigné' }}
                                </span>
                                <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">
                                    {{ $article->conclusion->texte ?? 'Non renseigné' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p class="font-bold">Aucun article trouvé</p>
                <p>Il n'y a pas d'articles avec cette caractéristique pour le moment.</p>
            </div>
        @endif
        
        <div class="mt-6">
            <a href="{{ route('accueil') }}" class="text-blue-600 hover:text-blue-800 underline">
                ← Retour à l'accueil
            </a>
        </div>
    </div>
@endsection