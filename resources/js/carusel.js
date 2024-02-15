document.addEventListener("DOMContentLoaded", function() {
    // Inicializa todos los sliders que tienen la clase 'swiper-container'
    var allSwipers = document.querySelectorAll('.swiper-container');

    allSwipers.forEach(function(swiperContainer) {
        // Inicializa Swiper para este contenedor específico
        var swiper = new Swiper(swiperContainer, {
            loop: true,
            slidesPerView: 'auto',
            centeredSlides: false,
            spaceBetween: 2,
            navigation: {
                nextEl: swiperContainer.querySelector('.swiper-button-next'),
                prevEl: swiperContainer.querySelector('.swiper-button-prev'),
            },
            // Configuración de breakpoints...
            // Añadir breakpoints para una respuesta adaptable
            breakpoints: {
                // cuando la anchura de la ventana es >= 320px
                320: {
                    slidesPerView: 2.2,
                    spaceBetween: 2
                },
                // cuando la anchura de la ventana es >= 480px
                480: {
                    slidesPerView: 3.2,
                    spaceBetween: 2
                },
                // cuando la anchura de la ventana es >= 640px
                640: {
                    slidesPerView: 4.2,
                    spaceBetween: 2
                },
                // cuando la anchura de la ventana es >= 768px
                768: {
                    slidesPerView: 5.2,
                    spaceBetween: 2
                },
                // cuando la anchura de la ventana es >= 768px
                1024: {
                    slidesPerView: 6.2,
                    spaceBetween: 2
                },
                // cuando la anchura de la ventana es >= 768px
                1280: {
                    slidesPerView: 7.2,
                    spaceBetween: 2
                }
            }
        });

        // Selecciona los botones de navegación de este contenedor específico
        var btnNext = swiperContainer.querySelector('.swiper-button-next');
        var btnPrev = swiperContainer.querySelector('.swiper-button-prev');

        // Función para alternar la visibilidad de los botones
        function toggleNavigationButtons(action) {
            if (action === 'show') {
                btnNext.classList.remove('hidden');
                btnPrev.classList.remove('hidden');
            } else if (action === 'hide') {
                btnNext.classList.add('hidden');
                btnPrev.classList.add('hidden');
            }
        }

        // Inicialmente oculta los botones de navegación
        toggleNavigationButtons('hide');

        // Evento cuando el cursor entra en el contenedor de Swiper
        swiperContainer.addEventListener('mouseenter', function() {
            toggleNavigationButtons('show');
        });

        // Evento cuando el cursor sale del contenedor de Swiper
        swiperContainer.addEventListener('mouseleave', function() {
            toggleNavigationButtons('hide');
        });
    });
});