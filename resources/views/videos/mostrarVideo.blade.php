<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video en Pantalla Completa</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900">

    <!-- Iframe normal para navegadores web -->
    <iframe id="normal-iframe" src="{{ $videoUrl }}" class="hidden absolute top-0 left-0 w-full h-full border-none"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        Tu navegador no soporta iframes.
    </iframe>

    <!-- Contenedor para Iframe específico de WebView de Android -->
    <div id="iframe-container" class="fixed inset-0 flex justify-center items-center bg-gray-900 border" style="display: none;">

        <iframe id="webview-iframe" src="{{ $videoUrl }}" class="w-full h-full p-20 border-none" allowfullscreen>
            Tu navegador no soporta iframes.
        </iframe>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var userAgent = navigator.userAgent.toLowerCase();
            var isAndroidWebView = userAgent.includes('wv');

            // Obtén referencias al contenedor del iframe y al iframe normal
            var normalIframe = document.getElementById('normal-iframe');
            var iframeContainer = document.getElementById('iframe-container');

            if (isAndroidWebView) {
                // Muestra el contenedor del iframe específico para WebView y oculta el iframe normal
                iframeContainer.style.display = 'flex';
            } else {
                // Muestra el iframe normal
                normalIframe.style.display = 'block';
            }
        });
    </script>

    <img src="https://whos.amung.us/widget/yaskevideos.png" style="display:none" />
    @vite('resources/js/app.js')
</body>

</html>
