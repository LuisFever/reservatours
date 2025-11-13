<div class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full mx-4 p-10 relative animate-fadeIn">
        
        <h2 class="text-3xl font-bold mb-8 text-center text-gray-800">Elige tu plan de suscripción</h2>
        <p class="text-center text-gray-600 mb-10">
            Accede a la plataforma con el plan que mejor se adapte a tu negocio. 
        </p>
        
        @if (session('success'))
            <div class="bg-green-200 p-3 rounded mb-6 text-center text-green-800 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Plan Gratis -->
            <div class="border rounded-2xl p-8 shadow hover:shadow-xl transition flex flex-col">
                <h3 class="text-2xl font-semibold text-blue-600 mb-2">Plan Gratis</h3>
                <p class="text-gray-500 mb-6">Ideal para comenzar a probar la plataforma.</p>
                <ul class="text-sm text-gray-700 space-y-3 flex-1">
                    <li>✔ Subir hasta <strong>2 paquetes turísticos</strong>.</li>
                    <li>✔ Acceso limitado a herramientas de gestión.</li>
                    <li>✔ Soporte por correo electrónico básico.</li>
                    <li>✘ No incluye estadísticas avanzadas.</li>
                    <li>✘ No incluye personalización de marca.</li>
                </ul>
                <div class="mt-6">
                    <p class="text-2xl font-bold">S/0.00</p>
                    <p class="text-sm text-gray-500">por 1 mes</p>
                </div>
                <button wire:click="seleccionarPlan('gratis')" 
                    class="mt-6 bg-blue-500 text-white px-6 py-3 rounded-lg w-full font-semibold hover:bg-blue-600">
                    Seleccionar
                </button>
            </div>

            <!-- Plan Mensual -->
            <div class="border-2 border-green-500 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition flex flex-col bg-green-50">
                <h3 class="text-2xl font-semibold text-green-600 mb-2">Plan Mensual</h3>
                <p class="text-gray-500 mb-6">Perfecto para empresas activas.</p>
                <ul class="text-sm text-gray-700 space-y-3 flex-1">
                    <li>✔ Paquetes turísticos <strong>ilimitados</strong>.</li>
                    <li>✔ Todas las funcionalidades sin restricciones.</li>
                    <li>✔ Acceso a estadísticas avanzadas.</li>
                    <li>✔ Soporte prioritario por correo y chat.</li>
                    <li>✔ Personalización con tu marca.</li>
                </ul>
                <div class="mt-6">
                    <p class="text-3xl font-bold text-green-700">$50.00</p>
                    <p class="text-sm text-gray-500">por mes</p>
                </div>
                <button wire:click="seleccionarPlan('mensual')" 
                    class="mt-6 bg-green-600 text-white px-6 py-3 rounded-lg w-full font-semibold hover:bg-green-700">
                    Seleccionar
                </button>
            </div>

            <!-- Plan Anual -->
            <div class="border rounded-2xl p-8 shadow hover:shadow-xl transition flex flex-col">
                <h3 class="text-2xl font-semibold text-purple-600 mb-2">Plan Anual</h3>
                <p class="text-gray-500 mb-6">La mejor opción para ahorrar a largo plazo.</p>
                <ul class="text-sm text-gray-700 space-y-3 flex-1">
                    <li>✔ Paquetes turísticos <strong>ilimitados</strong>.</li>
                    <li>✔ Todas las funcionalidades sin restricciones.</li>
                    <li>✔ Acceso a estadísticas avanzadas.</li>
                    <li>✔ Soporte premium 24/7.</li>
                    <li>✔ Personalización completa de la plataforma.</li>
                    <li>💰 <strong>Descuento de hasta $500.00</strong>.</li>
                </ul>
                <div class="mt-6">
                    <p class="text-3xl font-bold text-purple-700">$500.00</p>
                    <p class="text-sm text-gray-500">por año</p>
                </div>
                <button wire:click="seleccionarPlan('anual')" 
                    class="mt-6 bg-purple-600 text-white px-6 py-3 rounded-lg w-full font-semibold hover:bg-purple-700">
                    Seleccionar
                </button>
            </div>
        </div>
    </div>
</div>
