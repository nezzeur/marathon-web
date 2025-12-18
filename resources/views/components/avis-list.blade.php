@props(['article'])

{{-- Liste des commentaires --}}
<div class="comments-section">
    <h3>Commentaires ({{ $article->avis->count() }})</h3>

    @forelse($article->avis as $avis)
        <div class="comment-card">
            <div class="comment-header">
                <strong>{{ $avis->user->name }}</strong>
                • <span class="comment-date">{{ $avis->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="comment-body">
                {!! $avis->safeContent !!}
            </div>
        </div>
    @empty
        <div class="no-comments">
            <p>Aucun commentaire pour le moment.</p>
        </div>
    @endforelse
</div>

<style>
    .comments-section {
        margin-top: 40px;
    }

    .comments-section h3 {
        margin-bottom: 20px;
        color: #343a40;
        font-size: 1.3rem;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 10px;
    }

    .comment-card {
        background-color: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .comment-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .comment-header strong {
        color: #343a40;
        margin-right: 5px;
    }

    .comment-date {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .comment-body {
        color: #495057;
        line-height: 1.5;
    }

    .comment-body p {
        margin: 0;
    }

    .no-comments {
        text-align: center;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        color: #6c757d;
        font-style: italic;
    }
</style>