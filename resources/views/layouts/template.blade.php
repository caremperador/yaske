<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    @vite('resources/css/app.css')
    @yield('js_cabecera')
</head>

<body class="bg-gray-900 text-white">
    <!-- Indicador de Carga con Tailwind CSS -->
    <div id="loading-spinner" class="fixed inset-0 bg-gray-900 bg-opacity-70 z-50 flex justify-center items-center">
        <div class="text-center">
            <img src="https://i.pinimg.com/originals/49/23/29/492329d446c422b0483677d0318ab4fa.gif" alt="Cargando..."
                class="mx-auto" />
        </div>
    </div>

    <header>
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1 mr-6 text-white">
                <a href="{{ route('home') }}" class="-m-1.5 p-1.5">
                    <span class="sr-only">Yaske</span>
                    <img class="h-8 w-auto" src="/images/logo/logo-yaske.png" alt="yaske">
                </a>
            </div>
            <!-- Menú de navegación pantalla mediana-->
            <div class="flex lg:hidden w-full">
                <!-- Campo de búsqueda  pantalla pequeña-->
                <div class="flex-grow">
                    <div class="relative w-full">
                        <form action="{{ route('videos.search') }}" method="GET">
                            <input type="search"name="query" placeholder="Buscar videos..."
                                class="w-full pl-4 pr-10 rounded-full text-sm font-semibold leading-none text-white placeholder-gray-300 bg-transparent border-2 border-gray-700 py-2 focus:outline-none" />
                            <button type="submit" class="absolute right-0 mr-4 text-white p-2 text-xs">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <button id="navbar-toggle" type="button"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400 ml-6">
                    <span class="sr-only">Open main menu</span>
                    <i class="fa fa-bars"></i> <!-- Ícono de FontAwesome para hamburguesa -->
                </button>



            </div>
            <div class="hidden lg:flex lg:gap-x-4">
                <!-- enlaces pantalla grande -->
                {{--  <a href="#"
                    class="text-sm font-semibold leading-6 text-white px-0.5 py-2 bg-gray-900 rounded-md inline-flex items-center">Netflix</a> --}}

                <!-- peliculas Menú con submenú -->
                <div class="relative inline-block text-left">
                    <button
                        class="submenu-btn text-sm font-semibold leading-6 text-white px-0.5 py-2 bg-gray-900 rounded-md inline-flex items-center">
                        Peliculas
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>
                    <!-- Submenú -->
                    <div
                        class="hidden absolute left-0 z-10 mt-1 bg-custom-gray border border-gray-600 rounded-md submenu">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos Cam
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos HD
                        </a>
                    </div>
                </div>
                <!-- series Menú con submenú -->
                <div class="relative inline-block text-left">
                    <button
                        class="submenu-btn text-sm font-semibold leading-6 text-white px-0.5 py-2 bg-gray-900 rounded-md inline-flex items-center">
                        Series
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>
                    <!-- Submenú -->
                    <div
                        class="hidden absolute left-0 z-10 mt-1 bg-custom-gray border border-gray-600 rounded-md submenu">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos Cam
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos HD
                        </a>
                    </div>
                </div>

                <!-- Animes Menú con submenú -->
                <div class="relative inline-block text-left">
                    <button
                        class="submenu-btn text-sm font-semibold leading-6 text-white px-0.5 py-2 bg-gray-900 rounded-md inline-flex items-center">
                        Animes
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>
                    <!-- Submenú -->
                    <div
                        class="hidden absolute left-0 z-10 mt-1 bg-custom-gray border border-gray-600 rounded-md submenu">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos Cam
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos HD
                        </a>
                    </div>
                </div>

                <!-- Doramas Menú con submenú -->
                <div class="relative inline-block text-left">
                    <button
                        class="submenu-btn text-sm font-semibold leading-6 text-white px-0.5 py-2 bg-gray-900 rounded-md inline-flex items-center">
                        Doramas
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>
                    <!-- Submenú -->
                    <div
                        class="hidden absolute left-0 z-10 mt-1 bg-custom-gray border border-gray-600 rounded-md submenu">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos Cam
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos HD
                        </a>
                    </div>
                </div>


                <!-- Telenovelas  Menú con submenú -->
                <div class="relative inline-block text-left">
                    <button
                        class="submenu-btn text-sm font-semibold leading-6 text-white px-0.5 py-2 bg-gray-900 rounded-md inline-flex items-center">
                        Telenovelas
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>
                    <!-- Submenú -->
                    <div
                        class="hidden absolute left-0 z-10 mt-1 bg-custom-gray border border-gray-600 rounded-md submenu">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos Cam
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos HD
                        </a>
                    </div>
                </div>

                <!-- Cursos Menú con submenú -->
                <div class="relative inline-block text-left">
                    <button
                        class="submenu-btn text-sm font-semibold leading-6 text-white px-0.5 py-2 bg-gray-900 rounded-md inline-flex items-center">
                        Cursos
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>
                    <!-- Submenú -->
                    <div
                        class="hidden absolute left-0 z-10 mt-1 bg-custom-gray border border-gray-600 rounded-md submenu">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos Cam
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos HD
                        </a>
                    </div>
                </div>

                <!-- Adultos Menú con submenú -->
                <div class="relative inline-block text-left">
                    <button
                        class="submenu-btn text-sm font-semibold leading-6 text-white px-0.5 py-2 bg-gray-900 rounded-md inline-flex items-center">
                        Adultos
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>
                    <!-- Submenú -->
                    <div
                        class="hidden absolute left-0 z-10 mt-1 bg-custom-gray border border-gray-600 rounded-md submenu">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos Cam
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-gray-600 whitespace-nowrap"><i
                                class="fas fa-circle text-xxs p-1"></i>
                            Estrenos HD
                        </a>
                    </div>
                </div>


                <!-- Formulario de búsqueda pantalla grande-->

                <div class="relative flex pt-2">
                    <form action="{{ route('videos.search') }}" method="GET">
                        <input type="search" name="query" placeholder="Buscar videos..."
                            class="pl-4 pr-4 w-full rounded-full focus:outline-none text-sm font-semibold leading-none text-white placeholder-gray-300 bg-transparent border-2 border-gray-700 focus:border-gray-500 py-0.5" />
                        <button type="submit" class="absolute right-0 pr-2 py-1 text-white p-0.5 text-xs">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>



            </div>
            @if (auth()->check())
                @php
                    $user = auth()->user();
                    $diasPremiumRevendedor = $user->diasPremiumRevendedor;
                    $fotoPerfil = null;

                    // Si el usuario es un revendedor, utiliza su foto de perfil
                    if ($diasPremiumRevendedor && $diasPremiumRevendedor->foto_perfil) {
                        $fotoPerfil = Storage::url($diasPremiumRevendedor->foto_perfil);
                    } elseif ($user->foto_perfil) {
                        // Si el usuario no es un revendedor, pero tiene una foto de perfil en la tabla users
                        $fotoPerfil = Storage::url($user->foto_perfil);
                    }
                @endphp

                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <a href="{{ route('dashboard-profil.index') }}"
                        class="text-3xl font-semibold leading-6 text-white mr-1">
                        @if ($fotoPerfil)
                            <img src="{{ $fotoPerfil }}" alt="Profile" class="rounded-full w-8 h-8 mr-1">
                        @else
                            <i class="fas fa-user-circle mr-1"></i>
                        @endif
                    </a>
                    <span class="text-xxs text-black font-extrabold bg-white px-1 py-2 rounded-full w-8 h-8">
                        @if (auth()->check())
                            {{ $diasPremium }} <i class="fas fa-gem text-yellow-600 "></i>
                        @else
                            0 <i class="fas fa-gem  text-yellow-600"></i>
                        @endif

                    </span>
                </div>
            @else
                <div class="rounded-full hidden w-8 h-8 mr-1">login </div>
            @endif

        </nav>

        <!-- Mobile menu, show/hide based on menu open state. -->
        <div id="navbar-search" class="hidden lg:hidden" role="dialog" aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-10"></div>
            <div
                class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-gray-900 px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-white/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8 w-auto" src="/images/logo/logo-yaske.png" alt="yaske">
                    </a>
                    <!-- Para el botón de cerrar, si es necesario -->
                    <button type="button" class="close-button -m-2.5 rounded-md p-2.5 text-gray-400">
                        <span class="sr-only">Close menu</span>
                        <i class="fa fa-times"></i> <!-- Ícono de FontAwesome para cerrar -->
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/25">
                        <div class="space-y-2 py-6">
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">Product</a>
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">Features</a>
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">Marketplace</a>
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">Company</a>
                        </div>


                        <div class="py-6">
                            <!-- Botón del menú desplegable -->
                            <button
                                class="dropdown-toggle text-base font-semibold leading-7 text-white hover:bg-gray-800 px-3 py-2.5 rounded-lg focus:outline-none focus:shadow-outline">
                                Menú
                                <i class="fas fa-angle-down ml-1 text-xxs"></i>
                            </button>

                            <!-- Menú desplegable -->
                            <div class="dropdown-menu hidden absolute bg-gray-800 mt-1 rounded-md shadow-lg">
                                <!-- Ítems del submenú aquí -->
                                <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Submenú
                                    1 43gge grge</a>
                                <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Submenú
                                    2</a>
                                <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Submenú
                                    3</a>
                                <!-- ... más ítems del submenú ... -->
                            </div>
                        </div>
                        <div class="py-6">
                            <!-- Botón del menú desplegable -->
                            <button
                                class="dropdown-toggle text-base font-semibold leading-7 text-white hover:bg-gray-800 px-3 py-2.5 rounded-lg focus:outline-none focus:shadow-outline">
                                Menú
                                <i class="fas fa-angle-down ml-1 text-xxs"></i>
                            </button>

                            <!-- Menú desplegable -->
                            <div class="dropdown-menu hidden absolute bg-gray-800 mt-1 rounded-md shadow-lg">
                                <!-- Ítems del submenú aquí -->
                                <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Submenú
                                    1</a>
                                <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Submenú
                                    2</a>
                                <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Submenú
                                    3</a>
                                <!-- ... más ítems del submenú ... -->
                            </div>
                        </div>

                        <div class="py-6">
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-white hover:bg-gray-800">Log
                                in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    @yield('content')



    <!-- Footer -->
    <footer class="bg-custom-gray p-4 text-center">
        @yield('footer')
    </footer>

    <!-- Incluir app.js al final del body -->
    @vite('resources/js/app.js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainMenuToggle = document.getElementById('navbar-toggle');
            const closeButton = document.querySelector(
                '.close-button'); // Asegúrate de agregar una clase específica al botón de cierre
            const mainMenu = document.getElementById('navbar-search');

            // Controlador para el botón de hamburguesa
            mainMenuToggle.addEventListener('click', function() {
                mainMenu.classList.toggle('hidden');
            });

            // Controlador para el botón de cierre
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    mainMenu.classList.add('hidden');
                });
            }
        });

        // Manejo de menus desplegables en navbar y sus submenus en vista lg full
        document.addEventListener('DOMContentLoaded', function() {
            // Obtén todos los botones que activan submenús
            const submenuButtons = document.querySelectorAll('.submenu-btn');

            submenuButtons.forEach(button => {
                // Encuentra el submenú asociado con el botón. Asume que el submenú está directamente después del botón.
                const submenu = button.nextElementSibling;

                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    // Alterna la visibilidad del submenú específico
                    submenu.classList.toggle('hidden');
                });

                // Opcional: Cerrar el submenú al hacer clic fuera de él
                document.addEventListener('click', function(event) {
                        if (!button.contains(event.target) && !submenu.contains(event.target)) {
                            submenu.classList.add('hidden');
                        }
                    },
                    true
                ); // El tercer parámetro 'true' indica que el evento se captura durante la fase de captura.
            });
        });
        // Manejo de menus desplegables en navbar y sus submenus en vista md xs
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            const dropdownMenus = document.querySelectorAll('.dropdown-menu');

            dropdownToggles.forEach((dropdownToggle, index) => {
                // Asegúrate de que cada botón de menú desplegable tenga un menú correspondiente
                if (dropdownMenus[index]) {
                    dropdownToggle.addEventListener('click', function(event) {
                        event.stopPropagation();
                        // Alterna la visibilidad del menú correspondiente
                        dropdownMenus[index].classList.toggle('hidden');
                    });
                }
            });

            // Cierra todos los menús si se hace clic fuera de ellos
            document.addEventListener('click', function(event) {
                dropdownMenus.forEach((dropdownMenu) => {
                    if (!dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            });
        });

        function showPlayIcon(container) {
            const playIcon = container.querySelector('.play-icon');
            if (playIcon) {
                playIcon.style.display = 'block';
            }
        }

        function hidePlayIcon(container) {
            const playIcon = container.querySelector('.play-icon');
            if (playIcon) {
                playIcon.style.display = 'none';
            }
        }
    </script>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Initialize Swiper portadas -->
    <script>
        var swiper = new Swiper('.SwiperPortadas', {
            // Configuraciones de Swiper
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            /* autoplay: {
                delay: 5000,
            }, */
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(window).on('load', function() {
            // Cuando todas las imágenes y recursos estén cargados
            $('#loading-spinner').fadeOut('slow', function() {
                // Oculta el indicador de carga
                $(this).remove();
            });
        });
    </script>
    <!-- Scripts Section -->
    @stack('scripts')

</body>

</html>
