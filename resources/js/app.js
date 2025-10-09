import './bootstrap';

import Alpine from 'alpinejs';
import {createApp} from 'vue/dist/vue.esm-bundler.js';

import SendMessage from './components/SendMessage.vue'

const app = createApp({
    components: {
        SendMessage,
    }
});
app.mount('#app');
window.Alpine = Alpine;

Alpine.start();
