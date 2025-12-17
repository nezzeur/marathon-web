@props(['article', 'currentUser'])

<div class="flex gap-4 items-center">
    <form method="POST" action="{{ route('articles.like', $article->id) }}">
        @csrf
        <input type="hidden" name="nature" value="like">
        <button type="submit" class="bg-none border-0 cursor-pointer text-base flex items-center gap-2 px-4 py-2 rounded transition-all duration-200 {{ $article->likes->where('pivot.nature', 'like')->where('user_id', $currentUser?->id)->isNotEmpty() ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-blue-100 hover:text-blue-600' }}">
            👍 {{ $article->likes->where('pivot.nature', 'like')->count() }}
        </button>
    </form>
    
    <form method="POST" action="{{ route('articles.like', $article->id) }}">
        @csrf
        <input type="hidden" name="nature" value="dislike">
        <button type="submit" class="bg-none border-0 cursor-pointer text-base flex items-center gap-2 px-4 py-2 rounded transition-all duration-200 {{ $article->likes->where('pivot.nature', 'dislike')->where('user_id', $currentUser?->id)->isNotEmpty() ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-red-50 hover:text-red-600' }}">
            👎 {{ $article->likes->where('pivot.nature', 'dislike')->count() }}
        </button>
    </form>
</div>

