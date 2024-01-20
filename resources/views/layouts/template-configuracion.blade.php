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
                        $fotoPerfil = $diasPremiumRevendedor && $diasPremiumRevendedor->foto_perfil ? Storage::url($diasPremiumRevendedor->foto_perfil) : null;
                    @endphp

                    @if ($fotoPerfil)
                        <img src="{{ $fotoPerfil }}" alt="Profile" class="rounded-full w-32 h-32 mx-auto md:mx-0">
                    @else
                        <i class="fas fa-user-circle fa-10x text-gray-400"></i>
                    @endif
                    <p class="text-sm mt-3">ID del Usuario: {{ $userId ?? 'No Disponible' }}</p>
                </div>
                @yield('botones')


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
            </div>


            <!-- Main Content -->
            <div class="md:ml-8 md:w-3/4">
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
