*@extends('layout.app')

@section('contenu')
    <div class="edit-article-container">
        <h1>Modifier l'article</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Erreurs :</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="edit-form">
            @csrf
            @method('PUT')

            <!-- Informations de base -->
            <fieldset class="form-section">
                <legend>Informations de base</legend>

                <div class="form-group">
                    <label for="titre">Titre :</label>
                    <input type="text" id="titre" name="titre" value="{{ old('titre', $article->titre) }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="resume">Résumé :</label>
                    <textarea id="resume" name="resume" class="form-control" rows="3">{{ old('resume', $article->resume) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="texte">Contenu :</label>
                    <textarea id="texte" name="texte" class="form-control" rows="8">{{ old('texte', $article->texte) }}</textarea>
                </div>
            </fieldset>

            <!-- Médias -->
            <fieldset class="form-section">
                <legend>Médias</legend>

                <div class="form-group">
                    <label for="image">Image :</label>
                    @if($article->image)
                        <div class="current-media">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="Image actuelle" class="preview-image">
                            <p class="text-muted">Image actuelle</p>
                        </div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="form-control">
                    <small class="form-text">Formats acceptés : JPEG, PNG, GIF, WebP (max 2 Mo)</small>
                </div>

                <div class="form-group">
                    <label for="media">Fichier audio :</label>
                    @if($article->media)
                        <div class="current-media">
                            <audio controls class="audio-player">
                                <source src="{{ asset('storage/' . $article->media) }}" type="audio/mpeg">
                                Votre navigateur ne supporte pas la balise audio.
                            </audio>
                            <p class="text-muted">Fichier audio actuel</p>
                        </div>
                    @endif
                    <input type="file" id="media" name="media" accept="audio/mpeg,audio/wav" class="form-control">
                    <small class="form-text">Formats acceptés : MP3, WAV (max 10 Mo)</small>
                </div>
            </fieldset>

            <!-- Caractéristiques -->
            <fieldset class="form-section">
                <legend>Caractéristiques</legend>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rythme_id">Rythme :</label>
                        <select id="rythme_id" name="rythme_id" class="form-control">
                            <option value="">-- Sélectionner --</option>
                            @foreach($rythmes as $rythme)
                                <option value="{{ $rythme->id }}" {{ old('rythme_id', $article->rythme_id) == $rythme->id ? 'selected' : '' }}>
                                    {{ $rythme->nom ?? $rythme->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="accessibilite_id">Accessibilité :</label>
                        <select id="accessibilite_id" name="accessibilite_id" class="form-control">
                            <option value="">-- Sélectionner --</option>
                            @foreach($accessibilites as $accessibilite)
                                <option value="{{ $accessibilite->id }}" {{ old('accessibilite_id', $article->accessibilite_id) == $accessibilite->id ? 'selected' : '' }}>
                                    {{ $accessibilite->nom ?? $accessibilite->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="conclusion_id">Conclusion :</label>
                        <select id="conclusion_id" name="conclusion_id" class="form-control">
                            <option value="">-- Sélectionner --</option>
                            @foreach($conclusions as $conclusion)
                                <option value="{{ $conclusion->id }}" {{ old('conclusion_id', $article->conclusion_id) == $conclusion->id ? 'selected' : '' }}>
                                    {{ $conclusion->nom ?? $conclusion->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" name="action" value="draft" class="btn btn-secondary">Enregistrer en brouillon</button>
                <button type="submit" name="action" value="publish" class="btn btn-primary">Publier</button>
                <a href="{{ route('articles.show', $article) }}" class="btn btn-cancel">Annuler</a>
            </div>
        </form>

        <!-- Bouton de suppression -->
        <div class="delete-section">
            <h3>Zone de danger</h3>
            <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer l'article</button>
            </form>
        </div>
    </div>

    <style>
        .edit-article-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .edit-article-container h1 {
            margin-bottom: 30px;
        }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-danger ul {
            margin: 10px 0 0 20px;
            padding: 0;
        }

        .alert-danger li {
            margin: 5px 0;
        }

        .edit-form {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 30px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }

        .form-section:last-of-type {
            border-bottom: none;
        }

        .form-section legend {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        textarea.form-control {
            resize: vertical;
            font-family: monospace;
        }

        .form-control:focus {
            outline: none;
            border-color: #0066cc;
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .current-media {
            margin-bottom: 15px;
            padding: 15px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 4px;
            display: block;
            margin-bottom: 10px;
        }

        .audio-player {
            width: 100%;
            margin-bottom: 10px;
        }

        .text-muted {
            color: #999;
            font-size: 0.9em;
            margin-top: 8px;
        }

        .form-text {
            display: block;
            margin-top: 8px;
            color: #666;
            font-size: 0.9em;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            margin-bottom: 50px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }

        .btn-primary {
            background: #0066cc;
            color: white;
        }

        .btn-primary:hover {
            background: #0052a3;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-cancel {
            background: #999;
            color: white;
        }

        .btn-cancel:hover {
            background: #777;
        }

        .delete-section {
            background: #ffebee;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #c62828;
            margin-top: 40px;
        }

        .delete-section h3 {
            color: #c62828;
            margin-top: 0;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }
    </style>
@endsection

