<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=atkinson-hyperlegible:400,400i,700,700i" rel="stylesheet"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-neutral-100 flex flex-col flex-between">

    @include('layouts.dev-mode')

    @include('layouts.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-neutral-100 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main class="bg-neutral-100 grow">
        <div class="mx-auto container mt-6 px-6 py-4 overflow-hidden ">
            {{ $slot }}
        </div>
    </main>

    <footer class="py-16 text-center text-sm text-black /70">
        {{--        Footer for guest layout here--}}
    </footer>

    @include('layouts.dev-mode')

</div>
</body>
</html>
