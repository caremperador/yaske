<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video en Pantalla Completa</title>
    @vite('resources/css/app.css')
    
</head>
<body class="m-0 p-0 lg:h-screen overflow-hidden bg-gray-900">
    <iframe src="{{ $videoUrl }}" class="absolute top-0 left-0 w-full h-full border-none">
        Tu navegador no soporta iframes.
    </iframe>
    <img src="https://whos.amung.us/widget/yaskevideos.png" style="display:none" />
    <!-- Incluir app.js al final del body -->
    @vite('resources/js/app.js')
</body>
</html>
