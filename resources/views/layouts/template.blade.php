<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-white">

    <!-- Navbar -->
    <nav class="bg-gray-900 p-4 flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ route('home') }}"> <img src="https://via.placeholder.com/32x32" alt="Logo"
                    class="h-8 mr-2"></a>
            <span class="font-bold">yaske</span>

        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-4">
            <div class="flex gap-4">



                @if (Route::has('login'))
                    @auth
                        @if (auth()->user()->hasRole('admin'))
                            <a href="/mi-panel-admin" class="bg-gray-800 px-3 py-1 rounded text-white">Administracion</a>
                        @endif
                        <a href="{{ url('/dashboard') }}" class="bg-gray-800 px-3 py-1 rounded text-white">Dashboard</a>
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

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
        <!-- Main video grid -->


        @yield('content')



    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 p-4 text-center">
        <!-- Footer content -->

        @if (auth()->check() &&
                auth()->user()->hasRole('admin'))
            <p>Texto a mostrar para rol admin</p>
        @elseif(auth()->check() &&
                auth()->user()->hasRole('premium'))
            <p>Texto a mostrar para rol premium</p>
        @elseif (auth()->check())
            <p>Texto a mostrar para registrados</p>
        @else
            <p>Texto a mostrar para público</p>
        @endif

        @yield('footer')
    </footer>

   <!-- Scripts Section -->
   @stack('scripts')


</body>

</html>
