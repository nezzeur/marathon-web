@extends('layout.app')

@section('contenu')
    <div class="max-w-5xl mx-auto p-5">
        @auth
            <meta name="csrf-token" content="{{ csrf_token() }}">
        @endauth

        <!-- En-tête du profil public -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row items-start gap-8 mb-8">
                <div class="flex-shrink-0">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar de {{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-blue-500">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-4xl font-bold border-4 border-blue-500">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ $user->name }}</h1>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <div class="text-3xl font-bold text-blue-600">{{ $user->articles->count() }}</div>
                            <div class="text-gray-600 font-semibold">Articles publiés</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <div class="followers-count text-3xl font-bold text-green-600">{{ $user->suiveurs->count() }}</div>
                            <div class="text-gray-600 font-semibold">Suiveurs</div>
                        </div>
                    </div>

                    @auth
                        @if(Auth::id() !== $user->id)
                            @php
                                $isFollowing = Auth::user()->suivis()->where('suivi_id', $user->id)->exists();
                            @endphp
                            <button class="btn-follow-toggle px-6 py-3 rounded-lg font-bold text-white transition-all duration-200 {{ $isFollowing ? 'bg-red-600 hover:bg-red-700' : 'bg-blue-600 hover:bg-blue-700' }}"
                                    data-user-id="{{ $user->id }}"
                                    data-is-following="{{ $isFollowing ? 'true' : 'false' }}">
                                {{ $isFollowing ? '❤️ Ne plus suivre' : '🤍 Suivre' }}
                            </button>
                        @endif
                    @else
                        <p class="text-gray-600"><a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Se connecter</a> pour suivre cet utilisateur.</p>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Articles publiés -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 pb-4 border-b-4 border-blue-600">📚 Articles publiés</h2>

            @if($user->articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($user->articles as $article)
                        <article class="bg-white rounded-lg shadow-md border border-gray-200 p-4 flex flex-col hover:shadow-lg transition-shadow duration-200">
                            @if($article->image)
                                <div class="w-full h-40 overflow-hidden bg-gray-100 mb-4 rounded-md">
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre ?? 'Image de l\'article' }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                <a href="{{ route('articles.show', $article) }}" class="hover:text-blue-600 transition-colors">{{ $article->titre }}</a>
                            </h3>
                            <p class="text-xs text-gray-400 mb-3">{{ $article->created_at->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-700 leading-relaxed mb-4 flex-grow">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 100) }}</p>
                            <a href="{{ route('articles.show', $article) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-bold hover:bg-blue-700 transition-colors">
                                Lire la suite →
                            </a>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                    <p class="text-gray-600 text-lg">📭 Aucun article publié pour le moment.</p>
                </div>
            @endif
        </div>

        <a href="{{ route('accueil') }}" class="inline-block bg-gray-500 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-600 transition-colors">
            ← Retour à l'accueil
        </a>
    </div>

    @auth
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const followButtons = document.querySelectorAll('.btn-follow-toggle');
                
                followButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const userId = this.getAttribute('data-user-id');
                        const isFollowing = this.getAttribute('data-is-following') === 'true';
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        fetch(`/profile/${userId}/toggle-follow`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                _method: 'POST'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.textContent = data.isFollowing ? '❤️ Ne plus suivre' : '🤍 Suivre';
                                this.setAttribute('data-is-following', data.isFollowing);
                                
                                // Mettre à jour les couleurs
                                if (data.isFollowing) {
                                    this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                                    this.classList.add('bg-red-600', 'hover:bg-red-700');
                                } else {
                                    this.classList.remove('bg-red-600', 'hover:bg-red-700');
                                    this.classList.add('bg-blue-600', 'hover:bg-blue-700');
                                }
                                
                                const followersCountElement = document.querySelector('.followers-count');
                                if (followersCountElement) {
                                    followersCountElement.textContent = data.followersCount;
                                }
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    });
                });
            });
        </script>
    @endauth

@endsection

