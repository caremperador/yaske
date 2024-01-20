import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Configuración de Laravel Echo con Pusher
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY, // Asegúrate de que estas variables estén en tu archivo .env y accesibles en Vite
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});
