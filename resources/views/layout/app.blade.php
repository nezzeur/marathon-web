<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{isset($title) ? $title : "Page en cours"}}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

@vite(["resources/css/normalize.css", 'resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<x-header />
<x-navigation />

<main>
    @yield("contenu")
</main>

<x-footer />
<x-notifications />
</body>
</html>
