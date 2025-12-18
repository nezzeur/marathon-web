@extends('layout.app')

@section('contenu')
<div class="relative z-10 min-h-screen py-10 px-4 flex justify-center">
    <div class="w-full max-w-4xl">

        {{-- EN-TÊTE --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl md:text-5xl font-black italic uppercase tracking-tighter text-white drop-shadow-[0_2px_0px_#2B5BBB]" style="font-family: 'Orbitron', monospace;">
                NOTIFICATIONS
            </h1>
            <div class="h-1 w-32 mx-auto mt-4 bg-gradient-to-r from-transparent via-[#C2006D] to-transparent"></div>
        </div>

        {{-- CONTENEUR PRINCIPAL --}}
        <div class="relative bg-gradient-to-br from-[#2B5BBB]/30 to-[#051025]/80 backdrop-blur-xl rounded-2xl border border-[#2BE7C6]/30 p-8 shadow-[0_0_50px_rgba(43,91,187,0.2)]">

            {{-- ACTIONS (Haut du panel) --}}
            <div class="flex justify-between items-center mb-8 pb-6 border-b-2 border-[#2B5BBB]/30">
                <h2 class="text-xl md:text-2xl font-black uppercase text-white" style="font-family: 'Orbitron', monospace;">
                    🔔 Notifs ({{ $notifications->total() }})
                </h2>
                <div class="flex gap-3">
                    <a href="{{ route('notifications.markAllAsRead') }}"
                       class="px-4 py-2 bg-[#2BE7C6] text-black font-bold rounded border-b-4 border-black/30 hover:brightness-110 active:border-b-0 active:translate-y-1 transition-all text-xs uppercase tracking-wider" style="font-family: 'Orbitron', monospace;">
                        ✓ Tout lire
                    </a>
                    <form action="{{ route('notifications.destroyAll') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer toutes les notifications ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-[#C2006D] text-white font-bold rounded border-b-4 border-black/30 hover:brightness-110 active:border-b-0 active:translate-y-1 transition-all text-xs uppercase tracking-wider" style="font-family: 'Orbitron', monospace;">
                            ✕ Supprimer
                        </button>
                    </form>
                </div>
            </div>

            {{-- CONTENU DES NOTIFICATIONS --}}
            <div class="space-y-4">
                @if($notifications->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-3xl mb-3">📭</p>
                        <p class="text-white font-bold text-lg uppercase tracking-wider" style="font-family: 'Orbitron', monospace;">Aucune notification</p>
                        <p class="text-white/60 text-sm mt-2">Vous êtes à jour !</p>
                    </div>
                @else
                    @foreach($notifications as $notification)
                        @php
                            $data = $notification->data;
                            $isUnread = !$notification->read_at;
                        @endphp

                        <div class="p-5 rounded-xl border-l-4 transition-all" style="{{ $isUnread ? 'background-color: rgba(43, 231, 198, 0.1); border-left-color: #2BE7C6;' : 'background-color: #051025/40; border-left-color: #2B5BBB/30;' }}">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-xl">👤</span>
                                        <strong class="text-white font-black uppercase" style="font-family: 'Orbitron', monospace;">
                                            {{ $data['auteur_nom'] ?? 'Utilisateur' }}
                                        </strong>
                                        <span class="text-white/50 text-xs">•</span>
                                        <span class="text-white/60 text-xs">{{ $notification->created_at->diffForHumans() }}</span>
                                        @if($isUnread)
                                            <span class="ml-auto bg-[#2BE7C6] text-black text-xs px-2 py-1 rounded font-bold uppercase tracking-wider" style="font-family: 'Orbitron', monospace;">
                                                Nouveau
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-white/80 text-sm mb-3">{{ $data['message'] ?? '' }}</p>
                                    <a href="{{ $data['url'] ?? '#' }}" class="text-[#2BE7C6] hover:text-[#2BE7C6]/80 text-sm font-bold uppercase transition-colors tracking-wider" style="font-family: 'Orbitron', monospace;">
                                        Voir l'article →
                                    </a>
                                </div>
                                <div class="flex gap-2 flex-shrink-0">
                                    @if($isUnread)
                                        <a href="{{ route('notifications.markAsRead', $notification->id) }}"
                                           class="px-3 py-2 bg-[#2BE7C6] text-black font-bold rounded text-xs border-b-2 border-black/30 hover:brightness-110 active:border-b-0 active:translate-y-0.5 transition-all"
                                           title="Marquer comme lu">
                                            ✓
                                        </a>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                          onsubmit="return confirm('Supprimer cette notification ?')"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-[#C2006D] text-white font-bold rounded text-xs border-b-2 border-black/30 hover:brightness-110 active:border-b-0 active:translate-y-0.5 transition-all"
                                                title="Supprimer">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- PAGINATION --}}
            @if($notifications->isNotEmpty())
                <div class="mt-8 pt-6 border-t border-[#2B5BBB]/30">
                    {{ $notifications->links() }}
                </div>
            @endif

            {{-- Décoration d'angle --}}
            <div class="absolute -top-1 -left-1 w-6 h-6 border-t-2 border-l-2 border-[#2BE7C6] opacity-80"></div>
            <div class="absolute -bottom-1 -right-1 w-6 h-6 border-b-2 border-r-2 border-[#2BE7C6] opacity-80"></div>
            <div class="absolute -top-1 -right-1 w-6 h-6 border-t-2 border-r-2 border-[#C2006D] opacity-80"></div>
            <div class="absolute -bottom-1 -left-1 w-6 h-6 border-b-2 border-l-2 border-[#C2006D] opacity-80"></div>
        </div>

    </div>
</div>

@endsection