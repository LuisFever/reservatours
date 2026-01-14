<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaÁncash</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    @if (session('success'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)" 
            class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 text-center">
            {{ session('success') }}
        </div>
    @endif
    @if (session('warning'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 4000)" 
            class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-yellow-500 text-black px-6 py-3 rounded-lg shadow-lg z-50 text-center">
            {{ session('warning') }}
        </div>
    @endif
</head>

<body class="min-h-screen bg-gray-100">
    @if(Auth::check())
        <div class="flex">
            <x-sidebar />
            <div class="flex-1 flex flex-col">
                {{-- Usar componente Livewire de navegación en lugar de x-top-panel para control dinámico --}}
                @livewire('navigationmenu')
                <main class="flex-1 p-6 bg-gray-100">
                    {{ $slot }}
                </main>
            </div>
        </div>
    @else
        <div class="min-h-screen flex flex-col">
            <!-- Sidebar superior antes de Iniciar Sesion -->
            @livewire('menugeneral')
            <!-- Contenido del cuerpo -->
            <main class="font-sans text-gray-900 antialiased flex-1">
                {{ $slot }}
            </main>
            <!-- Footer -->
            <x-footer />
        </div>
    @endif

    @livewireScripts
</body>

</html>
