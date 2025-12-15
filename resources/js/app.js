import './bootstrap';  // ✅ Bootstrap age import korte hobe (Echo initialize hobe)
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

console.log('App.js loaded');
console.log('Echo status:', window.Echo);