<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{isset($title) ? $title : "Page en cours"}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
<x-header/>
<x-navigation/>
<x-welcome-message />
<main>
    @yield("contenu")
</main>

<x-footer />
<x-notifications />
</body>
</html>
