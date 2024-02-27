<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video en Pantalla Completa</title>
    @vite('resources/css/app.css')
    @include('scripts.pa_antiadblock_7142069')
</head>

<body class="bg-gray-900">

    <!-- Iframe normal para navegadores web -->
    <iframe id="normal-iframe" class="hidden absolute top-0 left-0 w-full h-full border-none"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        Tu navegador no soporta iframes.
    </iframe>

    <!-- Contenedor para Iframe específico de WebView de Android -->
    <div id="iframe-container" class="fixed inset-0 flex justify-center items-center bg-gray-900" style="display: none;">
        <iframe id="webview-iframe" class="w-full h-full p-20 border-none" allowfullscreen>
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
            var webviewIframe = document.getElementById('webview-iframe');

            // Configura el src del iframe apropiado según el contexto
            var videoSrc = "{{ $videoUrl }}";
            if (isAndroidWebView) {
                webviewIframe.src = videoSrc;
                iframeContainer.style.display = 'flex';
            } else {
                normalIframe.src = videoSrc;
                normalIframe.style.display = 'block';
            }
        });
    </script>

    <img src="https://whos.amung.us/widget/yaskevideos.png" style="display:none" />
    @vite('resources/js/app.js')
</body>
</html>
