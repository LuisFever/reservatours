<!-- Esto es el panel que esta al lado izquierdo cuando inicia sesion seun el tipo de usuario -->
<!-- resources/views/components/sidebar.blade.php -->
<div x-data="{ open: window.innerWidth >= 768 }" @resize.window="if (window.innerWidth >= 768) { open = true } else { open = false }">

    <!-- Mobile menu button -->
    <button 
        class="fixed top-4 left-4 z-20 p-2 rounded-md text-gray-500 bg-white shadow-md md:hidden" 
        @click="open = true" 
        x-show="!open"
        aria-label="Open sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </button>

    <!-- Overlay -->
    <div x-show="open && window.innerWidth < 768" 
         class="fixed inset-0 bg-black bg-opacity-50 z-30" 
         @click="open = false" 
         x-cloak>
    </div>

    <!-- Sidebar -->
    <div class="flex flex-col h-screen bg-gradient-to-r from-gray-700 via-emerald-600 to-emerald-500 text-white transition-all duration-300 z-40"
         :class="{
             'fixed top-0 left-0 transform translate-x-0': open && window.innerWidth < 768,
             'fixed top-0 left-0 transform -translate-x-full': !open && window.innerWidth < 768,
             'sticky top-0': window.innerWidth >= 768,
             'w-64': open,
             'w-20': !open && window.innerWidth >= 768
         }">
        
        <!-- Botón para colapsar/expandir -->
        <div class="flex items-center justify-between p-4">
            <a href="{{ route('inicio') }}" class="text-2xl font-extrabold tracking-wide hover:text-white" :class="open ? 'block' : 'hidden'">
                <span class="text-black">Reserv</span><span class="text-yellow-300">Áncash</span>
            </a>
            <button @click="open = !open" class="p-2 rounded-md hover:bg-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <!-- Enlaces de navegación -->
        <nav class="flex-1 px-2 space-y-1">
            @php
                $userType = Auth::check() && Auth::user()->tipousuarios ? strtolower(Auth::user()->tipousuarios->tipousu) : null;
            @endphp

            @if ($userType == 'cliente')
                {{-- Menú para Cliente --}}
                <x-nav-link-sidebar href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="fa-solid fa-user-circle">
                    <span x-show="open"><label class="text-white">{{ __('Mi Dashboard') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('destinos')" icon="fa-solid fa-map-marked-alt">
                    <span x-show="open"><label class="text-white">{{ __('Paquetes Generales') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('destinos')" icon="fa-solid fa-map-marked-alt">
                    <span x-show="open"><label class="text-white">{{ __('Pantalla Dividida') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('servicios')" icon="fa-solid fa-concierge-bell">
                    <span x-show="open"><label class="text-white">{{ __('Mis Reservas') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('reservas.mis_reservas')" icon="fa-solid fa-calendar-check">
                    <span x-show="open"><label class="text-white">{{ __('Favoritos') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('empresas')" icon="fa-solid fa-building">
                    <span x-show="open"><label class="text-white">{{ __('Historial') }}</label></span>
                </x-nav-link-sidebar>


            @elseif ($userType == 'empresa')
                {{-- Menú para Empresa --}}
                <x-nav-link-sidebar href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="fa-solid fa-tachometer-alt">
                    <span x-show="open"><label class="text-white">{{ __('Mi Dashboard') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="" :active="request()->routeIs('')" icon="fa-solid fa-user-circle">
                    <span x-show="open"><label class="text-white">{{ __('Mi Perfil') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('equipos.mis_equipos')" icon="fa-solid fa-tools">
                    <span x-show="open"><label class="text-white">{{ __('Mis Servicios') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('reservas.empresa')" icon="fa-solid fa-calendar-alt">
                    <span x-show="open"><label class="text-white">{{ __('Mis Equipos') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-box-open">
                    <span x-show="open"><label class="text-white">{{ __('Promociones') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-box-open">
                    <span x-show="open"><label class="text-white">{{ __('Paquetes') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-box-open">
                    <span x-show="open"><label class="text-white">{{ __('Reservas') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-box-open">
                    <span x-show="open"><label class="text-white">{{ __('Reportes') }}</label></span>
                </x-nav-link-sidebar>


            @elseif ($userType == 'superadmin')
                {{-- Menú para Empresa --}}
                <x-nav-link-sidebar href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="fa-solid fa-tachometer-alt">
                    <span x-show="open"><label class="text-white">{{ __('Mi Dashboard') }}</label></span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="{{ route('admin.vistausuarios') }}" :active="request()->routeIs('admin.vistausuarios')" icon="fa-solid fa-users-cog">
                    <span x-show="open">{{ __('Gestión de Usuarios') }}</span>
                </x-nav-link-sidebar>
                {{--<x-nav-link-sidebar href="#" :active="request()->routeIs('reservas.empresa')" icon="fa-solid fa-building">
                    <span x-show="open">{{ __('Gestón de Empresas') }}</span>
                </x-nav-link-sidebar>--}}
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-box-open">
                    <span x-show="open">{{ __('Reportes') }}</span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-book-open">
                    <span x-show="open">{{ __('Gestión de Reservas') }}</span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-headset">
                    <span x-show="open">{{ __('Soporte y Feedback') }}</span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-cogs">
                    <span x-show="open">{{ __('Configuraciones') }}</span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-chart-line">
                    <span x-show="open">{{ __('Métricas de Marketing') }}</span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-folder-open">
                    <span x-show="open">{{ __('Gestión de Contenidos') }}</span>
                </x-nav-link-sidebar>
                <x-nav-link-sidebar href="#" :active="request()->routeIs('paquetes')" icon="fa-solid fa-user-shield">
                    <span x-show="open">{{ __('Sesiones de Administración') }}</span>
                </x-nav-link-sidebar>
            @else
                {{-- Menú por defecto --}}
                <x-nav-link-sidebar href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="fa-solid fa-tachometer-alt">
                    <span x-show="open">{{ __('Dashboard') }}</span>
                </x-nav-link-sidebar>
            @endif
        </nav>
    </div>
</div>
