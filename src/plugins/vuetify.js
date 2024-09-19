// src/plugins/vuetify.js
import { createVuetify } from 'vuetify';
import 'vuetify/styles'; // Vuetify stilovi
import { aliases, fa } from 'vuetify/iconsets/fa';

const vuetify = createVuetify({
  icons: {
    defaultSet: 'fa', // Koristi FontAwesome ikone
    aliases,
    sets: {
      fa
    }
  }
});

export default vuetify;
