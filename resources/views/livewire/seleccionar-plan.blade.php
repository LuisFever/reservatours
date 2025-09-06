<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Selecciona un plan</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($planes as $plan)
            <div class="p-6 border rounded shadow">
                <h3 class="text-xl font-semibold">{{ $plan->nombre }}</h3>
                <p class="text-gray-600">Precio: S/. {{ $plan->precio }}</p>
                <p class="text-gray-600">Duración: {{ $plan->duracion_dias }} días</p>
                <p class="text-gray-600">
                    Límite de paquetes: {{ $plan->limite_paquetes ?? 'Ilimitado' }}
                </p>
                <button wire:click="seleccionar({{ $plan->id }})" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
                    Seleccionar
                </button>
            </div>
        @endforeach
    </div>
</div>
