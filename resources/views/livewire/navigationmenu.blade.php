<nav x-data="{ open: false }" class="bg-gradient-to-r from-gray-800 via-emerald-600 to-emerald-500 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                {{-- <div class="shrink-0 flex items-center">
                    <a href="{{ route('inicioapp') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div> --}}
                <div class="flex-shrink-0 items-center">
                    <a href="{{ route('inicio') }}"
                        class="text-2xl font-extrabold tracking-wide hover:text-white text-2xl font-bold">
                        <span class="text-primary">Reserv</span><span class="text-yellow-100">Áncash</span>
                    </a>
                </div>

                <div class=" space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if ($userType == 'cliente')
                        {{-- Menú para Cliente --}}
                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('dashboard.cliente')">
                            {{ __('Mi Dashboard') }}
                        </x-nav-link>

                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('destinos')">
                            {{ __('Destinos') }}
                        </x-nav-link>

                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('servicios')">
                            {{ __('Servicios') }}
                        </x-nav-link>

                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('reservas.mis_reservas')">
                            {{ __('Mis Reservas') }}
                        </x-nav-link>

                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('empresas')">
                            {{ __('Empresas') }}
                        </x-nav-link>
                    @elseif ($userType == 'empresa')
                        {{-- Menú para Empresa --}}
                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('dashboard.empresa')">
                            {{ __('Mi Dashboard') }}
                        </x-nav-link>
                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('servicios.mis_servicios')">
                            {{ __('Mis Servicios') }}
                        </x-nav-link>
                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('equipos.mis_equipos')">
                            {{ __('Mis Equipos') }}
                        </x-nav-link>
                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('reservas.empresa')">
                            {{ __('Reservas') }}
                        </x-nav-link>
                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('paquetes')">
                            {{ __('Paquetes') }}
                        </x-nav-link>
                    @else
                        {{-- Menú por defecto (sin autenticar) --}}
                        <x-nav-link class="text-white font-bold text-lg" href="{{ route('dashboard') }}"
                            :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && Auth::check() && Auth::user()->currentTeam)
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}
                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>
                                    <x-dropdown-link href="{{ route('dashboard', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>
                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('dashboard') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200">
                                        </div>
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>
                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif


                <!-- Boton Usuario -->
                @auth
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">

                                    {{-- Logo o foto --}}
                                    @if (Auth::user()->display_logo)
                                        <img class="size-8 rounded-full object-cover"
                                            src="{{ Auth::user()->display_logo }}"
                                            alt="{{ Auth::user()->display_name }}" />
                                    @else
                                        {{-- Ícono de usuario genérico con Font Awesome --}}
                                        <div class="size-8 flex items-center justify-center bg-gray-200 rounded-full">
                                            <i class="fa-solid fa-user text-gray-500 text-lg"></i>
                                        </div>
                                    @endif

                                    {{-- Nombre --}}
                                    <span class="ml-2 text-gray-700 font-semibold truncate max-w-[150px]">
                                        {{ Auth::user()->display_name }}
                                    </span>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                    @if ($userType)
                                        <div class="text-blue-600 font-semibold">{{ ucfirst($userType) }}</div>
                                    @endif
                                </div>

                                <x-dropdown-link href="{{ route('dashboard') }}">
                                    <i class="fa-solid fa-id-card mr-2 text-gray-500"></i>
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        <i class="fa-solid fa-key mr-2 text-gray-500"></i>
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        <i class="fa-solid fa-right-from-bracket mr-2 text-red-500"></i>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white font-bold text-lg">
                        <i class="fa-solid fa-right-to-bracket mr-1"></i>
                        {{ __('Log in') }}
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 text-white font-bold text-lg">
                            <i class="fa-solid fa-user-plus mr-1"></i>
                            {{ __('Register') }}
                        </a>
                    @endif
                @endauth


            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if ($userType == 'cliente')
                {{-- Menú móvil para Cliente --}}
                <x-responsive-nav-link href="{{ route('dashboard.cliente') }}" :active="request()->routeIs('dashboard.cliente')">
                    {{ __('Mi Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('destinos')">
                    {{ __('Destinos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('servicios')">
                    {{ __('Servicios') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('reservas.mis_reservas')">
                    {{ __('Mis Reservas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('empresas')">
                    {{ __('Empresas') }}
                </x-responsive-nav-link>
            @elseif ($userType == 'empresa')
                {{-- Menú móvil para Empresa --}}
                <x-responsive-nav-link href="{{ route('dashboard.empresa') }}" :active="request()->routeIs('dashboard.empresa')">
                    {{ __('Mi Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('servicios.mis_servicios')">
                    {{ __('Mis Servicios') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('equipos.mis_equipos')">
                    {{ __('Mis Equipos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('reservas.empresa')">
                    {{ __('Reservas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('paquetes')">
                    {{ __('Paquetes') }}
                </x-responsive-nav-link>
            @else
                {{-- Menú móvil por defecto --}}
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 me-3">
                            <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>

                        @if ($userType)
                            <div class="text-xs text-blue-600 font-semibold">{{ ucfirst($userType) }}</div>
                        @endif
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-responsive-nav-link>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && Auth::user()->allTeams()->count() > 0)
                        <div class="border-t border-gray-200"></div>
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>
                        @if (Auth::user()->currentTeam)
                            <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                                :active="request()->routeIs('teams.show')">
                                {{ __('Team Settings') }}
                            </x-responsive-nav-link>
                        @endif

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                {{ __('Create New Team') }}
                            </x-responsive-nav-link>
                        @endcan
                        @if (Auth::user()->allTeams()->count() > 1)
                            <div class="border-t border-gray-200"></div>
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>
                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" component="responsive-nav-link" />
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        @endauth
    </div>
</nav>
