<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    @vite('resources/css/app.css')
</head>

<body class="bg-black text-gray-100">

    <div class="container mx-auto px-4 md:px-0">
        <div class="md:flex md:items-start py-8">

            <!-- Sidebar -->


            <div class="flex flex-col space-y-4 bg-black p-8">
                <div class="flex flex-col items-center">
                    @php
                        $user = auth()->user();
                        $diasPremiumRevendedor = $user->diasPremiumRevendedor;
                        $fotoPerfil = null;
                        $slug = null;

                        // Si el usuario es un revendedor, utiliza su foto de perfil y slug
                        if ($diasPremiumRevendedor) {
                            $fotoPerfil = $diasPremiumRevendedor->foto_perfil ? Storage::url($diasPremiumRevendedor->foto_perfil) : null;
                            $slug = $diasPremiumRevendedor->slug;
                        } else {
                            // Si el usuario no es un revendedor, utiliza la foto de perfil de la tabla users
                            $fotoPerfil = $user->foto_perfil ? Storage::url($user->foto_perfil) : null;
                        }
                    @endphp

                    @if ($slug)
                        <a href="{{ route('perfilRevendedor', $slug) }}">
                            @if ($fotoPerfil)
                                <img src="{{ $fotoPerfil }}" alt="Profile"
                                    class="rounded-full w-32 h-32 mx-auto md:mx-0">
                            @else
                                <i class="fas fa-user-circle fa-10x text-gray-400"></i>
                            @endif
                        </a>
                    @else
                        @if ($fotoPerfil)
                            <img src="{{ $fotoPerfil }}" alt="Profile"
                                class="rounded-full w-32 h-32 mx-auto md:mx-0">
                        @else
                            <i class="fas fa-user-circle fa-10x text-gray-400"></i>
                        @endif
                    @endif

                    @if (auth()->check() &&
                            auth()->user()->hasRole('revendedor'))
                        <p class="text-sm mt-3">Cuenta: revendedor</p>
                    @elseif (auth()->check() &&
                            auth()->user()->hasRole('admin'))
                        <p class="text-sm mt-3">Cuenta: Admin</p>
                    @elseif (auth()->check() &&
                            auth()->user()->hasRole('premium'))
                        <p class="text-sm mt-3">Cuenta: Premium</p>
                    @else
                        <p class="text-sm mt-3">Cuenta: free</p>
                    @endif
                    <p class="text-sm mt-3">ID del Usuario: {{ $userId ?? 'No Disponible' }}</p>
                </div>
                @yield('botones')
                <a href="/"
                    class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
                <a href="/user/profile"
                    class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                    <i class="fas fa-key mr-1"></i> Cambiar contraseña
                </a>

                @if (auth()->check() &&
                        auth()->user()->hasRole('revendedor'))

                    @if (!optional(auth()->user()->diasPremiumRevendedor)->exists)
                        <!-- Link para usuarios que son revendedores -->
                        <a href="{{ route('configuracion_revendedor.index') }}"
                            class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                            <i class="fas fa-cog mr-1"></i> Configuracion
                        </a>
                    @else
                        <a href="{{ route('configuracion_revendedor.index') }}"
                            class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                            <i class="fas fa-cog mr-1"></i> Configuracion
                        </a>
                        <a href="{{ route('perfil_revendedor.index') }}"
                            class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                            <i class="fas fa-user-circle mr-1"></i> Perfil
                        </a>

                        <a href="{{ route('metodos_pago.index') }}"
                            class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                            <i class="fas fa-credit-card mr-1"></i> Metodos de pago
                        </a>
                        <a href="{{ route('transacciones.show') }}"
                            class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                            <i class="fas fa-gem mr-1 text-yellow-200"></i> Vender dias
                        </a>
                        <a href="{{ route('vender_dias_directo.index') }}"
                            class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                            <i class="fas fa-gem mr-1 text-yellow-200"></i> Vender dias directo
                        </a>
                        <a href="{{ route('comprar_dias_revendedor.index') }}"
                            class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                            <i class="fas fa-shopping-cart mr-1"></i> Comprar dias
                        </a>
                        <a href="{{ route('generar.token') }}"
                            class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                            <i class="fas fa-key mr-1"></i> Generar token
                        </a>
                        <a href="#"
                            class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                            <i class="fas fa-users mr-1"></i> Referidos
                        </a>
                    @endif
                    <!-- Link para usuarios que son admin -->
                @elseif (auth()->check() &&
                        auth()->user()->hasRole('admin'))
                    <a href="{{ route('cambiar_foto_perfil.index') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-image mr-1"></i> Foto de Perfil
                    </a>
                    <a href="{{ route('videos.create') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-video mr-1"></i> Crear videos
                    </a>
                    <a href="{{ route('tipos.create') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-folder-open mr-1"></i> Crear Tipos
                    </a>
                    <a href="{{ route('listas.create') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-list mr-1"></i> Crear Listas
                    </a>
                    <a href="{{ route('categorias.create') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-tags mr-1"></i> Crear categorias
                    </a>
                    <a href="{{ route('admin.todos_los_videos') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-film mr-1"></i> Todos videos
                    </a>
                    <a href="{{ route('videos.create') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-users mr-1"></i> Todos los Usuarios
                    </a>
                    <a href="{{ route('admin.configuracion.pais') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-chart-line mr-1"></i> Precio minimo/maximo
                    </a>
                @elseif (auth()->check() &&
                        auth()->user()->hasRole('premium'))
                    <!-- Link para usuarios premiums -->
                    <a href="#"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-gem mr-1  text-yellow-200"></i> Mi plan premium
                    </a>
                    <a href="{{ route('cambiar_foto_perfil.index') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-image mr-1"></i> Foto de Perfil
                    </a>
                    <a href="{{ route('seleccionarRevendedor') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-shopping-cart mr-1"></i> Comprar dias premium
                    </a>
                    <a href="#"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-user-tie mr-1"></i>Ser Revendedor
                    </a>
                @else
                    <!-- Link para usuarios free -->
                    <a href="{{ route('cambiar_foto_perfil.index') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-image mr-1"></i> Foto de Perfil
                    </a>
                    <a href="{{ route('seleccionarRevendedor') }}"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-shopping-cart mr-1"></i> Comprar dias premium
                    </a>
                    <a href="#"
                        class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                        <i class="fas fa-user-tie mr-1"></i>Ser Revendedor
                    </a>
                @endif

                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="bg-[#1F2937] text-[#F0F6F6] py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-[#374151]">
                    <i class="fas fa-sign-out-alt mr-1"></i> Cerrar Sesión
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>

            </div>


            <!-- Main Content -->
            <div class="md:ml-8 md:w-3/4">
                <!-- mensaje de exito o error en envio de formulario -->
                @if (session('success'))
                    <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
                        Éxito
                    </div>
                    <div class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                        Error
                    </div>
                    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </div>

        </div>
    </div>

    <!-- Incluir app.js al final del body -->
    @vite('resources/js/app.js')

    <!-- Scripts Section -->
    @stack('scripts')
</body>

</html>
