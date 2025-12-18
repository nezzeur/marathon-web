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
            <button class="relative p-2 text-2xl bg-white rounded-full shadow-lg hover:shadow-xl transition-shadow border-2 cursor-pointer" id="notificationButton" title="Notifications" style="border-color: #2B5BBB">
                🔔
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold" style="background-color: #C2006D">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </button>

            <div class="hidden absolute right-0 top-16 bg-white border-2 rounded-lg shadow-2xl w-96 max-h-96 overflow-hidden z-50" id="notificationPanel" style="border-color: #2BE7C6">
                <!-- En-tête -->
                <div class="p-4 border-b flex justify-between items-center sticky top-0 text-white" style="background: linear-gradient(135deg, #2B5BBB 0%, #C2006D 100%)">
                    <h3 class="m-0 text-lg font-bold">🔔 Notifications</h3>
                    @if($unreadCount > 0)
                        <a href="{{ route('notifications.markAllAsRead') }}" class="hover:bg-white hover:bg-opacity-20 px-3 py-1 rounded text-sm font-semibold transition-colors">
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

                                <div class="px-4 py-3 border-b border-gray-100 flex items-start gap-3 hover:bg-gray-50 transition-colors" style="{{ $isUnread ? 'background-color: #2BE7C6; background-color: rgba(43, 231, 198, 0.1)' : '' }}">
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
                                        <a href="{{ $data['url'] ?? '#' }}" class="text-white hover:opacity-80 px-2 py-1 rounded text-xs font-bold transition-opacity" title="Voir" style="background-color: #2B5BBB">
                                            👁️
                                        </a>
                                        @if($isUnread)
                                            <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="text-white hover:opacity-80 px-2 py-1 rounded text-xs font-bold transition-opacity" title="Marquer comme lu" style="background-color: #2BE7C6; color: #2B5BBB">
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
                        <a href="{{ route('notifications.all') }}" class="hover:opacity-80 font-semibold text-sm transition-opacity" style="color: #2B5BBB">
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