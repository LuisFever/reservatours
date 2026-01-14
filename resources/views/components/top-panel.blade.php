<!-- resources/views/components/top-panel.blade.php -->
<div class="flex-1 flex flex-col">
    <!-- Este slot vacío 'absorbe' cualquier cabecera no deseada de las vistas de Jetstream -->
    {{--  --}}

    <header
        class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-500 via-emerald-600 to-gray-700 border-b border-gray-200">
        <div>
            <!-- Aquí puedes agregar contenido adicional en el futuro, como un título de página dinámico -->
            <h1 class="text-2xl font-semibold text-white">Dashboard General</h1>
        </div>
        <div class="flex items-center">
            <!-- Settings Dropdown -->
            <div class="ms-3 relative">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                @if (Auth::user()->display_logo)
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->display_logo }}"
                                        alt="{{ Auth::user()->display_name }}" />
                                @else
                                    <div class="h-8 w-8 flex items-center justify-center bg-gray-200 rounded-full">
                                        <i class="fa-solid fa-user text-gray-500 text-lg"></i>
                                    </div>
                                @endif
                                <span class="ml-3 text-white font-semibold truncate max-w-[250px]">
                                    @php
                                        $userType = Auth::user()->tipousuarios
                                            ? strtolower(Auth::user()->tipousuarios->tipousu)
                                            : '';
                                    @endphp

                                    @if ($userType === 'cliente')
                                        {{ Auth::user()->personas->nombres . ' ' . Auth::user()->personas->apellidos }}
                                    @elseif ($userType === 'empresa')
                                        {{ Auth::user()->personas->nombres . ' ' . Auth::user()->personas->apellidos }}
                                    @elseif ($userType === 'superadmin')
                                        {{ explode('@', Auth::user()->email)[0] }}
                                    @endif

                                </span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Administrar cuenta') }}
                            </div>

                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>
        </div>
    </header>
</div>
