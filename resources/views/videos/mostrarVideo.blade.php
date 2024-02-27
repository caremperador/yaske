<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video en Pantalla Completa</title>
    @vite('resources/css/app.css')
</head>
<body class=" bg-gray-900">

    <!-- Iframe para navegadores normales y WebView -->
    <iframe id="normal-iframe" src="{{ $videoUrl }}" class="absolute top-0 left-0 w-full h-full border-none" style="display: none;">
        Tu navegador no soporta iframes.
    </iframe>

    <!-- Iframe específico para WebView de Android -->
    <iframe id="webview-iframe" src="{{ $videoUrl }}" class="absolute top-0 left-0 w-[200px] h-[200px] border-none" style="display: none;">
        Tu navegador no soporta iframes.
    </iframe>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var userAgent = navigator.userAgent.toLowerCase();
            var isAndroidWebView = userAgent.includes('wv');

            // Obtén referencias a ambos iframes
            var normalIframe = document.getElementById('normal-iframe');
            var webviewIframe = document.getElementById('webview-iframe');

            if (isAndroidWebView) {
                // Muestra el iframe específico para WebView y oculta el normal
                webviewIframe.style.display = 'block';
            } else {
                // Muestra el iframe normal y oculta el específico para WebView
                normalIframe.style.display = 'block';
            }
        });
    </script>

    <img src="https://whos.amung.us/widget/yaskevideos.png" style="display:none" />
    <!-- Incluir app.js al final del body -->
    @vite('resources/js/app.js')
</body>
</html>
