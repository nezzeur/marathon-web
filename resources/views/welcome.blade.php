@extends("layout.app")

@section('contenu')
    <div class="articles-container">
        <h1>Articles disponibles</h1>

        @if($articles->isEmpty())
            <p>Aucun article pour le moment.</p>
        @else
            <div class="articles-grid">
                @foreach($articles as $article)
                    @include('components.article-card', ['article' => $article])
                @endforeach
            </div>
        @endif
    </div>
@endsection