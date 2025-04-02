<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxHotel - @yield('title')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <style>
        /* Custom styles for cart icon badge */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            z-index: 10;
        }
    </style>
    @yield('styles')
    @vite('resources/css/app.css')
    @livewireStyles  
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
   
   @include('layouts.frontpage.header')
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.frontpage.footer') 
    @vite('resources/js/app.js')
    @yield('scripts')
    @livewireScripts
    @fluxScripts
</body>
</html>