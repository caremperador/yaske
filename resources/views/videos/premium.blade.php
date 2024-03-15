<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video en Pantalla Completa</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="max-w-md p-8 bg-gray-800 rounded-lg shadow-lg text-center space-y-4">
        <p class="text-2xl font-bold text-white">¡Este video es premium!</p>
        <p class="text-gray-400">Necesitas ser usuario premium para verlo.<br>
        Haz clic aquí para comprar 1 día premium.</p>
        <a href="{{ route('seleccionarRevendedor') }}" target="_blank" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200">Comprar</a>
        <div class="pt-4">
            <p class="font-semibold text-lg">Beneficios de ser Premium</p>
            <ul class="text-gray-400 text-left space-y-2 mt-2">
                <li>🌟 Ver videos sin publicidad</li>
                <li>🌟 Ver videos en calidad HD</li>
                <li>🌟 Ver videos en pantalla completa</li>
                <li>🌟 Ver videos en tu celular</li>
                <li>🌟 Ver videos en tu smart tv</li>
            </ul>
        </div>
    </div>
    <img src="https://whos.amung.us/widget/yaskepremium.png" style="display:none" />
    @vite('resources/js/app.js')
</body>

</html>
