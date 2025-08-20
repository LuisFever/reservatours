<div>
    <style>
        /* Animaciones personalizadas que no se pueden replicar directamente con clases de Tailwind */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                obcity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
    <div class="font-sans antialiased text-gray-800 bg-gray-50 min-h-screen leading-relaxed">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <button type="button" class="text-green-700 hover:text-green-900">
                        <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Cerrar</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 01-1.697 0L10 11.854l-2.651 2.995a1.2 1.2 0 11-1.697-1.697l2.995-2.651-2.995-2.651a1.2 1.2 0 011.697-1.697L10 8.146l2.651-2.995a1.2 1.2 0 111.697 1.697L11.854 10l2.995 2.651a1.2 1.2 0 010 1.698z" />
                        </svg>
                    </button>
                </span>
            </div>
        @endif

        <div class="flex min-h-screen items-center justify-center p-4 bg-gradient-to-br from-gray-300 to-gray-200">
            <div
                class="w-full max-w-5xl bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row border border-purple-200 transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 animate-fade-in">

                {{-- PANEL IZQUIERDO --}}
                <div class="md:w-1/2 to-emerald-600 text-white p-8 md:p-12 flex flex-col justify-center     relative overflow-hidden"
                    style="background: linear-gradient(to bottom right, #06D6A0, var(--tw-gradient-to));">
                    <div class="absolute top-[-50px] right-[-50px] w-48 h-48 rounded-full bg-white bg-opacity-10"></div>
                    <div class="absolute bottom-[-80px] left-[-80px] w-64 h-64 rounded-full bg-white bg-opacity-5">
                    </div>
                    <div class="mb-8 z-10 text-center md:text-left">
                        <div
                            class="w-20 h-20 rounded-full bg-white bg-opacity-15 flex items-center justify-center mx-auto md:mx-0 shadow-lg border-2 border-white border-opacity-25">
                            <i class="fas fa-mountain text-4xl"></i>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold mb-2 text-center md:text-left z-10">ReservaÁncash</h1>
                    <p
                        class="text-white text-opacity-85 text-base text-center md:text-left z-10 max-w-xs mx-auto md:mx-0">
                        Descubre los mejores destinos con nosotros
                    </p>

                    <div class="mt-8 z-10">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-8 h-8 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <span>Destinos exclusivos</span>
                        </div>
                        <div class="flex items-center mb-4">
                            <div
                                class="w-8 h-8 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <span>Reservas seguras</span>
                        </div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-headset"></i>
                            </div>
                            <span>Soporte 24/7</span>
                        </div>
                    </div>
                </div>

                {{-- PANEL DERECHO --}}
                <div class="md:w-1/2 p-8 md:p-12">
                    <h2 class="text-2xl font-bold mb-6 text-primary"> Crear Cuenta </h2>
                    {{-- <form method="POST" enctype="multipart/form-data" id="registerForm"> --}}

                    {{-- Parte Tipo de usuario --}}
                    @csrf
                    <div class="mb-6">
                        <h3 class="text-base font-semibold mb-4 text-primary flex   items-center gap-2">
                            <i class="fas fa-user-tag text-primary"></i> Tipo de Usuario
                        </h3>
                        <div class="flex flex-col sm:flex-row gap-4 mb-6">
                            <div class="flex-1 p-4 text-center bg-purple-50 border border-purple-200 rounded-lg cursor-pointer transition-all duration-300 hover:bg-yellow-100 hover:border-yellow-500 user-type-option active"
                                wire:click="setUserType('client')">
                                <div class="text-2xl mb-2 text-purple-700">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div class="font-medium text-primary text-sm">Cliente</div>
                                <input type="hidden" name="user_type" value="3">
                            </div>
                            <div class="flex-1 p-4 text-center bg-purple-50 border border-purple-200 rounded-lg cursor-pointer transition-all duration-300 hover:bg-yellow-100 hover:border-yellow-500 user-type-option"
                                wire:click="setUserType('company')">
                                <div class="text-2xl mb-2 text-purple-700">
                                    <i class="fas fa-building text-primary"></i>
                                </div>
                                <div class="font-medium text-primary text-sm">Empresa</div>
                                <input type="hidden" name="user_type" value="2">
                            </div>
                        </div>
                    </div>
                    {{-- Opcion CLiente --}}
                    @if ($userType === 'client')
                        <div id="client-section" class="mb-6">
                            <h3 class="text-base font-semibold mb-4 text-primary flex items-center gap-2">
                                <i class="fas fa-id-card text-primary"></i> Información Personal
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4 md:mb-0">
                                    <label class="block text-gray-700 text-sm font-medium mb-1" for="document_type">Tipo
                                        de
                                        Documento</label>
                                    <select
                                        class="w-full px-4 py-2 text-sm bg-white border border-gray-300 rounded-md text-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-400"
                                        id="document_type" name="document_type" required>
                                        <option value="dni">DNI</option>
                                    </select>
                                </div>
                                <div class="mb-4 md:mb-0">
                                    <label class="block text-gray-700 text-sm font-medium mb-1" for="dni">Número
                                        de Documento</label>
                                    <div
                                        class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                        <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                            <i class="fas fa-id-card text-primary"></i>
                                        </span>
                                        <input
                                            class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                            type="text" id="document_number" name="document_number" maxlength="8"
                                            required wire:model.live="dni" wire:keydown.enter="buscarDni"
                                            placeholder="Ingrese DNI y Enter">
                                        @error('dni')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-4 md:mb-0">
                                    <label class="block text-gray-700 text-sm font-medium mb-1"
                                        for="nombres">Nombres</label>
                                    <div
                                        class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                        <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                            <i class="fas fa-user text-primary"></i>
                                        </span>
                                        <input
                                            class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                            type="text" id="nombres" name="nombres" wire:model.live="nombres"
                                            required readonly>
                                    </div>
                                </div>
                                <div class="mb-4 md:mb-0">
                                    <label class="block text-gray-700 text-sm font-medium mb-1"
                                        for="apellidos">Apellidos</label>
                                    <div
                                        class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                        <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                            <i class="fas fa-user text-primary"></i>
                                        </span>
                                        <input
                                            class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                            type="text" id="apellidos" name="apellidos"
                                            wire:model.live="apellidos" required readonly>
                                    </div>
                                </div>
                                <div class="mb-4 md:mb-0">
                                    <label class="block text-gray-700 text-sm font-medium mb-1"
                                        for="telefono">Teléfono</label>
                                    <div
                                        class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                        <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                            <i class="fas fa-phone text-primary"></i>
                                        </span>
                                        <input
                                            class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                            type="tel" id="telefono" name="telefono" maxlength="9" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Opcion Empresa --}}
                    @if ($userType === 'company')
                        <div id="company-section" class="mb-6">
                            <div class="mb-6">
                                <h3 class="text-base font-semibold mb-4 text-primary flex items-center gap-2">
                                    <i class="fas fa-building text-primary"></i> Información de la Empresa
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4 md:mb-0">
                                        <label class="block text-gray-700 text-sm font-medium mb-1"
                                            for="nombre_empresa">Nombre de la Empresa</label>
                                        <div
                                            class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                            <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                                <i class="fas fa-trademark text-primary"></i>
                                            </span>
                                            <input
                                                class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                                type="text" id="nomeempresa" name="nameempresa"
                                                wire:model.live="nameempresa">
                                        </div>
                                    </div>
                                    <div class="mb-4 md:mb-0">
                                        <label class="block text-gray-700 text-sm font-medium mb-1"
                                            for="ruc">RUC</label>
                                        <div
                                            class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                            <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                                <i class="fas fa-hashtag text-primary"></i>
                                            </span>
                                            <input
                                                class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                                type="text" id="ruc" name="ruc" maxlength="11"
                                                wire:model.live="ruc" wire:keydown.enter="buscarRUC"
                                                placeholder="Ingrese RUC y Enter">
                                            @error('ruc')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 md:mb-0">
                                        <label class="block text-gray-700 text-sm font-medium mb-1"
                                            for="razon_social">Razón Social</label>
                                        <div
                                            class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                            <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                                <i class="fas fa-file-signature text-primary"></i>
                                            </span>
                                            <input
                                                class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                                type="text" id="razonsocial" name="razonsocial"
                                                wire:model.live="razonsocial" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-4 md:mb-0">
                                        <label class="block text-gray-700 text-sm font-medium mb-1"
                                            for="direccion_empresa">Dirección</label>
                                        <div
                                            class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                            <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                                <i class="fas fa-map-marker-alt text-primary"></i>
                                            </span>
                                            <input
                                                class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                                type="text" id="direccion" name="direccion"
                                                wire:model.live="direccion">
                                        </div>
                                    </div>
                                    <div class="mb-4 md:mb-0">
                                        <label class="block text-gray-700 text-sm font-medium mb-1"
                                            for="telefono_empresa">Teléfono Empresa</label>
                                        <div
                                            class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                            <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                                <i class="fas fa-phone-alt text-primary"></i>
                                            </span>
                                            <input
                                                class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                                type="tel" id="telefono_empresa" name="telefono_empresa"
                                                maxlength="9">
                                        </div>
                                    </div>
                                    <div class="mb-4 md:mb-0">
                                        <label class="block text-gray-700 text-sm font-medium mb-1"
                                            for="logo_empresa">Logo de la Empresa</label>
                                        <div class="relative w-full">
                                            <input type="file"
                                                class="absolute inset-0 opacity-0 w-full h-full cursor-pointer"
                                                id="logo_empresa" name="logo_empresa" accept="image/*">
                                            <label
                                                class="flex items-center justify-center px-4 py-2 bg-white border border-dashed border-gray-300 rounded-md text-gray-500 text-sm transition-all duration-300 hover:border-purple-400 hover:text-gray-800"
                                                for="logo_empresa">
                                                <i class="fas fa-cloud-upload-alt mr-2 text-xs"></i> Subir Logo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-base font-semibold mb-4  text-primary flex items-center gap-2">
                                    <i class="fas fa-user-tie text-primary"></i> Representante Legal
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4 md:mb-0">
                                        <label class="block text-gray-700 text-sm font-medium mb-1"
                                            for="doc_type_representante">Tipo de Documento</label>
                                        <select
                                            class="w-full px-4 py-2 text-sm bg-white border border-gray-300 rounded-md text-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-400"
                                            id="doc_type_representante" name="doc_type_representante">
                                            <option value="dni">DNI</option>
                                        </select>
                                    </div>
                                    <div class="mb-4 md:mb-0">
                                        <label class="block text-gray-700 text-sm font-medium mb-1"
                                            for="doc_number_representante">Número de Documento</label>
                                        <div
                                            class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                            <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                                <i class="fas fa-id-card text-primary"></i>
                                            </span>
                                            <input
                                                class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                                type="text" id="dni" name="dni" maxlength="8"
                                                wire:model.live="dni" wire:keydown.enter="buscarDni"
                                                placeholder="Ingrese DNI y Enter">
                                        </div>
                                    </div>
                                    <div class="mb-4 md:mb-0">
                                        <label class="block text-gray-700 text-sm font-medium mb-1"
                                            for="nombres_representante">Nombres</label>
                                        <div
                                            class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                            <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                                <i class="fas fa-user text-primary"></i>
                                            </span>
                                            <input
                                                class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                                type="text" id="nombres" name="nombres"
                                                wire:model.live="nombres" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-4 md:mb-0">
                                        <label class="block text-gray-700 text-sm font-medium mb-1"
                                            for="apellidos_representante">Apellidos</label>
                                        <div
                                            class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                            <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                                <i class="fas fa-user text-primary"></i>
                                            </span>
                                            <input
                                                class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                                type="text" id="apellidos" name="apellidos"
                                                wire:model.live="apellidos" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Datos de Acesso --}}
                    <div class="mb-6">
                        <h3 class="text-base font-semibold mb-4 text-primary flex items-center gap-2">
                            <i class="fas fa-key text-primary"></i> Datos de Acceso
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4 md:mb-0">
                                <label class="block text-gray-700 text-sm font-medium mb-1" for="email">Correo
                                    Electrónico</label>
                                <div
                                    class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                    <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </span>
                                    <input
                                        class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                        type="email" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-4 md:mb-0">
                                <label class="block text-gray-700 text-sm font-medium mb-1">Verificación</label>
                                <button type="button"
                                    class="w-full inline-flex items-center justify-center px-6 py-2 text-sm font-medium rounded-md text-white bg-primary hover:bg-yellow-500 transition-all duration-300"
                                    id="verifyEmailButton">
                                    <i class="fas fa-check mr-2"></i> Verificar
                                </button>
                            </div>
                            <div class="mb-4 md:mb-0">
                                <label class="block text-gray-700 text-sm font-medium mb-1"
                                    for="password">Contraseña</label>
                                <div
                                    class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                    <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                        <i class="fas fa-lock text-primary"></i>
                                    </span>
                                    <input
                                        class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                        type="password" id="password" name="password" required disabled>
                                </div>
                            </div>
                            <div class="mb-4 md:mb-0">
                                <label class="block text-gray-700 text-sm font-medium mb-1"
                                    for="password_confirmation">Confirmar Contraseña</label>
                                <div
                                    class="flex items-center bg-white border border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-purple-200 focus-within:border-purple-400">
                                    <span class="px-3 py-2 bg-purple-50 text-purple-700 text-sm">
                                        <i class="fas fa-lock text-primary"></i>
                                    </span>
                                    <input
                                        class="w-full px-4 py-2 text-sm bg-transparent border-none focus:outline-none focus:ring-0"
                                        type="password" id="password_confirmation" name="password_confirmation"
                                        required disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Botones de registro e Inicio Sesion --}}
                    <div class="pt-6 flex justify-between items-center border-t border-gray-200 mt-6">
                        <a href="#"
                            class="text-primary text-sm font-medium transition-colors duration-300 hover:text-yellow-500 flex items-center gap-2">
                            <i class="fas fa-arrow-left text-primary"></i> ¿Ya tienes cuenta? Inicia sesión
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium rounded-md text-white bg-primary hover:bg-yellow-500 transition-all duration-300 transform hover:-translate-y-px"
                            id="registerButton">
                            <i class="fas fa-user-plus mr-2"></i> Registrarse
                        </button>
                    </div>
                    {{-- </form> --}}

                    @if (session('error'))
                        <div id="errorAlert"
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mt-4 text-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>{{ session('error') }}</span>
                                <button onclick="closeAlert('errorAlert')"
                                    class="ml-auto text-red-700 hover:text-red-900 text-xl leading-none">&times;</button>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div id="validationAlert"
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mt-4 text-sm">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-exclamation-triangle mt-1"></i>
                                <div>
                                    <strong class="font-bold">Errores en el formulario:</strong>
                                    <ul class="list-disc ml-6 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button onclick="closeAlert('validationAlert')"
                                    class="ml-auto text-red-700 hover:text-red-900 text-xl leading-none">&times;</button>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- PANEL MODAL --}}
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden"
            id="verificationModal">
            <div class="bg-white rounded-lg shadow-lg max-w-sm w-full">
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Verificación de Correo</h3>
                    <button type="button" class="text-gray-600 hover:text-gray-800 transition-colors"
                        id="closeModalButtonX"><i class="fas fa-window-close fa-2x"></i></button>
                </div>
                <div class="p-4">
                    <p class="text-gray-700">Se ha enviado un código de verificación a <strong
                            id="modalEmailDisplay"></strong>. Por
                        favor, revisa tu bandeja de entrada (incluyendo spam).</p>
                    <input type="text" id="verificationCode"
                        class="mt-4 p-2 border border-gray-300 rounded-md w-full text-sm bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-400"
                        placeholder="Código de verificación" maxlength="6">
                    <div id="modalAlerts" class="mt-3"></div>
                </div>
                <div class="flex justify-end p-4 border-t">
                    <button type="button"
                        class="bg-gray-300 text-gray-700 hover:bg-gray-400 rounded-md px-6 py-2 mr-2 transition-colors duration-200">
                        Cerrar
                    </button>
                    {{-- <button type="button"
                        class="bg-primary text-white hover:bg-yellow-500 rounded-md px-6 py-2 transition-colors duration-200">
                        Verificar
                    </button> --}}
                    <button type="button" class="bg-blue-500 text-white hover:bg-blue-600 rounded px-4 py-2 mr-2"
                        id="resendCodeButton">Reenviar Código</button>
                    <button type="button" class="bg-green-500 text-white hover:bg-green-600 rounded px-6 py-2"
                        id="validateCodeButton">Validar</button>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('verifyEmailButton').addEventListener('click', function() {
                const email = document.getElementById('email').value;

                if (!email) {
                    alert("Por favor ingresa un correo válido.");
                    return;
                }

                fetch('/email/send-code', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            email
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('modalEmailDisplay').innerText = email;
                            document.getElementById('verificationModal').classList.remove('hidden');
                        } else {
                            alert(data.message);
                        }
                    });
            });

            // Validar código
            document.getElementById('validateCodeButton').addEventListener('click', function() {
                const email = document.getElementById('email').value;
                const code = document.getElementById('verificationCode').value;

                fetch('/email/validate-code', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            email,
                            code
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        const alerts = document.getElementById('modalAlerts');
                        alerts.innerHTML = '';

                        if (data.success) {
                            alerts.innerHTML = '<p class="text-green-600">✅ ' + data.message + '</p>';
                            // Habilitar contraseñas
                            document.getElementById('password').disabled = false;
                            document.getElementById('password_confirmation').disabled = false;
                            // Cerrar modal después de unos segundos
                            setTimeout(() => {
                                document.getElementById('verificationModal').classList.add('hidden');
                            }, 1500);
                        } else {
                            alerts.innerHTML = '<p class="text-red-600">❌ ' + data.message + '</p>';
                        }
                    });
            });
        </script>
    </div>
</div>
