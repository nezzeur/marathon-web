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
    
    <div class="fixed top-6 right-6 z-50">
        <div {{ $attributes->merge(['class' => 'relative inline-block ' . $class]) }}>
            <button class="relative p-2 text-2xl bg-white rounded-full shadow-lg hover:shadow-xl transition-shadow border-2 border-blue-600 cursor-pointer" id="notificationButton" title="Notifications">
                🔔
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </button>

            <div class="hidden absolute right-0 top-16 bg-white border-2 border-gray-200 rounded-lg shadow-2xl w-96 max-h-96 overflow-hidden z-50" id="notificationPanel">
                <!-- En-tête -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4 border-b border-gray-200 flex justify-between items-center sticky top-0">
                    <h3 class="m-0 text-lg font-bold text-white">🔔 Notifications</h3>
                    @if($unreadCount > 0)
                        <a href="{{ route('notifications.markAllAsRead') }}" class="text-white hover:bg-white hover:bg-opacity-20 px-3 py-1 rounded text-sm font-semibold transition-colors">
                            ✓ Marquer tout
                        </a>
                    @endif
                </div>

                <!-- Contenu des notifications -->
                <div class="overflow-y-auto max-h-80">
                    @if($notifications->isEmpty())
                        <div class="p-6 text-center text-gray-500">
                            <p class="text-2xl mb-2">📭</p>
                            <p class="font-semibold">Aucune notification</p>
                            <p class="text-sm">Vous êtes à jour !</p>
                        </div>
                    @else
                        <div class="list-none p-0 m-0">
                            @foreach($notifications as $notification)
                                @php
                                    $data = $notification->data;
                                    $isUnread = !$notification->read_at;
                                @endphp

                                <div class="px-4 py-3 border-b border-gray-100 flex items-start gap-3 {{ $isUnread ? 'bg-blue-50' : 'bg-white' }} hover:bg-gray-50 transition-colors">
                                    <div class="text-xl flex-shrink-0">👤</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="m-0 text-sm font-semibold text-gray-900">
                                            {{ $data['auteur_nom'] ?? 'Utilisateur' }}
                                        </p>
                                        <p class="m-0 text-sm text-gray-700 line-clamp-2">
                                            {{ $data['message'] ?? 'Nouvelle notification' }}
                                        </p>
                                        <small class="text-gray-400 text-xs block mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="flex gap-1 flex-shrink-0">
                                        <a href="{{ $data['url'] ?? '#' }}" class="bg-blue-600 text-white hover:bg-blue-700 px-2 py-1 rounded text-xs font-bold transition-colors" title="Voir">
                                            👁️
                                        </a>
                                        @if($isUnread)
                                            <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="bg-green-600 text-white hover:bg-green-700 px-2 py-1 rounded text-xs font-bold transition-colors" title="Marquer comme lu">
                                                ✓
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Pied de page -->
                @if($notifications->isNotEmpty())
                    <div class="p-3 text-center border-t border-gray-200 bg-gray-50 sticky bottom-0">
                        <a href="{{ route('notifications.all') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm transition-colors">
                            Voir toutes les notifications →
                        </a>
                    </div>
                @endif
            </div>
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
                    if (!panel.contains(e.target) && e.target !== button && !button.contains(e.target)) {
                        panel.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endif