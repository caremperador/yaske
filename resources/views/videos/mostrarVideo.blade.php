<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video en Pantalla Completa</title>
    @vite('resources/css/app.css')
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        .fullscreen-iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>

    @include('scripts.pa_antiadblock_7142069')
</head>
<body class="m-0 p-0 md:h-screen overflow-hidden bg-gray-900">
    <iframe src="{{ $videoUrl }}" class="absolute top-0 left-0 w-full h-full border-none" allowfullscreen>
        Tu navegador no soporta iframes.
    </iframe>
    <img src="https://whos.amung.us/widget/yaskevideos.png" style="display:none" />
    <!-- Incluir app.js al final del body -->
    @vite('resources/js/app.js')
</body>
</html>
