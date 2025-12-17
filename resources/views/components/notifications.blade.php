@props(['class' => ''])

@if(auth()->check())
    @php
        // Vérifier si la table notifications existe avant de l'utiliser
        try {
            $notifications = auth()->user()->notifications()->latest()->take(5)->get();
            $unreadCount = auth()->user()->unreadNotifications()->count();
        } catch (\Exception $e) {
            $notifications = collect();
            $unreadCount = 0;
        }
    @endphp
    
    <div {{ $attributes->merge(['class' => 'relative inline-block ' . $class]) }}>
        <button class="relative p-1.5 text-lg bg-none border-0 cursor-pointer" id="notificationButton">
            🔔 <span class="absolute top-[-5px] right-[-5px] bg-red-500 text-white rounded-full px-1.5 py-0.5 text-xs">{{ $unreadCount }}</span>
        </button>
        
        <div class="hidden absolute right-0 bg-white border border-gray-300 rounded-lg shadow-lg w-[350px] max-h-[500px] overflow-y-auto z-1000" id="notificationPanel">
            <div class="p-3 border-b border-gray-200 flex justify-between items-center">
                <h3 class="m-0 text-lg">Notifications</h3>
                @if($unreadCount > 0)
                    <a href="{{ route('notifications.markAllAsRead') }}" class="text-green-600 no-underline text-sm hover:text-green-700">Marquer tout comme lu</a>
                @endif
            </div>
            
            @if($notifications->isEmpty())
                <div class="p-5 text-center text-gray-600">
                    Aucune notification pour le moment.
                </div>
            @else
                <div class="list-none p-0 m-0">
                    @foreach($notifications as $notification)
                        @php
                            $data = $notification->data;
                            $isUnread = !$notification->read_at;
                        @endphp
                        
                        <div class="p-3 border-b border-gray-100 flex items-center justify-between {{ $isUnread ? 'bg-gray-100' : '' }} transition-transform duration-200 hover:translate-x-0.5">
                            <div class="flex-1">
                                <p class="m-0 mb-1 text-sm"><strong>{{ $data['auteur_nom'] ?? 'Utilisateur' }}</strong> {{ $data['message'] ?? '' }}</p>
                                <small class="text-gray-500 text-xs">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <a href="{{ $data['url'] ?? '#' }}" class="text-green-600 no-underline mx-1 text-sm">Voir</a>
                            @if($isUnread)
                                <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="text-green-600 no-underline text-sm">✓</a>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="p-2.5 text-center border-t border-gray-200">
                    <a href="{{ route('notifications.all') }}" class="text-blue-500 no-underline text-sm">Voir toutes les notifications</a>
                </div>
            @endif
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('notificationButton');
            const panel = document.getElementById('notificationPanel');
            
            if (button && panel) {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    panel.classList.toggle('hidden');
                });
                
                document.addEventListener('click', function(e) {
                    if (!panel.contains(e.target) && e.target !== button) {
                        panel.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endif