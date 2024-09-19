<template>
  <v-container>
    <v-row>
      <!-- Prijava -->
      <v-col cols="12" md="6">
        <h2>Prijava</h2>
        <v-form @submit.prevent="login">
          <v-text-field label="Email" v-model="loginForm.email" required></v-text-field>
          <v-text-field label="Lozinka" v-model="loginForm.password" type="password" required></v-text-field>
          <v-btn type="submit" color="primary">Prijava</v-btn>
        </v-form>
      </v-col>

      <!-- Registracija -->
      <v-col cols="12" md="6">
        <h2>Registracija</h2>
        <v-form @submit.prevent="register">
          <v-text-field label="Ime" v-model="registerForm.name" required></v-text-field>
          <v-text-field label="Email" v-model="registerForm.email" required></v-text-field>
          <v-text-field label="Lozinka" v-model="registerForm.password" type="password" required></v-text-field>
          <v-btn type="submit" color="primary">Registracija</v-btn>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      loginForm: {
        email: '',
        password: '',
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
      },
    };
  },
  methods: {  
    login() {
      axios.post('http://localhost:8000/api/login', this.loginForm)
        .then(response => {
          console.log('Response data:', response.data);  // Provjerite podatke u konzoli

          // Sprema token za autentifikaciju
          localStorage.setItem('token', response.data.token);

          // Sprema email korisnika
          localStorage.setItem('userEmail', response.data.user.email);

          // Sprema admin status
          localStorage.setItem('isAdmin', response.data.isAdmin.toString());

          // Preusmjerite korisnika na početnu stranicu
          this.$router.push('/');
        })
        .catch(error => {
          console.error('Pogreška pri prijavi:', error);
        });
    },
    register() {
      axios.post('http://localhost:8000/api/register', this.registerForm)
        .then(response => {
          const token = response.data.token;
          if (token) {
            localStorage.setItem('token', token);
          }
          alert('Registracija uspješna!');
          this.$router.push('/'); // Redirect to home page
        })
        .catch(error => {
          alert('Greška prilikom registracije!');
          console.error('Greška prilikom registracije:', error.response ? error.response.data : error.message);
        });
    },
  }
};
</script>

<style scoped>
/* Stilovi po želji */
</style>
