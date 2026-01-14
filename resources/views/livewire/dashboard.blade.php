<div>
    @if (!empty($userType))
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <a href="" class="text-2xl font-extrabold tracking-wide hover:text-yellow-300">
                            Reserv<span class="text-yellow-300">Ancash</span>
                        </a>
                        <h1 class="mt-8 text-2xl font-medium text-gray-900">
                            ¡Bienvenido {{ $userName ?? __('Usuario') }}!
                        </h1>
                        @if ($userType == 'cliente')
                            <p class="mt-6 text-gray-500 leading-relaxed">
                                Explora destinos increíbles, reserva tus viajes y gestiona tus reservas desde aquí.
                            </p>
                        @elseif ($userType == 'empresa')
                            <p class="mt-6 text-gray-500 leading-relaxed">
                                Administra tus servicios, revisa tus reservas y optimiza la experiencia de tus clientes.
                            </p>
                        @else
                            <p class="mt-6 text-gray-500 leading-relaxed">
                                Bienvenido, Administrador. Aquí puedes gestionar usuarios, supervisar reservas y
                                configurar ajustes del sistema.
                            </p>
                        @endif

                    </div>

                    <div
                        class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6 lg:p-8">
                        @foreach ($cards ?? [] as $card)
                            <div class="bg-white rounded-lg shadow p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $card['title'] }}</h3>
                                        <p class="text-sm text-gray-600">{{ $card['text'] }}</p>
                                    </div>
                                    <div class="bg-{{ $card['color'] }}-100 p-3 rounded-full">
                                        <i class="{{ $card['icon'] }} text-{{ $card['color'] }}-600 text-xl"></i>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ $card['route'] }}"
                                        class="text-{{ $card['color'] }}-600 hover:text-{{ $card['color'] }}-800 font-medium">{{ $card['linkText'] }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
