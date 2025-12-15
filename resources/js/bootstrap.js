import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '910f30463d60ed827d7f',  // Hardcoded for testing
    cluster: 'ap2',
    forceTLS: true,
    encrypted: true
});

console.log('✅ Bootstrap loaded - Echo:', window.Echo);
console.log('✅ Pusher connection:', window.Echo.connector.pusher.connection.state);