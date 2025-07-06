<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fruitfy Contact Challenge</title>
    <link rel="icon" type="image/png" href="https://app.fruitfy.io/assets/favicon.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="antialiased bg-gray-100 text-gray-900">
    @inertia
</body>
</html>
