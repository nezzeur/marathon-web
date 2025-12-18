@props(['class' => ''])

<footer {{ $attributes->merge(['class' => 'footer relative z-10 ' . $class]) }}>
    <div class="border-t border-border bg-card/90 backdrop-blur-sm py-8 mt-24">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <!-- Logo long à gauche -->
            <a href="{{ route('accueil') }}" class="flex-shrink-0">
                <img src="{{ asset('images/logo_long.png') }}" alt="OKARINA" class="h-10 object-contain hover:opacity-80 transition-opacity">
            </a>

            <!-- Texte à droite -->
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-white">
                © 2025 OKARINA
            </p>
        </div>
    </div>
</footer>
