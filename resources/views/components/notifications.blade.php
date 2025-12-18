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
            <!-- Bouton de notification -->
            <button class="relative p-3 text-2xl rounded-full shadow-lg hover:shadow-xl transition-all border-b-4 cursor-pointer" id="notificationButton" title="Notifications" style="background-color: #2BE7C6; color: #2B5BBB; border-color: #000; border-bottom-width: 4px;">
                🔔
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold animate-pulse" style="background: linear-gradient(135deg, #C2006D 0%, #2BE7C6 100%); box-shadow: 0 0 10px rgba(194, 0, 109, 0.6)">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </button>

            <!-- Panel de notifications -->
            <div class="hidden absolute right-0 top-16 bg-[#051025] border-2 rounded-lg shadow-2xl w-96 max-h-96 overflow-hidden z-50" id="notificationPanel" style="border-color: #2BE7C6; box-shadow: 0 0 30px rgba(43, 231, 198, 0.3)">
                <!-- En-tête -->
                <div class="p-4 border-b-2 flex justify-between items-center sticky top-0 text-white" style="background: linear-gradient(135deg, #2B5BBB 0%, #C2006D 100%); border-bottom-color: #2BE7C6">
                    <h3 class="m-0 text-lg font-black uppercase tracking-wider" style="font-family: 'Orbitron', monospace;">🔔 Notif</h3>
                    @if($unreadCount > 0)
                        <a href="{{ route('notifications.markAllAsRead') }}" class="px-3 py-1 rounded text-xs font-bold transition-all border-b-2 border-black/30 hover:brightness-110 active:border-b-0 active:translate-y-0.5" style="background-color: #2BE7C6; color: #2B5BBB;">
                            ✓ Tout
                        </a>
                    @endif
                </div>

                <!-- Contenu des notifications -->
                <div class="overflow-y-auto max-h-80">
                    @if($notifications->isEmpty())
                        <div class="p-6 text-center">
                            <p class="text-2xl mb-2">📭</p>
                            <p class="font-bold text-white uppercase text-sm" style="font-family: 'Orbitron', monospace;">Aucune notif</p>
                            <p class="text-xs text-white/70 mt-1">Vous êtes à jour !</p>
                        </div>
                    @else
                        <div class="list-none p-0 m-0">
                            @foreach($notifications as $notification)
                                @php
                                    $data = $notification->data;
                                    $isUnread = !$notification->read_at;
                                @endphp

                                <div class="px-4 py-3 border-b-2 flex items-start gap-3 transition-all" style="border-bottom-color: #2B5BBB/20; {{ $isUnread ? 'background-color: rgba(43, 231, 198, 0.1); border-left: 3px solid #2BE7C6;' : 'background-color: #051025/50;' }}">
                                    <div class="text-xl flex-shrink-0">👤</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="m-0 text-xs font-black uppercase text-white tracking-wider" style="font-family: 'Orbitron', monospace;">
                                            {{ $data['auteur_nom'] ?? 'Utilisateur' }}
                                        </p>
                                        <p class="m-0 text-xs text-white/80 line-clamp-2 mt-1">
                                            {{ $data['message'] ?? 'Nouvelle notification' }}
                                        </p>
                                        <small class="text-white/50 text-[10px] block mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="flex gap-1 flex-shrink-0">
                                        <a href="{{ $data['url'] ?? '#' }}" class="text-white hover:brightness-110 px-2 py-1 rounded text-xs font-bold transition-all border-b-2 border-black/30" title="Voir" style="background-color: #2B5BBB;">
                                            👁️
                                        </a>
                                        @if($isUnread)
                                            <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="text-white hover:brightness-110 px-2 py-1 rounded text-xs font-bold transition-all border-b-2 border-black/30" title="Marquer comme lu" style="background-color: #2BE7C6; color: #2B5BBB;">
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
                    <div class="p-3 text-center border-t-2 border-[#2B5BBB]/30 bg-[#051025]/80 sticky bottom-0">
                        <a href="{{ route('notifications.all') }}" class="hover:text-[#2BE7C6] font-bold text-xs uppercase transition-colors tracking-wider" style="color: #2BE7C6; font-family: 'Orbitron', monospace;">
                            Voir tout →
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