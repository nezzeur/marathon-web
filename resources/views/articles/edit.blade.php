@extends('layout.app')

@section('contenu')
    <style>
        /* Style spécifique pour la page d'édition d'article - synthwave/rétro */
        .edit-article-container {
            background: linear-gradient(135deg, rgba(13, 2, 33, 0.8) 0%, rgba(26, 5, 51, 0.6) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(43, 231, 198, 0.2);
            box-shadow: 0 0 20px rgba(43, 231, 198, 0.1);
        }
        
        /* Effet de scanline pour le contenu */
        .scanline-content {
            background-image: repeating-linear-gradient(
                to bottom,
                transparent 0px,
                rgba(43, 231, 198, 0.05) 1px,
                transparent 2px
            );
        }
        
        /* Style pour les fieldsets */
        .synthwave-fieldset {
            border-bottom: 2px solid var(--primary);
        }
        
        .synthwave-legend {
            color: var(--primary);
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>

    <div class="max-w-4xl mx-auto p-5 edit-article-container">
        <h1 class="text-4xl font-bold mb-8 text-foreground chrome-text animate-glow-pulse">MODIFIER L'ARTICLE</h1>

        @if($errors->any())
            <div class="bg-red-500/10 border-l-4 border-red-500 p-4 mb-8 rounded">
                <strong class="text-red-400">ERREURS :</strong>
                <ul class="mt-3 space-y-1 text-red-400">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="bg-card rounded-lg shadow-lg shadow-primary/20 p-8 space-y-8 border border-border scanline-content">
            @csrf
            @method('PUT')

            <!-- Informations de base -->
            <fieldset class="synthwave-fieldset pb-8">
                <legend class="synthwave-legend mb-6">INFORMATIONS DE BASE</legend>

                <div class="space-y-4">
                    <div>
                        <label for="titre" class="block text-sm font-bold text-primary mb-2">Titre :</label>
                        <input type="text" id="titre" name="titre" value="{{ old('titre', $article->titre) }}" required
                               class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground">
                    </div>

                    <div>
                        <label for="resume" class="block text-sm font-bold text-primary mb-2">Résumé :</label>
                        <textarea id="resume" name="resume" rows="4"
                                  class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground">{{ old('resume', $article->resume) }}</textarea>
                    </div>

                    <div>
                        <label for="texte" class="block text-sm font-bold text-primary mb-2">Contenu :</label>
                        <textarea id="texte" name="texte" rows="10"
                                  class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground">{{ old('texte', $article->texte) }}</textarea>
                    </div>
                </div>
            </fieldset>

            <!-- Médias -->
            <fieldset class="synthwave-fieldset pb-8">
                <legend class="synthwave-legend mb-6">MEDIAS</legend>

                <div class="space-y-6">
                    <div>
                        <label for="image" class="block text-sm font-bold text-primary mb-2">Image :</label>
                        @if($article->image)
                            <div class="mb-4 p-4 bg-card/50 rounded-lg border border-border">
                                <img src="{{ asset('storage/' . $article->image) }}" alt="Image actuelle" class="max-w-xs h-auto rounded border border-primary">
                                <p class="text-muted-foreground text-sm mt-2">Image actuelle</p>
                            </div>
                        @endif
                        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp"
                               class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground file:bg-primary file:text-primary-foreground file:border-0 file:rounded-lg file:px-4 file:py-2 file:mr-4 file:hover:bg-primary/80 file:hover:cursor-pointer">
                        <small class="text-muted-foreground">Formats acceptés : JPEG, PNG, GIF, WebP (max 2 Mo)</small>
                    </div>

                    <div>
                        <label for="media" class="block text-sm font-bold text-primary mb-2">Fichier audio :</label>
                        @if($article->media)
                            <div class="mb-4 p-4 bg-card/50 rounded-lg border border-border">
                                <audio controls class="w-full bg-card border border-border rounded">
                                    <source src="{{ asset('storage/' . $article->media) }}" type="audio/mpeg">
                                    Votre navigateur ne supporte pas la balise audio.
                                </audio>
                                <p class="text-muted-foreground text-sm mt-2">Fichier audio actuel</p>
                            </div>
                        @endif
                        <input type="file" id="media" name="media" accept="audio/mpeg,audio/wav"
                               class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground file:bg-primary file:text-primary-foreground file:border-0 file:rounded-lg file:px-4 file:py-2 file:mr-4 file:hover:bg-primary/80 file:hover:cursor-pointer">
                        <small class="text-muted-foreground">Formats acceptés : MP3, WAV (max 10 Mo)</small>
                    </div>
                </div>
            </fieldset>

            <!-- Caractéristiques -->
            <fieldset class="synthwave-fieldset pb-8">
                <legend class="synthwave-legend mb-6">CARACTERISTIQUES</legend>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="rythme_id" class="block text-sm font-bold text-primary mb-2">Rythme :</label>
                        <select id="rythme_id" name="rythme_id"
                                class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground">
                            <option value="">-- Sélectionner --</option>
                            @foreach($rythmes as $rythme)
                                <option value="{{ $rythme->id }}" {{ old('rythme_id', $article->rythme_id) == $rythme->id ? 'selected' : '' }}>
                                    {{ $rythme->texte }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="accessibilite_id" class="block text-sm font-bold text-primary mb-2">Accessibilité :</label>
                        <select id="accessibilite_id" name="accessibilite_id"
                                class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground">
                            <option value="">-- Sélectionner --</option>
                            @foreach($accessibilites as $accessibilite)
                                <option value="{{ $accessibilite->id }}" {{ old('accessibilite_id', $article->accessibilite_id) == $accessibilite->id ? 'selected' : '' }}>
                                    {{ $accessibilite->texte }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="conclusion_id" class="block text-sm font-bold text-primary mb-2">Conclusion :</label>
                        <select id="conclusion_id" name="conclusion_id"
                                class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground">
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
                <x-nav-button type="submit" name="action" value="draft" class="flex-1">
                    ENREGISTRER EN BROUILLON
                </x-nav-button>
                <x-nav-button type="submit" name="action" value="publish" color="secondary" class="flex-1">
                    PUBLIER
                </x-nav-button>
                <x-nav-button type="link" href="{{ route('articles.show', $article) }}" color="destructive" class="flex-1">
                    ANNULER
                </x-nav-button>
            </div>
        </form>

        <!-- Zone de danger -->
        <div class="mt-12 pt-8 border-t-2 border-destructive">
            <h3 class="text-2xl font-bold mb-4 text-destructive chrome-text animate-glow-pulse">ZONE DE DANGER</h3>
            <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.');" class="inline">
                @csrf
                @method('DELETE')
                <x-nav-button type="submit" color="destructive">
                    SUPPRIMER L'ARTICLE
                </x-nav-button>
            </form>
        </div>
    </div>

@endsection

