@extends('layout.app')

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
                                    {{ $rythme->texte }}
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
                                    {{ $accessibilite->texte }}
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
                                    {{ $conclusion->texte }}
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

@endsection

