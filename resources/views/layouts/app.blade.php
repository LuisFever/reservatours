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
</head>

<body class="min-h-screen">
    {{-- Wrapper principal que garantiza que el contenido esté visible. --}}
    <div class="min-h-screen flex flex-col">
        <!-- Page Heading -->
        @livewire('menugeneral')

        {{-- Contenido principal --}}
        <main class="font-sans text-gray-900 antialiased flex-1">
            {{ $slot }}
        </main>

        <!-- Footer siempre al final -->
        <footer class="bg-gray-900 text-white py-8">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-bold mb-4">
                            <i class="fas fa-mountain mr-2 text-emerald-400"></i>
                            ReservaÁncash
                        </h3>
                        <p class="text-gray-400">Descubre los mejores destinos y experiencias turísticas con nuestros
                            servicios especializados.</p>
                    </div>
                    <div>
                        <h4 class="text-md font-bold mb-4">Enlaces rápidos</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition duration-300">
                                    <i class="fas fa-home mr-2"></i>Inicio</a></li>
                            <li><a href="#servicios"
                                    class="text-gray-400 hover:text-emerald-400 transition duration-300">
                                    <i class="fas fa-concierge-bell mr-2"></i>Servicios</a></li>
                            <li><a href="#contacto"
                                    class="text-gray-400 hover:text-emerald-400 transition duration-300">
                                    <i class="fas fa-envelope mr-2"></i>Contacto</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition duration-300">
                                    <i class="fas fa-blog mr-2"></i>Blog</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-md font-bold mb-4">Servicios</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition duration-300">
                                    <i class="fas fa-suitcase mr-2"></i>Paquetes turísticos</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition duration-300">
                                    <i class="fas fa-tools mr-2"></i>Alquiler de equipos</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition duration-300">
                                    <i class="fas fa-user-tie mr-2"></i>Guías especializados</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition duration-300">
                                    <i class="fas fa-bus mr-2"></i>Transporte</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-md font-bold mb-4">
                            <i class="fas fa-bell mr-2"></i>Suscríbete
                        </h4>
                        <p class="text-gray-400 mb-4">Recibe nuestras ofertas y novedades en tu correo.</p>
                        <form class="flex" onsubmit="handleSubscription(event)">
                            <input type="email" placeholder="Tu email" required
                                class="px-4 py-2 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 text-gray-800 w-full">
                            <button type="submit"
                                class="bg-primary hover:bg-yellow-500 px-4 py-2 rounded-r-lg transition duration-300">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2025 ReservaÁncash - Página del Grupo de Tecnología Web. Todos los derechos reservados.
                    </p>
                    <div class="flex justify-center space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition duration-300">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition duration-300">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition duration-300">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition duration-300">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>

</html>
