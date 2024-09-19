import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Checkout from '../components/Checkout.vue';
import Admin from '../components/Admin.vue'; // Import the Admin component

const routes = [
  {
    path: '/',
    name: 'Početna',
    component: Home, // Prikaz lista proizvoda na početnoj stranici
  },
  {
    path: '/onama',
    name: 'O Nama',
    component: () => import('../components/About.vue'), // Dodaj rutu za O Nama
  },
  {
    path: '/prijava',
    name: 'Prijava',
    component: () => import('../components/Login.vue'), // Dodaj rutu za Login
  },
  {
    path: '/kosarica',
    name: 'Košarica',
    component: () => import('../views/Cart.vue'), // Dodaj rutu za Košaricu
  },
  {
    path: '/checkout',
    name: 'Checkout',
    component: Checkout
  },
  {
    path: '/admin',
    name: 'Admin',
    component: Admin,
    meta: { requiresAdmin: true } // Meta field to indicate admin route
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guard to check for admin access
router.beforeEach((to, from, next) => {
  const isAdmin = localStorage.getItem('isAdmin') === 'true';
  const requiresAdmin = to.matched.some(record => record.meta.requiresAdmin);

  if (requiresAdmin && !isAdmin) {
    next('/prijava'); // Redirect to login page if not admin
  } else {
    next();
  }
});

export default router;
