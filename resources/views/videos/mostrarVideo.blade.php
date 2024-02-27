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
<div class="absolute inset-0 flex items-center justify-center  border">
<iframe src="{{ $videoUrl }}" class="block md:hidden w-[90%] h-[90%] border-none">
    Tu navegador no soporta iframes.
</iframe>
</div>

    <img src="https://whos.amung.us/widget/yaskevideos.png" style="display:none" />
    <!-- Incluir app.js al final del body -->
    @vite('resources/js/app.js')
</body>
</html>
