<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video en Pantalla Completa</title>
    @vite('resources/css/app.css')
    
</head>
<body class=" bg-gray-900">

    <!-- Este iframe se muestra en pantallas md hacia arriba -->
<iframe src="{{ $videoUrl }}" class="hidden md:block absolute top-0 left-0 w-full h-full border-none">
    Tu navegador no soporta iframes.
</iframe>

<!-- Este iframe se muestra solo en pantallas menores a md -->
<iframe src="{{ $videoUrl }}" class="block md:hidden absolute top-0 left-0 w-[200px] h-[200px] border-none">
    Tu navegador no soporta iframes.
</iframe>

    <img src="https://whos.amung.us/widget/yaskevideos.png" style="display:none" />
    <!-- Incluir app.js al final del body -->
    @vite('resources/js/app.js')
</body>
</html>
