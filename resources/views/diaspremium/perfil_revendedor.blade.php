@php
use Carbon\Carbon;

$fotoPerfil = $revendedor->foto_perfil ? Storage::url($revendedor->foto_perfil) : null;
$estadoConectado = $revendedor->estado_conectado ? '<i class="fas fa-circle" style="color: green;"></i>' : '<i class="fas fa-circle" style="color: red;"></i>';
$ultimoConexion = $revendedor->ultimo_conexion ? Carbon::parse($revendedor->ultimo_conexion)->locale('es')->diffForHumans() : 'N/A';
$slug = $revendedor->slug ?? null; // Asegúrate de que 'slug' esté disponible en el objeto $revendedor
@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Revendedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    @vite('resources/css/app.css')
</head>

<body class="bg-black text-gray-100">

    <div class="container mx-auto px-4 md:px-0">
        <div class="md:flex md:items-start py-8">

            <!-- Sidebar -->
            <div class="md:w-1/4">
            
            
            @if ($slug)
                <a href="{{ route('perfilRevendedor', $slug) }}">
                    @if ($fotoPerfil)
                        <img src="{{ $fotoPerfil }}" alt="Profile" class="rounded-full w-32 h-32 mx-auto md:mx-0">
                    @else
                        <i class="fas fa-user-circle fa-10x text-gray-400"></i>
                    @endif
                </a>
            @else
                <i class="fas fa-user-circle fa-10x text-gray-400"></i>
            @endif
            
                <div class="text-center md:text-left mt-4">
                    <h2 class="text-lg font-semibold">{{ $revendedor->name }}</h2>
                    <p class="text-sm">Precio del dia: {{ $revendedor->precio }}</p>
                    <p class="text-sm">Cantidad Minima de compra: {{ $revendedor->cantidad_minima }}</p>
                    <p class="text-sm">Dias Disponibles en venta: {{ $revendedor->dias_revendedor_premium }}</p>
                    <p class="text-sm">Pais: {{ $revendedor->pais }}</p>
                    <p class="text-sm">Estatus: {!! $estadoConectado !!} - {{ $ultimoConexion }}</p>
                    
                    <!-- Social Icons -->
                    <!-- Social Icons -->
                    <div class="flex justify-center md:justify-start space-x-4 mt-4">
                        @if ($revendedor->link_whatsapp)
                            <a href="{{ $revendedor->link_whatsapp }}" class="text-green-500 hover:text-blue-700"
                                target="_blank" title="Grupo de WhatsApp">
                                <i class="fab fa-whatsapp fa-2x"></i>
                            </a>
                        @endif
                        @if ($revendedor->link_telegram)
                            <a href="{{ $revendedor->link_telegram }}" class="text-blue-500 hover:text-blue-700"
                                target="_blank" title="Canal de Telegram">
                                <i class="fab fa-telegram-plane fa-2x"></i>
                            </a>
                        @endif
                    </div>
                    <div class="flex justify-center md:justify-start mt-4">
                        @auth
                            <!-- Botón visible solo para usuarios logueados -->
                            <a href="{{ route('envio_comprobante.index', ['seller_id' => $revendedor->user_id]) }}"
                                class="inline-block bg-gradient-to-r mb-3 from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300 ease-in-out hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                                Comprame días
                            </a>
                        @endauth

                        @guest
                            <!-- Botón visible solo para usuarios no logueados -->
                            <a href="{{ $revendedor->link_whatsapp }}"
                                class="inline-block bg-gradient-to-r mb-3 from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300 ease-in-out hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                                Solicitame Token de acceso
                            </a>
                        @endguest
                    </div>


                </div>
            </div>

            <!-- Main Content -->
            <div class="md:ml-8 md:w-3/4">
                <!-- About -->
                <div class="bg-gray-800 p-4 rounded-lg">
                    <h3 class="font-semibold border-b border-gray-700 pb-2">BIENVENIDO A MI PERFIL</h3>
                    <p class="mt-3">{{ $revendedor->mensaje_perfil }}</p>
                </div>
                <!-- Estadisticas -->
                <div class="bg-gray-800 p-4 rounded-lg mt-4 shadow-lg">
                    <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">MIS ESTADÍSTICAS</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-gray-700 rounded-lg p-4 shadow">
                            <p class="text-white text-lg">Transacciones Exitosas</p>
                            <p class="text-white text-2xl font-bold">{{ $revendedor->transacciones_exitosas }}</p>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-4 shadow">
                            <p class="text-white text-lg">Transacciones Rechazadas</p>
                            <p class="text-white text-2xl font-bold">{{ $revendedor->transacciones_rechazadas }}</p>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-4 shadow">
                            <p class="text-white text-lg">Transacciones Canceladas</p>
                            <p class="text-white text-2xl font-bold">{{ $revendedor->transacciones_canceladas }}</p>
                        </div>
                    </div>
                </div>

                <!-- Métodos de Pago -->
                <div class="bg-gray-800 p-4 rounded-lg mt-4 shadow-lg">
                    <h3 class="font-semibold border-b border-gray-700 pb-2 text-white">MIS MÉTODOS DE PAGO</h3>
                    <div class="mt-4">
                        @php
                            $metodosPago = json_decode($revendedor->metodos_pago, true);
                        @endphp

                        @if ($metodosPago && is_array($metodosPago))
                            @foreach ($metodosPago as $metodo)
                                <div class="flex items-center justify-between bg-gray-700 p-3 rounded-lg mt-2 shadow">
                                    <span
                                        class="text-white text-lg">{{ $metodo['nombre'] ?? 'Nombre no disponible' }}</span>
                                    <span class="text-white">{{ $metodo['detalle'] ?? 'Detalle no disponible' }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-white">No hay métodos de pago disponibles.</p>
                        @endif
                    </div>
                </div>



                <!-- Reviews -->
                <div class="bg-gray-800 p-4 rounded-lg mt-4">
                    <h3 class="font-semibold border-b border-gray-700 pb-2">MIS CALIFCACIONES</h3>
                    <!-- Reviews list -->
                </div>
            </div>

        </div>
    </div>

    <!-- Incluir app.js al final del body -->
    @vite('resources/js/app.js')
</body>

</html>
