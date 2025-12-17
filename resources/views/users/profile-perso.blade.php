@extends("layout.app")

@section('contenu')
    <div class="profile-header">
        <img src="{{ asset($user->avatar) }}" alt="Avatar" style="width:100px; border-radius:50%;">
        <h1>{{ $user->name }}</h1>
        <p>{{ $user->email }}</p>

        <div class="stats" style="display: flex; gap: 20px; margin: 20px 0;">
            <div><strong>{{ $user->suiveurs->count() }}</strong> Followers</div>
            <div><strong>{{ $user->suivis->count() }}</strong> Suivis</div>
            <div><strong>{{ $articlesPublies->count() }}</strong> Articles publiés</div>
        </div>
    </div>

    <hr>

    <div class="profile-content" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">

        {{-- Section Articles Publiés --}}
        <section>
            <h2>Mes Articles en ligne</h2>
            @forelse($articlesPublies as $article)
                <div class="card" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                    <h4>{{ $article->titre }}</h4>
                    <small>Vues : {{ $article->nb_vues }}</small>
                    <br>
                    <a href="{{ route('articles.show', $article->id) }}">Voir l'article</a>
                </div>
            @empty
                <p>Aucun article publié.</p>
            @endforelse
        </section>

        {{-- Section Brouillons --}}
        <section style="background: #f9f9f9; padding: 15px;">
            <h2>Mes Brouillons (Privé)</h2>
            @forelse($articlesBrouillons as $article)
                <div class="card" style="border: 1px dashed orange; padding: 10px; margin-bottom: 10px;">
                    <h4>{{ $article->titre }}</h4>
                    <p>Dernière modification : {{ $article->updated_at->format('d/m/Y') }}</p>
                    <span style="color: orange;">⚠️ Non publié</span>
                </div>
            @empty
                <p>Aucun brouillon en cours.</p>
            @endforelse
        </section>

    </div>
@endsection