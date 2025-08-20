<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Verificación de correo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <!-- <style rol="stylesheet" href="resources/css/app.css"></style> -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->

    <!-- Styles -->
    <!-- @livewireStyles -->
</head>

<body style="
            font-family: system-ui, -apple-system, Segoe UI, Roboto,
                'Helvetica Neue', Arial;
        ">
    <div style="
                max-width: 600px;
                margin: 0 auto;
                background: #ffffff;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid #e5e7eb;
            ">
        <div style="
                    background: #06d6a0;
                    color: #fff;
                    padding: 20px 24px;
                    text-align: center;
                ">
            <h1 style="margin: 0; font-size: 20px">
                CÓDIGO DE VERIFICACIÓN
            </h1>
        </div>
        <div style="padding: 24px; color: #111827">
            <h3 style="margin: 0 0 18px">
                Hola, somos ReservÁncash. <br /> Te damos la bienvenida, ya eres parte de nosotros.
            </h3>
            <div style="margin: 30px 50% 30px">
                <img src="{{ asset('Sin titulo.png') }}" alt="Logo" class="w-24 h-24 mb-4 rounded-full shadow" />
            </div>
            <p style="margin: 10px 20px 26px">Tu código es:</p>
            <div style="text-align: center; margin: 16px 0 20px">
                <span style="n
                            display: inline-block;
                            font-size: 28px;
                            letter-spacing: 6px;
                            padding: 12px 20px;
                            border: 1px dashed #c7d2fe;
                            border-radius: 10px;
                            background: #eef2ff;
                        ">
                        {{ $code }}
                    </span>
            </div>
            <p style="margin: 8px 0 0; color: #6b7280">
                Si no fuiste tú, ignora este mensaje.
            </p>
        </div>
        <div style="
                    padding: 16px 24px;
                    background: #f9fafb;
                    color: #6b7280;
                    font-size: 12px;
                    text-align: center;
                ">
            © {{ now()->year }} ReservaÁncash
        </div>
    </div>
</body>

</html>