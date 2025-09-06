<div class="max-w-3xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6">Elige tu plan de suscripción</h2>

    @if (session('success'))
        <div class="bg-green-200 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-3 gap-6">
        <div class="border rounded-lg p-6 shadow">
            <h3 class="text-lg font-semibold">Plan Gratis</h3>
            <p>1 paquete turístico • 1 mes gratis</p>
            <button wire:click="seleccionarPlan('gratis')" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                Seleccionar
            </button>
        </div>

        <div class="border rounded-lg p-6 shadow">
            <h3 class="text-lg font-semibold">Plan Mensual</h3>
            <p>Paquetes ilimitados • S/30 al mes</p>
            <button wire:click="seleccionarPlan('mensual')" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">
                Seleccionar
            </button>
        </div>

        <div class="border rounded-lg p-6 shadow">
            <h3 class="text-lg font-semibold">Plan Anual</h3>
            <p>Paquetes ilimitados • S/300 al año</p>
            <button wire:click="seleccionarPlan('anual')" class="mt-4 bg-purple-500 text-white px-4 py-2 rounded">
                Seleccionar
            </button>
        </div>
    </div>
</div>
