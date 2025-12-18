@props(['class' => ''])

@php
    $isFirstVisit = !request()->cookie('okrina_visited');
@endphp

@if($isFirstVisit)
    <div {{ $attributes->merge(['class' => 'welcome-message ' . $class]) }}>
        <div class="welcome-content">
            <h3>🎮 Bienvenue sur OKARINA</h3>
            <p>Si c'est votre première visite du site, ici vous retrouverez différents articles sur les musiques de jeux-vidéos, publiés tous les jours par nos rédacteurs et la communauté.</p>
        </div>
        <button class="welcome-close" onclick="this.parentElement.style.display='none'">×</button>
    </div>
@endif
