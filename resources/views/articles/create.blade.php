@extends('layout.app')

@section('contenu')
    <div class="max-w-4xl mx-auto p-5">
        <h1 class="text-4xl font-bold mb-8 text-gray-900">✍️ Créer un nouvel article</h1>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded">
            <strong class="text-blue-900">ℹ️ Information :</strong>
            <ul class="mt-3 space-y-2 text-blue-800">
                <li><strong>Publier</strong> : L'article sera visible par tous les utilisateurs (tous les champs sont obligatoires)</li>
                <li><strong>Enregistrer comme brouillon</strong> : L'article sera enregistré mais pas visible (seul le titre est obligatoire)</li>
            </ul>
        </div>

        <form id="articleForm" action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white rounded-lg shadow p-8">
            @csrf

            <!-- Titre -->
            <div>
                <label for="titre" class="block text-sm font-bold text-gray-700 mb-2">📝 Titre :</label>
                <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('titre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Résumé -->
            <div>
                <label for="resume" class="block text-sm font-bold text-gray-700 mb-2">📄 Résumé (Markdown supporté) :</label>
                <textarea name="resume" id="resume" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('resume') }}</textarea>
                <small class="text-gray-500">Vous pouvez utiliser la syntaxe Markdown pour formater votre texte</small>
                @error('resume')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Texte principal -->
            <div>
                <label for="texte" class="block text-sm font-bold text-gray-700 mb-2">📚 Contenu (Markdown supporté) :</label>
                <textarea name="texte" id="texte" rows="10"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('texte') }}</textarea>
                <small class="text-gray-500">Vous pouvez utiliser la syntaxe Markdown pour formater votre texte</small>
                @error('texte')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-bold text-gray-700 mb-2">🖼️ Photo d'accroche :</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Média audio -->
            <div>
                <label for="media" class="block text-sm font-bold text-gray-700 mb-2">🎵 Média son :</label>
                <input type="file" name="media" id="media" accept=".mp3,.wav"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('media')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rythme -->
            <div>
                <label for="rythme_id" class="block text-sm font-bold text-gray-700 mb-2">⏱️ Rythme :</label>
                <select name="rythme_id" id="rythme_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="" selected>-- Sélectionnez --</option>
                    @foreach($rythmes as $rythme)
                        <option value="{{ $rythme->id }}" {{ old('rythme_id') == $rythme->id ? 'selected' : '' }}>
                            {{ $rythme->texte }}
                        </option>
                    @endforeach
                </select>
                @error('rythme_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Accessibilité -->
            <div>
                <label for="accessibilite_id" class="block text-sm font-bold text-gray-700 mb-2">♿ Accessibilité :</label>
                <select name="accessibilite_id" id="accessibilite_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="" selected>-- Sélectionnez --</option>
                    @foreach($accessibilites as $accessibilite)
                        <option value="{{ $accessibilite->id }}" {{ old('accessibilite_id') == $accessibilite->id ? 'selected' : '' }}>
                            {{ $accessibilite->texte }}
                        </option>
                    @endforeach
                </select>
                @error('accessibilite_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Conclusion -->
            <div>
                <label for="conclusion_id" class="block text-sm font-bold text-gray-700 mb-2">✓ Conclusion :</label>
                <select name="conclusion_id" id="conclusion_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="" selected>-- Sélectionnez --</option>
                    @foreach($conclusions as $conclusion)
                        <option value="{{ $conclusion->id }}" {{ old('conclusion_id') == $conclusion->id ? 'selected' : '' }}>
                            {{ $conclusion->texte }}
                        </option>
                    @endforeach
                </select>
                @error('conclusion_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" name="action" value="publish" onclick="setRequired(true)"
                        class="flex-1 text-white font-bold py-3 rounded-lg transition-opacity duration-200 hover:opacity-90" style="background-color: #2B5BBB">
                    🚀 Publier
                </button>
                <button type="submit" name="action" value="draft" onclick="setRequired(false)"
                        class="flex-1 text-white font-bold py-3 rounded-lg transition-opacity duration-200 hover:opacity-90" style="background-color: #2BE7C6; color: #2B5BBB">
                    💾 Enregistrer comme brouillon
                </button>
            </div>
        </form>
    </div>

    <script>
        function setRequired(isPublish) {
            const fields = ['resume', 'texte', 'image', 'media', 'rythme_id', 'accessibilite_id', 'conclusion_id'];

            fields.forEach(id => {
                document.getElementById(id).required = isPublish;
            });
            document.getElementById('titre').required = true;
        }
    </script>
@endsection
