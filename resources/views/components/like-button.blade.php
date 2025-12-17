@props(['article', 'currentUser'])

<div class="like-button-container">
    <form method="POST" action="{{ route('articles.like', $article->id) }}">
        @csrf
        <input type="hidden" name="nature" value="like">
        <button type="submit" class="like-btn {{ $article->likes->where('pivot.nature', 'like')->where('user_id', $currentUser?->id)->isNotEmpty() ? 'active' : '' }}">
            👍 {{ $article->likes->where('pivot.nature', 'like')->count() }}
        </button>
    </form>
    
    <form method="POST" action="{{ route('articles.like', $article->id) }}">
        @csrf
        <input type="hidden" name="nature" value="dislike">
        <button type="submit" class="dislike-btn {{ $article->likes->where('pivot.nature', 'dislike')->where('user_id', $currentUser?->id)->isNotEmpty() ? 'active' : '' }}">
            👎 {{ $article->likes->where('pivot.nature', 'dislike')->count() }}
        </button>
    </form>
</div>

<style>
    .like-button-container {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .like-btn, .dislike-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        transition: all 0.2s;
    }
    
    .like-btn {
        color: #4a5568;
    }
    
    .like-btn:hover, .like-btn.active {
        background-color: #ebf8ff;
        color: #3182ce;
    }
    
    .dislike-btn {
        color: #4a5568;
    }
    
    .dislike-btn:hover, .dislike-btn.active {
        background-color: #fff5f5;
        color: #e53e3e;
    }
</style>