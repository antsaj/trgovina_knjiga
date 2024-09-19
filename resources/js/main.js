import { createApp } from 'vue';
import App from './App.vue'; // ili BooksList.vue, ovisno o strukturi
import router from './router'; // Osiguraj da router postoji
import vuetify from './plugins/vuetify'; // Ako koristiš Vuetify
import axios from 'axios';

createApp(App)
  .use(router) // Registrira router
  .use(vuetify) // Ako koristiš Vuetify
  .mount('#app');

  axios.defaults.baseURL = 'http://localhost:8000';