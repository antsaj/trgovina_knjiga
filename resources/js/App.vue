<template>
  <v-app class="app-background">
    <AppHeader :isLoggedIn="isLoggedIn" :isAdmin="isAdmin" @logout="logout" />
    <div class="main-content">
      <router-view />
    </div>
    <v-footer app color="primary" dark>
      <v-col class="text-center" cols="12">
        <span class="footer-text">© 2024 Knjižuljice. Sva prava pridržana.</span>
      </v-col>
    </v-footer>
  </v-app>
</template>

<script>
import AppHeader from './components/AppHeader.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
  },
  data() {
    return {
      isLoggedIn: false,
      isAdmin: false,
    };
  },
  methods: {
    // Provjera korisničkog statusa (prijavljen ili ne)
    checkAuth() {
      const token = localStorage.getItem('token');
      this.isLoggedIn = !!token;

      // Provjera je li korisnik admin
      const userEmail = localStorage.getItem('userEmail');
      const isAdmin = localStorage.getItem('isAdmin') === 'true';

      this.isAdmin = isAdmin;

      console.log('User email:', userEmail); // Provjera email adrese
      console.log('isAdmin status:', this.isAdmin); // Provjera je li admin

      this.$nextTick(() => {
        const userEmailAfterTick = localStorage.getItem('userEmail');
        const isAdminAfterTick = localStorage.getItem('isAdmin');
        console.log('User email after nextTick:', userEmailAfterTick);
        console.log('isAdmin status after nextTick:', isAdminAfterTick);
      });
    },
    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('isAdmin');
      localStorage.removeItem('userEmail');
      this.isLoggedIn = false;
      this.isAdmin = false;
      this.$router.push('/prijava');
    },
  },
  created() {
    this.checkAuth();
  },
  watch: {
    $route(to, from) {
      this.checkAuth();
    },
  },
};
</script>

<style scoped>
.app-background {
  background-color: #e0f7fa !important; /* Svijetloplava boja */
  min-height: 100vh; /* Pokriva cijelu visinu */
  display: flex;
  flex-direction: column;
}
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
  background-color: #f8f9fa;
}

/* CSS za fiksirani footer */
footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
  background-color: #f8f9fa;
}

.main-content {
  margin-top: 64px;
  margin-bottom: 64px;
  padding-top: 70px; /* Visina headera */
  padding-bottom: 50px; /* Visina footera */
  flex-grow: 1; /* Osigurava da se sadržaj rastegne */
}

.v-application {
  background-color: #e0f7fa !important; /* Dodaj pozadinu za cijelu aplikaciju */
}

.v-footer {
  background-color: #00796b; /* Tvoja boja footera */
}
</style>
