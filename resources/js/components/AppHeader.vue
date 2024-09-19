<template>
  <v-app-bar app color="primary" dark>
    <v-toolbar-title class="header-title">Knjižuljice</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-btn text to="/">Početna</v-btn>
    <v-btn text to="/onama">Autorica</v-btn>
    <v-btn text to="/prijava">Prijava</v-btn>
    <v-btn text to="/kosarica">Košarica</v-btn>
    <v-btn v-if="isLoggedIn" text @click="logout">Odjava</v-btn>
    <v-btn v-if="isAdmin" text @click="$router.push({ name: 'Admin' })">Admin</v-btn> <!-- Prikaz samo ako je admin -->
  </v-app-bar>
</template>

<script>
export default {
  name: 'AppHeader',
  props: {
    isLoggedIn: {
      type: Boolean,
      required: true,
    },
    isAdmin: {
      type: Boolean,
      required: true,
    },
  },
  methods: {
    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('isAdmin');
      localStorage.removeItem('userEmail');
      this.$emit('logout');
      this.$router.push('/prijava');
    },
  },
};
</script>

<style scoped>
.header-title {
  font-family: 'Montserrat', sans-serif; /* Promijeni font */
  font-size: 24px; /* Postavi veličinu fonta */
  font-weight: 700; /* Postavi debljinu fonta */
  text-transform: uppercase; /* Pretvori tekst u velika slova */
}
</style>