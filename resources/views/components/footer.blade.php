@props(['class' => ''])

<footer {{ $attributes->merge(['class' => 'footer relative z-10 ' . $class]) }}>
    <div class="border-t border-border bg-card/90 backdrop-blur-sm py-8 mt-24">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-primary font-mono text-xs uppercase tracking-[0.3em] mb-2 animate-pulse">
                © {{ date('Y') }} SYSTEM OKRINA // IUT DE LENS
            </p>
            <p class="text-muted-foreground text-[12px] font-sans tracking-wide">
                INSERT COIN TO CONTINUE • <a href="#" class="hover:text-secondary hover:underline decoration-wavy underline-offset-4 transition-colors">CREDITS</a>
            </p>
        </div>
    </div>
</footer>
