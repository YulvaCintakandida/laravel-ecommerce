<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel E-Commerce</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
</head>
<body>
<main class="container mx-auto items-center min-h-screen flex justify-center w-full max-w-5xl px-4 sm:px-0">
    <div class="w-full md:w-2/3 lg:w-1/2">
        @yield('content')
    </div>
</main>
</body>
</html>
