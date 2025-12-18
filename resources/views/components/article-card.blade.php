@props(['article'])

@php
    $colors = ['#2858bb', '#c2006d', '#2be7c6'];
    $cartridgeColor = $colors[$article->id % count($colors)];
    $year = $article->created_at ? $article->created_at->format('Y') : '202X';
    $fullDate = $article->created_at ? $article->created_at->format('d/m/Y') : 'N/A';
    $wordCount = str_word_count(strip_tags($article->content ?? $article->resume ?? ''));
    $readTime = ceil($wordCount / 200) . ' MIN';
@endphp

{{-- Ajout de la classe "js-cartridge" pour le sélecteur JS --}}
<a href="{{ route('articles.show', $article) }}"
   class="js-cartridge group relative block cursor-pointer transition-all duration-300 hover:-translate-y-2 hover:scale-[1.01]">

    {{-- Curseur (Flèche gauche) --}}
    <div class="absolute -left-8 top-1/2 -translate-y-1/2 transition-all duration-200 opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0">
        <div class="font-orbitron text-2xl text-[#ffd60a] animate-pulse" style="text-shadow: 0 0 10px #ffd60a">
            ▶
        </div>
    </div>

    {{-- Cartouche --}}
    <div class="relative transition-all duration-300 group-hover:drop-shadow-[0_0_20px_{{ $cartridgeColor }}]">
        <div class="relative overflow-hidden"
             style="background-color: {{ $cartridgeColor }};
                    border-radius: 8px 8px 4px 4px;
                    border: 3px solid #1a1a1a;
                    box-shadow: inset -4px -4px 0 rgba(0,0,0,0.3), inset 4px 4px 0 rgba(255,255,255,0.1);">

            {{-- Grip --}}
            <div class="h-4 bg-black/20 flex items-center justify-center gap-1 px-4">
                @for($i = 0; $i < 12; $i++)
                    <div class="w-1 h-2 bg-black/30 rounded-sm"></div>
                @endfor
            </div>

            {{-- Étiquette --}}
            <div class="mx-3 my-2 p-4 relative overflow-hidden bg-[#0f0f23]"
                 style="border: 2px solid #000; border-radius: 2px; box-shadow: inset 0 0 20px rgba(0,0,0,0.5);">

                <div class="absolute inset-0 pointer-events-none opacity-20 z-10"
                     style="background: repeating-linear-gradient(0deg, transparent, transparent 1px, rgba(0,0,0,0.5) 1px, rgba(0,0,0,0.5) 2px);">
                </div>

                <div class="relative z-20">
                    <h3 class="font-orbitron text-lg font-black text-white mb-1 leading-tight tracking-tight line-clamp-2"
                        style="text-shadow: 2px 2px 0 #000; image-rendering: pixelated; min-height: 3rem;">
                        {{ $article->titre ?? 'SANS TITRE' }}
                    </h3>
                    <div class="inline-block px-2 py-0.5 bg-black/50 border border-white/30 mb-3 backdrop-blur-sm">
                        <span class="text-[10px] text-white/80 tracking-wider font-orbitron">{{ $fullDate }}</span>
                    </div>
                    <p class="font-montserrat text-xs text-white/90 leading-relaxed mb-2 line-clamp-3 h-[4.5em]" style="text-shadow: 1px 1px 0 #000">
                        {{ Illuminate\Support\Str::limit(strip_tags($article->resume ?? ''), 100) }}
                    </p>
                    @if($article->editeur)
                        <div class="flex items-center gap-2 mt-3 pt-2 border-t border-white/20">
                            <div class="flex gap-0.5 h-3 items-end">
                                @for($i = 0; $i < 4; $i++)
                                    <div class="w-1 bg-[#00ffff] transition-all duration-300 group-hover:animate-pulse"
                                         style="height: {{ 8 + sin($i * 1.5) * 6 }}px; animation-delay: {{ $i * 0.1 }}s">
                                    </div>
                                @endfor
                            </div>
                            <span class="text-[10px] text-[#00ffff] uppercase truncate max-w-[120px] font-orbitron">
                                {{ $article->editeur->name }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Pins --}}
            <div class="h-6 bg-[#1a1a1a] flex items-end justify-center gap-0.5 pb-1 mx-2 mb-2 rounded-b">
                @for($i = 0; $i < 30; $i++)
                    <div class="w-1 h-3 rounded-t-sm transition-colors duration-200 bg-[#3a3a3a] group-hover:bg-[#ffd60a]"></div>
                @endfor
            </div>
        </div>

        <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 bg-[#0a0a1a] border-2 border-[#00ffff] font-orbitron text-[10px] text-[#00ffff] shadow-[0_0_10px_#00ffff40]">
            {{ $readTime }} DE LECTURE
        </div>
    </div>
</a>
