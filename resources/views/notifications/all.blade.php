@extends('layout.app')

@section('contenu')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Toutes vos notifications</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Notifications ({{ $notifications->total() }})</h2>
            <div class="flex space-x-3">
                <a href="{{ route('notifications.markAllAsRead') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">
                    Marquer tout comme lu
                </a>
                <form action="{{ route('notifications.destroyAll') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer toutes les notifications ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">
                        Supprimer tout
                    </button>
                </form>
            </div>
        </div>

        @if($notifications->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500">Vous n'avez aucune notification.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    @php
                        $data = $notification->data;
                        $isUnread = !$notification->read_at;
                    @endphp
                    
                    <div class="notification-card {{ $isUnread ? 'bg-blue-50 border-l-4 border-blue-500' : 'bg-white border-l-4 border-gray-200' }} p-4 rounded-r-lg shadow-sm">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <strong class="text-blue-600">{{ $data['auteur_nom'] ?? 'Utilisateur' }}</strong>
                                    <span class="mx-2">•</span>
                                    <span class="text-gray-500 text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                                    @if($isUnread)
                                        <span class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Nouveau</span>
                                    @endif
                                </div>
                                <p class="text-gray-700 mb-2">{{ $data['message'] ?? '' }}</p>
                                <a href="{{ $data['url'] ?? '#' }}" class="text-blue-600 hover:text-blue-800 text-sm">Voir l'article</a>
                            </div>
                            <div class="flex space-x-2">
                                @if($isUnread)
                                    <a href="{{ route('notifications.markAsRead', $notification->id) }}" 
                                       class="text-green-600 hover:text-green-800" title="Marquer comme lu">
                                        ✓
                                    </a>
                                @endif
                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .notification-card {
        transition: all 0.2s ease;
    }
    
    .notification-card:hover {
        transform: translateX(2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
</style>
@endsection