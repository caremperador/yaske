<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    @vite('resources/css/app.css')
    @yield('js_cabecera')
</head>

<body class="bg-black text-white">

    <!-- Navbar -->
    <nav class="bg-gray-900 p-4 flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ route('home') }}"> <img src="https://via.placeholder.com/32x32" alt="Logo"
                    class="h-8 mr-2"></a>
            <span class="font-bold">
                @if (auth()->check() &&
                        auth()->user()->hasRole('premium'))
                    <p>premium</p>
                @else
                    <p>free</p>
                @endif
            </span>
        </div>


        <!-- Navigation Buttons -->
        <div class="flex gap-4">
            <div class="flex gap-4">


                @if (Route::has('login'))
                    @auth
                        @if (auth()->user()->hasRole('admin'))
                            <a href="/mi-panel-admin" class="bg-gray-800 px-3 py-1 rounded text-white"><i
                                    class="fas fa-user-shield mr-1"></i>
                                Administracion</a>
                        @endif
                        <a href="{{ url('/dashboard') }}" class="bg-gray-800 px-3 py-1 rounded text-white"><i
                                class="fas fa-tachometer-alt mr-1"></i>
                            Dashboard</a>
                        <a href="{{ url('/comprar-diaspremium') }}" class="bg-gray-800 px-3 py-1 rounded text-white">
                            <i class="fas fa-gem mr-1 text-yellow-200"></i>
                            @if (auth()->check())
                                @php
                                    $diasTexto = $diasPremium == 1 ? 'día premium' : 'días premium';
                                @endphp

                                @if (auth()->user()->hasRole('admin'))
                                    {{ $diasPremium }} {{ $diasTexto }}
                                @elseif(auth()->user()->hasRole('premium'))
                                    {{ $diasPremium }} {{ $diasTexto }}
                                @elseif(auth()->user()->hasRole('revendedor'))
                                    {{ $diasPremium }} {{ $diasTexto }}
                                @else
                                    {{ $diasPremium }} {{ $diasTexto }}
                                @endif
                            @else
                                comprar premium
                            @endif
                        </a>
                    @else
                        <a href="/planes-premium" class="bg-gray-800 px-3 py-1 rounded text-white">Planes Premium</a>
                        <a href="{{ route('login') }}" class="bg-gray-800 px-3 py-1 rounded text-white">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-gray-800 px-3 py-1 rounded text-white">Register</a>
                        @endif
                    @endauth
                @endif



            </div>
        </div>
    </nav>

    <!-- Formulario de Búsqueda -->
    <div class="flex justify-center my-4">
        <form action="{{ route('videos.search') }}" method="GET" class="w-full max-w-md">
            <div class="flex items-center border-b border-black py-2">
                <input type="search" name="query" placeholder="Buscar videos..."
                    class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                <button type="submit"
                    class="flex-shrink-0 bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-sm border-4 text-white py-1 px-2 rounded">
                    <i class="fa fa-search pr-1"></i>Buscar
                </button>
            </div>
        </form>
    </div>

    <!-- Main Content -->
    <div class="w-2/3 mx-auto px-4 py-6">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 p-4 text-center">
        <!-- Footer content -->
        @if (auth()->check())
            @php
                $diasTexto = $diasPremium == 1 ? 'día premium' : 'días premium';
            @endphp

            @if (auth()->user()->hasRole('admin'))
                <p>Bienvenido usuario de rol admin, tienes {{ $diasPremium }} {{ $diasTexto }}.</p>
            @elseif(auth()->user()->hasRole('premium'))
                <p>Bienvenido usuario de rol premium, tienes {{ $diasPremium }} {{ $diasTexto }}.</p>
            @elseif(auth()->user()->hasRole('revendedor'))
                <p>Bienvenido usuario de rol revendedor, tienes {{ $diasPremium }} {{ $diasTexto }}.</p>
            @else
                <p>Bienvenido usuario registrado, tienes {{ $diasPremium }} {{ $diasTexto }}.</p>
            @endif
        @else
            <p>Texto a mostrar para público.</p>
        @endif

        @yield('footer')
    </footer>

    <!-- Incluir app.js al final del body -->
    @vite('resources/js/app.js')
    
    <!-- Scripts Section -->
    @stack('scripts')
   
</body>

</html>
