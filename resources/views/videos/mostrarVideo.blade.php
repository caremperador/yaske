<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video en Pantalla Completa</title>
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
</head>
<body>
    <iframe src="{{ $videoUrl }}" class="fullscreen-iframe" allowfullscreen>
        Tu navegador no soporta iframes.
    </iframe>
    <img src="https://whos.amung.us/widget/yaskevideos.png" style="display:none" />
</body>
</html>
