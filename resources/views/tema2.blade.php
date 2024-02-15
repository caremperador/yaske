<!DOCTYPE html>
<html class="h-full bg-gray-900">

<head>
    <title>Yaske - @yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    @vite('resources/css/app.css')

</head>

<body class="h-full">

    <div style="overflow: hidden">
        <!-- sidebar en version mobile que solo se abre cuando hacen click en boton hamburguesa -->
        <div id="sidebar"
            class="fixed z-50 hidden xl:hidden transform transition duration-300 -translate-x-full bg-gray-800  h-full w-full">

            <!-- Fondo oscuro con opacidad fuera del contenedor de enlaces -->
            <div class="fixed inset-0 bg-gray-900/80"> </div>


            <div class="fixed inset-0 flex">

                <div class="relative mr-16 flex w-full max-w-xs flex-1">

                    <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button class="close-btn text-white">
                            <i class="fas fa-times"></i>
                            <span class="sr-only">Close sidebar</span>
                        </button>

                    </div>

                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <div
                        class="flex grow z-60 flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 w-full ring-1 ring-white/10">
                        <div class="flex h-16 shrink-0 items-center">
                            <img class="h-8 w-auto" src="/images/logo/logo-yaske.png" alt="Yaske">
                        </div>
                        <nav class="flex flex-1 flex-col">
                            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                <li>
                                    <ul role="list" class="-mx-2 space-y-1">
                                        <li>
                                            <!-- Current: "bg-gray-800 text-white", Default: "text-gray-400 hover:text-white hover:bg-gray-800" -->
                                            <a href="#"
                                                class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                                <i class="fas fa-folder h-6 w-6 shrink-0 text-xl"></i>
                                                Projects
                                            </a>
                                        </li>
        
        
                                    </ul>
                                </li>
                                <li>
                                    <div class="text-xs font-semibold leading-6 text-gray-400">Your teams</div>
                                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                                        <li>
                                            <!-- Current: "bg-gray-800 text-white", Default: "text-gray-400 hover:text-white hover:bg-gray-800" -->
                                            <a href="#"
                                                class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                                <span
                                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-white">P</span>
                                                <span class="truncate">Planetaria</span>
                                            </a>
                                        </li>
        
                                    </ul>
                                </li>
                                <li class="-mx-6 mt-auto">
                                    <a href="#"
                                        class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-white hover:bg-gray-800">
                                        <img class="h-8 w-8 rounded-full bg-gray-800"
                                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                            alt="">
                                        <span class="sr-only">Your profile</span>
                                        <span aria-hidden="true">10 dias premium</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>



        
        <!-- sidebar en version pantalla grande fijo en pantalla grande y se oculta en pantallas pequeñas -->
        <div class="hidden xl:fixed xl:inset-y-0 xl:z-50 xl:flex xl:w-72 xl:flex-col">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-black/10 px-6 ring-1 ring-white/5">
                <div class="flex h-16 shrink-0 items-center">
                    <img class="h-8 w-auto" src="/images/logo/logo-yaske.png" alt="Yaske">
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li>
                                    <!-- Current: "bg-gray-800 text-white", Default: "text-gray-400 hover:text-white hover:bg-gray-800" -->
                                    <a href="#"
                                        class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                        <i class="fas fa-folder h-6 w-6 shrink-0 text-xl"></i>
                                        Projects
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <li>
                            <div class="text-xs font-semibold leading-6 text-gray-400">Your teams</div>
                            <ul role="list" class="-mx-2 mt-2 space-y-1">
                                <li>
                                    <!-- Current: "bg-gray-800 text-white", Default: "text-gray-400 hover:text-white hover:bg-gray-800" -->
                                    <a href="#"
                                        class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                        <span
                                            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-white">P</span>
                                        <span class="truncate">Planetaria</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="-mx-6 mt-auto">
                            <a href="#"
                                class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-white hover:bg-gray-800">
                                <img class="h-8 w-8 rounded-full bg-gray-800"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="">
                                <span class="sr-only">Your profile</span>
                                <span aria-hidden="true">10 dias premium</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="xl:pl-72">
            <!-- Sticky search header -->
            <div
                class="sticky top-0 z-40 flex h-16 xl:hidden shrink-0 items-center gap-x-6 border-b border-white/5 bg-gray-900 px-4 shadow-sm sm:px-6 lg:px-8">
                <!-- Botón de hamburguesa para pantallas pequeñas -->
                <button id="menu-toggle" class="text-white xl:hidden">
                    <i class="fas fa-bars"></i>
                    <span class="sr-only">Open sidebar</span>
                </button>



            </div>

            <main>
                <header
                    class="flex items-center justify-between border-b border-white/5 px-4 py-4 sm:px-6 sm:py-6 lg:px-8">
                    <h1 class="text-base font-semibold leading-7 text-white uppercase">
                        @yield('title')
                    </h1>

                </header>

                <div class="content px-6 py-6 text-white first-letter:uppercase">
                    <!-- contenido principal -->
                    @yield('content')
                </div>



            </main>


        </div>
    </div>


    <!-- Incluir app.js al final del body -->
    @vite('resources/js/app.js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const btnClose = document.querySelector('.close-btn');

            btnToggle.addEventListener('click', function() {
                // Si el sidebar está oculto, quita 'hidden' y '-translate-x-full', y añade 'translate-x-0'
                if (sidebar.classList.contains('hidden')) {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                } else {
                    // Si el sidebar está visible, añade 'hidden' y '-translate-x-full', y quita 'translate-x-0'
                    sidebar.classList.add('hidden');
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                }
            });

            btnClose.addEventListener('click', function() {
                sidebar.classList.add('hidden');
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            });
        });
    </script>



</body>

</html>
