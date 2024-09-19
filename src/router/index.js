// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import BooksList from '../components/BooksList.vue'; // Provjeri putanju do komponente

const routes = [
  {
    path: '/',
    name: 'BooksList',
    component: BooksList
  }
  // Dodaj ostale rute ovdje
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router;
