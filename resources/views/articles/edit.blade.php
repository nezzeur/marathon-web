@extends('layout.app')

@section('contenu')
    <div class="max-w-4xl mx-auto p-5">
        <h1 class="text-4xl font-bold mb-8 text-gray-900">✏️ Modifier l'article</h1>

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded">
                <strong class="text-red-900">❌ Erreurs :</strong>
                <ul class="mt-3 space-y-1 text-red-800">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Informations de base -->
            <fieldset class="border-b border-gray-200 pb-8">
                <legend class="text-xl font-bold text-gray-900 mb-6">📋 Informations de base</legend>

                <div class="space-y-4">
                    <div>
                        <label for="titre" class="block text-sm font-bold text-gray-700 mb-2">Titre :</label>
                        <input type="text" id="titre" name="titre" value="{{ old('titre', $article->titre) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="resume" class="block text-sm font-bold text-gray-700 mb-2">Résumé :</label>
                        <textarea id="resume" name="resume" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('resume', $article->resume) }}</textarea>
                    </div>

                    <div>
                        <label for="texte" class="block text-sm font-bold text-gray-700 mb-2">Contenu :</label>
                        <textarea id="texte" name="texte" rows="10"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('texte', $article->texte) }}</textarea>
                    </div>
                </div>
            </fieldset>

            <!-- Médias -->
            <fieldset class="border-b border-gray-200 pb-8">
                <legend class="text-xl font-bold text-gray-900 mb-6">🎨 Médias</legend>

                <div class="space-y-6">
                    <div>
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Image :</label>
                        @if($article->image)
                            <div class="mb-4 p-4 bg-gray-100 rounded-lg">
                                <img src="{{ asset('storage/' . $article->image) }}" alt="Image actuelle" class="max-w-xs h-auto rounded">
                                <p class="text-sm text-gray-600 mt-2">Image actuelle</p>
                            </div>
                        @endif
                        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <small class="text-gray-500">Formats acceptés : JPEG, PNG, GIF, WebP (max 2 Mo)</small>
                    </div>

                    <div>
                        <label for="media" class="block text-sm font-bold text-gray-700 mb-2">Fichier audio :</label>
                        @if($article->media)
                            <div class="mb-4 p-4 bg-gray-100 rounded-lg">
                                <audio controls class="w-full">
                                    <source src="{{ asset('storage/' . $article->media) }}" type="audio/mpeg">
                                    Votre navigateur ne supporte pas la balise audio.
                                </audio>
                                <p class="text-sm text-gray-600 mt-2">Fichier audio actuel</p>
                            </div>
                        @endif
                        <input type="file" id="media" name="media" accept="audio/mpeg,audio/wav"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <small class="text-gray-500">Formats acceptés : MP3, WAV (max 10 Mo)</small>
                    </div>
                </div>
            </fieldset>

            <!-- Caractéristiques -->
            <fieldset class="border-b border-gray-200 pb-8">
                <legend class="text-xl font-bold text-gray-900 mb-6">🏷️ Caractéristiques</legend>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="rythme_id" class="block text-sm font-bold text-gray-700 mb-2">Rythme :</label>
                        <select id="rythme_id" name="rythme_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Sélectionner --</option>
                            @foreach($rythmes as $rythme)
                                <option value="{{ $rythme->id }}" {{ old('rythme_id', $article->rythme_id) == $rythme->id ? 'selected' : '' }}>
                                    {{ $rythme->texte }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="accessibilite_id" class="block text-sm font-bold text-gray-700 mb-2">Accessibilité :</label>
                        <select id="accessibilite_id" name="accessibilite_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Sélectionner --</option>
                            @foreach($accessibilites as $accessibilite)
                                <option value="{{ $accessibilite->id }}" {{ old('accessibilite_id', $article->accessibilite_id) == $accessibilite->id ? 'selected' : '' }}>
                                    {{ $accessibilite->texte }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="conclusion_id" class="block text-sm font-bold text-gray-700 mb-2">Conclusion :</label>
                        <select id="conclusion_id" name="conclusion_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Sélectionner --</option>
                            @foreach($conclusions as $conclusion)
                                <option value="{{ $conclusion->id }}" {{ old('conclusion_id', $article->conclusion_id) == $conclusion->id ? 'selected' : '' }}>
                                    {{ $conclusion->texte }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- Actions -->
            <div class="flex gap-4 pt-6">
                <button type="submit" name="action" value="draft"
                        class="flex-1 text-white font-bold py-3 rounded-lg transition-opacity duration-200 hover:opacity-90" style="background-color: #2BE7C6; color: #2B5BBB">
                    💾 Enregistrer en brouillon
                </button>
                <button type="submit" name="action" value="publish"
                        class="flex-1 text-white font-bold py-3 rounded-lg transition-opacity duration-200 hover:opacity-90" style="background-color: #2B5BBB">
                    🚀 Publier
                </button>
                <a href="{{ route('articles.show', $article) }}"
                   class="flex-1 text-white font-bold py-3 rounded-lg transition-opacity duration-200 hover:opacity-90 flex items-center justify-center text-decoration-none" style="background-color: #C2006D">
                    ❌ Annuler
                </a>
            </div>
        </form>

        <!-- Zone de danger -->
        <div class="mt-12 pt-8 border-t-2" style="border-color: #C2006D">
            <h3 class="text-2xl font-bold mb-4" style="color: #C2006D">⚠️ Zone de danger</h3>
            <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-white font-bold py-3 px-6 rounded-lg transition-opacity duration-200 hover:opacity-90" style="background-color: #C2006D">
                    🗑️ Supprimer l'article
                </button>
            </form>
        </div>
    </div>

@endsection

