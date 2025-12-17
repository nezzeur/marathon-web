@extends("layout.app")

@section('contenu')
    <div class="max-w-5xl mx-auto p-5">
        @if(isset($articlesPlusVus) && count($articlesPlusVus) > 0)
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-7 pb-4 border-b-4" style="border-color: #2BE7C6">🔥 Top 3 articles les plus vus</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($articlesPlusVus as $article)
                        <article class="bg-white rounded-lg shadow-md border-2 p-4 flex flex-col transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg" style="border-color: #2BE7C6">
                            @if($article->image)
                                <div class="w-full h-64 overflow-hidden bg-gray-100 mb-4 rounded-md">
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre ?? 'Image de l\'article' }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" />
                                </div>
                            @endif
                            <div class="p-4 flex-1 flex flex-col">
                                <h2 class="text-xl font-bold text-gray-900 mb-2 leading-snug">{{ $article->titre ?? 'Sans titre' }}</h2>
                                @if($article->editeur)
                                    <p class="text-sm text-gray-600 my-1">Par <strong>{{ $article->editeur->name }}</strong></p>
                                @endif
                                <p class="text-xs text-gray-400 my-1 mb-3">{{ $article->created_at->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-700 leading-relaxed mb-4 flex-grow">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 150) }}</p>
                                <p class="text-sm font-bold my-2.5" style="color: #2BE7C6">{{ $article->nb_vues }} vues</p>
                                <a href="{{ route('articles.show', $article) }}" class="inline-block text-white px-5 py-2.5 rounded-md text-decoration-none text-sm font-bold transition-opacity duration-200 self-start mt-auto hover:opacity-90" style="background-color: #2B5BBB">Lire la suite</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        @if(isset($articlesPlusLikes) && count($articlesPlusLikes) > 0)
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-7 pb-4 border-b-4" style="border-color: #C2006D">❤️ Top 3 articles les plus aimés</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($articlesPlusLikes as $article)
                        <article class="bg-white rounded-lg shadow-md border-2 p-4 flex flex-col transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg" style="border-color: #C2006D">
                            @if($article->image)
                                <div class="w-full h-64 overflow-hidden bg-gray-100 mb-4 rounded-md">
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre ?? 'Image de l\'article' }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" />
                                </div>
                            @endif
                            <div class="p-4 flex-1 flex flex-col">
                                <h2 class="text-xl font-bold text-gray-900 mb-2 leading-snug">{{ $article->titre ?? 'Sans titre' }}</h2>
                                @if($article->editeur)
                                    <p class="text-sm text-gray-600 my-1">Par <strong>{{ $article->editeur->name }}</strong></p>
                                @endif
                                <p class="text-xs text-gray-400 my-1 mb-3">{{ $article->created_at->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-700 leading-relaxed mb-4 flex-grow">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 150) }}</p>
                                <p class="text-sm font-bold my-2.5" style="color: #C2006D">{{ $article->likes_count }} likes</p>
                                <a href="{{ route('articles.show', $article) }}" class="inline-block text-white px-5 py-2.5 rounded-md text-decoration-none text-sm font-bold transition-opacity duration-200 self-start mt-auto hover:opacity-90" style="background-color: #2B5BBB">Lire la suite</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
