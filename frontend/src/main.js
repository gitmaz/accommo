import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import ApiService from '@/services/api.service';

// Initialize the API service
ApiService.init();

createApp(App).use(router).mount('#app');
