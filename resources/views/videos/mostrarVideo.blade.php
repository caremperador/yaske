<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video en Pantalla Completa</title>
    @vite('resources/css/app.css')
    @if (!$isWebView)
        @include('scripts.pa_antiadblock_7142069')
    {{-- @else
        <script async="async" data-cfasync="false" src="//thubanoa.com/1?z=7144328"></script> --}}
    @endif
</head>

<body class="bg-gray-900">
    <!-- Iframe normal para navegadores web -->
    <iframe id="normal-iframe" src="{{ $videoUrl }}" class="absolute top-0 left-0 w-full h-full border-none"
        allowfullscreen>
        Tu navegador no soporta iframes.
    </iframe>
    <!-- Contenedor para Iframe específico de WebView de Android -->
    <div id="iframe-container" class="fixed inset-0 flex justify-center items-center bg-gray-900" style="display: none;">
        <iframe id="webview-iframe" src="{{ $videoUrl }}" class="w-full h-full border-none" allowfullscreen>
            Tu navegador no soporta iframes.
        </iframe>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var userAgent = navigator.userAgent.toLowerCase();
            var isAndroidWebView = userAgent.includes('wv');
            var normalIframe = document.getElementById('normal-iframe');
            var iframeContainer = document.getElementById('iframe-container');
            var webviewIframe = document.getElementById('webview-iframe');

            if (isAndroidWebView) {
                // Elimina el iframe normal y muestra el contenedor del iframe específico para WebView
                normalIframe.parentNode.removeChild(normalIframe);
                iframeContainer.style.display = 'flex';
            } else {
                // Elimina el contenedor del iframe específico para WebView
                webviewIframe.parentNode.removeChild(webviewIframe);
            }
        });
    </script>
    <img src="https://whos.amung.us/widget/yaskevideos.png" style="display:none" />
    @vite('resources/js/app.js')
</body>

</html>
