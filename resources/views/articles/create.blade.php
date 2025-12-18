@extends('layout.app')

@section('contenu')
    <h1>Créer un nouvel article</h1>

    <div>
        <strong>Information :</strong>
        <ul>
            <li><strong>Publier</strong> : L'article sera visible par tous les utilisateurs (tous les champs sont obligatoires)</li>
            <li><strong>Enregistrer comme brouillon</strong> : L'article sera enregistré mais pas visible (seul le titre est obligatoire)</li>
        </ul>
    </div>

    <form id="articleForm" action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required>
        </div>

        <div>
            <label for="resume">Résumé (Markdown supporté) :</label>
            <textarea name="resume" id="resume">{{ old('resume', '') }}</textarea>
            <small>Vous pouvez utiliser la syntaxe Markdown pour formater votre texte</small>
        </div>

        <div>
            <label for="texte">Texte (Markdown supporté) :</label>
            <textarea name="texte" id="texte">{{ old('texte', '') }}</textarea>
            <small>Vous pouvez utiliser la syntaxe Markdown pour formater votre texte</small>
        </div>

        <div>
            <label for="image">Photo d'accroche :</label>
            <input type="file" name="image" id="image" accept="image/*">
        </div>

        <div>
            <label for="media">Média son :</label>
            <input type="file" name="media" id="media" accept=".mp3,.wav">
        </div>

        <div>
            <label for="rythme_id">Rythme :</label>
            <select name="rythme_id" id="rythme_id">
                <option value="" selected>-- Sélectionnez --</option>
                @foreach($rythmes as $rythme)
                    <option value="{{ $rythme->id }}" {{ old('rythme_id') == $rythme->id ? 'selected' : '' }}>
                        {{ $rythme->texte }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="accessibilite_id">Accessibilité :</label>
            <select name="accessibilite_id" id="accessibilite_id">
                <option value="" selected>-- Sélectionnez --</option>
                @foreach($accessibilites as $accessibilite)
                    <option value="{{ $accessibilite->id }}" {{ old('accessibilite_id') == $accessibilite->id ? 'selected' : '' }}>
                        {{ $accessibilite->texte }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="conclusion_id">Conclusion :</label>
            <select name="conclusion_id" id="conclusion_id">
                <option value="" selected>-- Sélectionnez --</option>
                @foreach($conclusions as $conclusion)
                    <option value="{{ $conclusion->id }}" {{ old('conclusion_id') == $conclusion->id ? 'selected' : '' }}>
                        {{ $conclusion->texte }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" name="action" value="publish" onclick="setRequired(true)">Publier</button>
            <button type="submit" name="action" value="draft" onclick="setRequired(false)">Enregistrer comme brouillon</button>
        </div>
    </form>

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
