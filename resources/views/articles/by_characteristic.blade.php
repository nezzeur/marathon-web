@extends('layout.app')

@section('contenu')
    <div class="max-w-6xl mx-auto px-5 py-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">
                🔎 Articles avec :
                <span style="color: #2BE7C6">
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
                    <article class="bg-white rounded-lg shadow-md border-2 p-5 hover:shadow-lg transition-shadow" style="border-color: #2BE7C6">
                        <h2 class="text-lg font-bold text-gray-900 mb-2">
                            <a href="{{ route('articles.show', $article->id) }}" style="color: #2B5BBB" class="hover:underline transition-colors">
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
                            <span class="text-xs px-2 py-1 rounded font-semibold text-white" style="background-color: #2BE7C6; color: #2B5BBB">
                                ♿ {{ $article->accessibilite->texte ?? 'Non renseigné' }}
                            </span>
                            <span class="text-xs px-2 py-1 rounded font-semibold text-white" style="background-color: #C2006D">
                                ⏱️ {{ $article->rythme->texte ?? 'Non renseigné' }}
                            </span>
                            <span class="text-xs px-2 py-1 rounded font-semibold text-white" style="background-color: #2B5BBB">
                                ✓ {{ $article->conclusion->texte ?? 'Non renseigné' }}
                            </span>
                        </div>
                        <a href="{{ route('articles.show', $article->id) }}" class="inline-block text-white px-4 py-2 rounded font-bold hover:opacity-90 transition-opacity text-sm" style="background-color: #2BE7C6; color: #2B5BBB">
                            Lire →
                        </a>
                    </article>
                @endforeach
            </div>
            
            <div class="mt-8 flex justify-center">
                {{ $articles->links() }}
            </div>
        @else
            <div class="border-l-4 rounded-lg p-6 text-white" style="background-color: #C2006D; border-color: #2B5BBB">
                <p class="font-bold text-lg">⚠️ Aucun article trouvé</p>
                <p>Il n'y a pas d'articles avec cette caractéristique pour le moment.</p>
            </div>
        @endif
        
        <div class="mt-12">
            <a href="{{ route('accueil') }}" class="inline-block text-white px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity" style="background-color: #2B5BBB">
                ← Retour à l'accueil
            </a>
        </div>
    </div>
@endsection