<template>
  <v-container>
    <v-form>
      <v-text-field label="Adresa" v-model="address"></v-text-field>
      <v-select
        :items="deliveryOptions"
        v-model="selectedDelivery"
        label="Način dostave"
      ></v-select>
      <v-btn color="black" @click="confirmCheckout">Potvrdi kupovinu</v-btn>
    </v-form>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      address: '',
      selectedDelivery: '',
      deliveryOptions: ['Dostava na kućnu adresu kurirskom službom'],
    };
  },
  methods: {
    confirmCheckout() {
      const token = localStorage.getItem('token');
      axios.post('http://localhost:8000/api/checkout', {
        address: this.address,
        delivery: this.selectedDelivery
      }, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
      .then(response => {
        alert('Kupovina uspješno završena!');
        this.$router.push({ name: 'Početna' }); // Redirect to home page after checkout
      })
      .catch(error => {
        console.error('Greška prilikom završetka kupovine:', error.response ? error.response.data : error.message);
      });
    }
  }
};
</script>
