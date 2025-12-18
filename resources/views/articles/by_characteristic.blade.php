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
                    <div class="group relative bg-black/60 backdrop-blur-md rounded-xl border border-[#2858bb]/30 p-2 hover:border-[#2858bb] hover:shadow-[0_0_25px_rgba(40,88,187,0.4)] transition-all duration-300 hover:-translate-y-2">

                        <x-article-card :article="$article" />

                        <div class="absolute -top-1 -left-1 w-4 h-4 border-t-2 border-l-2 border-[#bed2ff] opacity-50 group-hover:opacity-100 transition-opacity shadow-[0_0_10px_#bed2ff]"></div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 border-b-2 border-r-2 border-[#bed2ff] opacity-50 group-hover:opacity-100 transition-opacity shadow-[0_0_10px_#bed2ff]"></div>
                    </div>
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