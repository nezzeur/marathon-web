@extends('layout.app')

@section('contenu')
    <h1>Créer un nouvel article</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required>
        </div>

        <div>
            <label for="resume">Résumé :</label>
            <textarea name="resume" id="resume" required>{{ old('resume') }}</textarea>
        </div>

        <div>
            <label for="texte">Texte :</label>
            <textarea name="texte" id="texte" required>{{ old('texte') }}</textarea>
        </div>

        <div>
            <label for="image">Photo d'accroche :</label>
            <input type="file" name="image" id="image" accept="image/*" required>
        </div>

        <div>
            <label for="media">Média son :</label>
            <input type="file" name="media" id="media" accept=".mp3,.wav" required>
        </div>

        <div>
            <label for="rythme_id">Rythme :</label>
            <select name="rythme_id" id="rythme_id" required>
                <option value="">-- Sélectionnez --</option>
                @foreach($rythmes as $rythme)
                    <option value="{{ $rythme->id }}" {{ old('rythme_id') == $rythme->id ? 'selected' : '' }}>
                        {{ $rythme->texte }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="accessibilite_id">Accessibilité :</label>
            <select name="accessibilite_id" id="accessibilite_id" required>
                <option value="">-- Sélectionnez --</option>
                @foreach($accessibilites as $accessibilite)
                    <option value="{{ $accessibilite->id }}" {{ old('accessibilite_id') == $accessibilite->id ? 'selected' : '' }}>
                        {{ $accessibilite->texte }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="conclusion_id">Conclusion :</label>
            <select name="conclusion_id" id="conclusion_id" required>
                <option value="">-- Sélectionnez --</option>
                @foreach($conclusions as $conclusion)
                    <option value="{{ $conclusion->id }}" {{ old('conclusion_id') == $conclusion->id ? 'selected' : '' }}>
                        {{ $conclusion->texte }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit">Créer l'article</button>
        </div>
    </form>
@endsection
