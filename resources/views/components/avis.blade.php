@props(['article'])

{{-- Formulaire d'ajout de commentaire --}}
@auth
    <div class="comment-form-container">
        <h3>Ajouter un commentaire</h3>

        <form action="{{ route('avis.store') }}" method="POST">
            @csrf

            <input type="hidden" name="article_id" value="{{ $article->id }}">

            <div class="form-group">
                <textarea name="contenu" rows="4" required placeholder="Votre commentaire..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Publier le commentaire
            </button>
        </form>
    </div>
@else
    <div class="comment-auth-prompt">
        <p>
            Vous devez être connecté pour laisser un commentaire.
            <a href="{{ route('login') }}">Connectez-vous</a>
            ou
            <a href="{{ route('register') }}">inscrivez-vous</a>.
        </p>
    </div>
@endauth

<style>
    .comment-form-container {
        margin-top: 30px;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .comment-form-container h3 {
        margin-top: 0;
        color: #343a40;
        font-size: 1.2rem;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        resize: vertical;
        min-height: 100px;
        font-family: inherit;
        font-size: 1rem;
    }

    .form-group textarea:focus {
        outline: none;
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: #0069d9;
    }

    .comment-auth-prompt {
        margin-top: 20px;
        padding: 15px;
        background-color: #fff3cd;
        border-radius: 4px;
        border-left: 4px solid #ffc107;
    }

    .comment-auth-prompt p {
        margin: 0;
        color: #856404;
    }

    .comment-auth-prompt a {
        color: #856404;
        font-weight: bold;
        text-decoration: underline;
    }

    .comment-auth-prompt a:hover {
        color: #6b5000;
    }
</style>