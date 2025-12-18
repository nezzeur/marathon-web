@extends('layout.app')

@section('contenu')
    <div class="max-w-6xl mx-auto p-5">
        <!-- En-tête du profil personnel -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row items-start gap-8 mb-8">
                <div class="flex-shrink-0">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar de {{ $user->name }}" class="w-40 h-40 rounded-full object-cover border-4 border-blue-500">
                    @else
                        <div class="w-40 h-40 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-6xl font-bold border-4 border-blue-500">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                    <p class="text-gray-600 mb-6">{{ $user->email }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <div class="text-2xl font-bold text-blue-600">{{ $user->articles->count() }}</div>
                            <div class="text-gray-600 text-sm">Articles</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <div class="text-2xl font-bold text-green-600">{{ $user->suivis->count() }}</div>
                            <div class="text-gray-600 text-sm">Suivis</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                            <div class="text-2xl font-bold text-purple-600">{{ $user->suiveurs->count() }}</div>
                            <div class="text-gray-600 text-sm">Suiveurs</div>
                        </div>
                    </div>

                    <a href="{{ route('user.edit') }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                        ✏️ Modifier mon profil
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded">
                <p class="text-green-900 font-semibold">✓ {{ session('success') }}</p>
            </div>
        @endif

        <!-- Onglets -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="border-b border-gray-200">
                <div class="flex flex-wrap">
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-gray-700 hover:bg-gray-100 transition-colors border-b-4 border-transparent active" data-tab="articles">
                        📝 Mes articles
                    </button>
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-gray-700 hover:bg-gray-100 transition-colors border-b-4 border-transparent" data-tab="brouillons">
                        💾 Brouillons
                    </button>
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-gray-700 hover:bg-gray-100 transition-colors border-b-4 border-transparent" data-tab="aimes">
                        ❤️ Articles aimés
                    </button>
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-gray-700 hover:bg-gray-100 transition-colors border-b-4 border-transparent" data-tab="suivis">
                        👥 Mes suivis
                    </button>
                </div>
            </div>

            <div class="p-8">
                <!-- Onglet : Mes articles publiés -->
                <div class="tab-content active" id="tab-articles">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">📝 Mes articles publiés</h2>

                    @if($articlesPublies->count() > 0)
                        <div class="space-y-4">
                            @foreach($articlesPublies as $article)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-gray-900">
                                                <a href="{{ route('articles.show', $article) }}" class="hover:text-blue-600 transition-colors">{{ $article->titre }}</a>
                                            </h3>
                                            <p class="text-sm text-gray-500">{{ $article->created_at->format('d/m/Y à H:i') }}</p>
                                        </div>
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">✓ Publié</span>
                                    </div>
                                    <p class="text-gray-700 mb-4">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 200) }}</p>
                                    <div class="flex gap-3">
                                        <a href="{{ route('articles.show', $article) }}" class="text-blue-600 font-bold hover:underline">Voir →</a>
                                        <a href="{{ route('articles.edit', $article) }}" class="text-green-600 font-bold hover:underline">Éditer ✏️</a>
                                        <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 font-bold hover:underline">Supprimer 🗑️</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                            <p class="text-gray-600 text-lg">📭 Aucun article publié pour le moment.</p>
                            <a href="{{ route('articles.create') }}" class="mt-4 inline-block bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">
                                Créer un article
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Onglet : Brouillons -->
                <div class="tab-content hidden" id="tab-brouillons">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">💾 Mes brouillons</h2>

                    @if($articlesBrouillons->count() > 0)
                        <div class="space-y-4">
                            @foreach($articlesBrouillons as $article)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-gray-900">{{ $article->titre ?? $article->title }}</h3>
                                            <p class="text-sm text-gray-500">Créé le {{ $article->created_at->format('d/m/Y à H:i') }}</p>
                                        </div>
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">📝 Brouillon</span>
                                    </div>
                                    <p class="text-gray-700 mb-4">{{ Illuminate\Support\Str::limit(strip_tags($article->texte ?? $article->resume ?? ''), 200) }}</p>
                                    <div class="flex gap-3">
                                        <a href="{{ route('articles.edit', $article) }}" class="text-green-600 font-bold hover:underline">Continuer ✏️</a>
                                        <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 font-bold hover:underline">Supprimer 🗑️</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                            <p class="text-gray-600 text-lg">📭 Aucun brouillon pour le moment.</p>
                        </div>
                    @endif
                </div>

                <!-- Onglet : Articles aimés -->
                <div class="tab-content hidden" id="tab-aimes">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">❤️ Articles que j'ai aimés</h2>

                    @if($articlesAimes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($articlesAimes as $article)
                                <article class="bg-white border border-gray-200 rounded-lg p-5 hover:shadow-lg transition-shadow">
                                    @if($article->image)
                                        <div class="w-full h-40 overflow-hidden bg-gray-100 mb-4 rounded-md">
                                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre }}" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">
                                        <a href="{{ route('articles.show', $article) }}" class="hover:text-blue-600">{{ $article->titre }}</a>
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">Par <strong>{{ $article->editeur->name ?? 'Inconnu' }}</strong></p>
                                    <p class="text-xs text-gray-400 mb-3">{{ $article->created_at->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-700">{{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 100) }}</p>
                                    <a href="{{ route('articles.show', $article) }}" class="mt-4 inline-block text-blue-600 font-bold hover:underline">
                                        Lire la suite →
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                            <p class="text-gray-600 text-lg">💔 Vous n'avez encore aimé aucun article.</p>
                        </div>
                    @endif
                </div>

                <!-- Onglet : Mes suivis -->
                <div class="tab-content hidden" id="tab-suivis">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">👥 Personnes que je suis</h2>

                    @if($user->suivis->count() > 0)
                        <div class="space-y-4">
                            @foreach($user->suivis as $suivi)
                                <div class="border border-gray-200 rounded-lg p-6 flex items-center gap-6 hover:shadow-md transition-shadow">
                                    <div class="flex-shrink-0">
                                        @if($suivi->avatar)
                                            <img src="{{ asset('storage/' . $suivi->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover">
                                        @else
                                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center text-white text-2xl font-bold">
                                                {{ strtoupper(substr($suivi->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-900">
                                            <a href="{{ route('user.profile', $suivi->id) }}" class="hover:text-blue-600">{{ $suivi->name }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-600">{{ $suivi->articles->count() }} articles publiés</p>
                                    </div>
                                    <a href="{{ route('user.profile', $suivi->id) }}" class="inline-block bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                        Voir profil
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                            <p class="text-gray-600 text-lg">👥 Vous ne suivez personne pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Retirer la classe active de tous les boutons
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active', 'border-blue-600');
                    b.classList.add('border-transparent');
                });

                // Masquer tous les onglets
                document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));

                // Ajouter la classe active au bouton cliqué
                this.classList.add('active', 'border-blue-600');
                this.classList.remove('border-transparent');

                // Afficher le contenu correspondant
                const tabId = 'tab-' + this.getAttribute('data-tab');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });
    </script>
@endsection

