@if(auth()->check())
    @php
        $notifications = auth()->user()->notifications()->latest()->take(5)->get();
        $unreadCount = auth()->user()->unreadNotifications()->count();
    @endphp
    
    <div class="notification-dropdown">
        <button class="notification-button" id="notificationButton">
            🔔 <span class="notification-count">{{ $unreadCount }}</span>
        </button>
        
        <div class="notification-panel" id="notificationPanel">
            <div class="notification-header">
                <h3>Notifications</h3>
                @if($unreadCount > 0)
                    <a href="{{ route('notifications.markAllAsRead') }}" class="mark-all-read">Marquer tout comme lu</a>
                @endif
            </div>
            
            @if($notifications->isEmpty())
                <div class="notification-empty">
                    Aucune notification pour le moment.
                </div>
            @else
                <div class="notification-list">
                    @foreach($notifications as $notification)
                        @php
                            $data = $notification->data;
                            $isUnread = !$notification->read_at;
                        @endphp
                        
                        <div class="notification-item {{ $isUnread ? 'unread' : '' }}">
                            <div class="notification-content">
                                <p><strong>{{ $data['auteur_nom'] ?? 'Utilisateur' }}</strong> {{ $data['message'] ?? '' }}</p>
                                <small class="notification-time">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <a href="{{ $data['url'] ?? '#' }}" class="notification-link">Voir</a>
                            @if($isUnread)
                                <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="mark-read">✓</a>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="notification-footer">
                    <a href="{{ route('notifications.all') }}">Voir toutes les notifications</a>
                </div>
            @endif
        </div>
    </div>
    
    <style>
        .notification-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .notification-button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2em;
            position: relative;
            padding: 5px 10px;
        }
        
        .notification-count {
            background-color: #ff4444;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8em;
            position: absolute;
            top: -5px;
            right: -5px;
        }
        
        .notification-panel {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            width: 350px;
            max-height: 500px;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .notification-panel.show {
            display: block;
        }
        
        .notification-header {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .notification-header h3 {
            margin: 0;
            font-size: 1.1em;
        }
        
        .mark-all-read {
            color: #4CAF50;
            text-decoration: none;
            font-size: 0.9em;
        }
        
        .notification-empty {
            padding: 20px;
            text-align: center;
            color: #666;
        }
        
        .notification-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .notification-item.unread {
            background-color: #f8f9fa;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-content p {
            margin: 0 0 5px 0;
            font-size: 0.95em;
        }
        
        .notification-time {
            color: #999;
            font-size: 0.8em;
        }
        
        .notification-link {
            color: #4CAF50;
            text-decoration: none;
            margin: 0 5px;
            font-size: 0.9em;
        }
        
        .mark-read {
            color: #4CAF50;
            text-decoration: none;
            font-size: 0.9em;
        }
        
        .notification-footer {
            padding: 10px 15px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        
        .notification-footer a {
            color: #2196F3;
            text-decoration: none;
            font-size: 0.9em;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('notificationButton');
            const panel = document.getElementById('notificationPanel');
            
            if (button && panel) {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    panel.classList.toggle('show');
                });
                
                document.addEventListener('click', function(e) {
                    if (!panel.contains(e.target) && e.target !== button) {
                        panel.classList.remove('show');
                    }
                });
            }
        });
    </script>
@endif