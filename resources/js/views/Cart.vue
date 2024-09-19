<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <h2>Vaša košarica</h2>

        <!-- Prikaz ako nema narudžbi u košarici -->
        <v-alert v-if="orders.length === 0" type="info">
          Vaša košarica je prazna.
        </v-alert>

        <v-list v-else>
          <!-- Prikaz narudžbi -->
          <v-list-item v-for="order in orders" :key="order.id">
            <v-list-item-content>
              <v-list-item-title>Order ID: {{ order.id }}</v-list-item-title>
              <v-list-item-subtitle>Ukupna cijena: {{ order.total_price }} €</v-list-item-subtitle>
              <v-list-item-subtitle>Datum narudžbe: {{ order.order_date }}</v-list-item-subtitle>

              <!-- Lista stavki narudžbe -->
              <v-list v-for="item in order.order_items" :key="item.id">
                <v-list-item-content>
                  <v-list-item-title>Knjiga: {{ item.book.title }}</v-list-item-title>
                  <v-list-item-subtitle>Količina: {{ item.quantity }}</v-list-item-subtitle>
                  <v-list-item-subtitle>Cijena: {{ item.price }} €</v-list-item-subtitle>
                </v-list-item-content>
              </v-list>

              <!-- Gumb za poništavanje narudžbe -->
              <v-btn color="red" @click="cancelOrder(order.id)">Poništi narudžbu</v-btn>
            </v-list-item-content>
          </v-list-item>

          <!-- Gumb za završetak kupovine -->
          <v-btn color="black" v-if="orders.length > 0" @click="checkout">Završi kupovinu</v-btn>
        </v-list>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      orders: [], // Drži narudžbe iz baze
    };
  },
  mounted() {
    this.fetchOrders();
  },
  methods: {
    // Dohvaća narudžbe korisnika
    fetchOrders() {
      const token = localStorage.getItem('token');
      axios.get('http://localhost:8000/api/cart', {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
      .then(response => {
        this.orders = response.data;
      })
      .catch(error => {
        console.error('Greška prilikom dohvaćanja narudžbi:', error.response ? error.response.data : error.message);
      });
    },
    // Funkcija za poništavanje narudžbe
    cancelOrder(orderId) {
      const token = localStorage.getItem('token');
      axios.delete(`http://localhost:8000/api/order/${orderId}`, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
      .then(response => {
        alert('Narudžba uspješno poništena!');

        // Nakon poništavanja, ažuriraj popis narudžbi
        this.orders = this.orders.filter(order => order.id !== orderId);
      })
      .catch(error => {
        console.error('Greška prilikom poništavanja narudžbe:', error.response ? error.response.data : error.message);
        alert('Greška prilikom poništavanja narudžbe!');
      });
    },
    // Proces checkout-a
    checkout() {
      // Implementacija završetka kupovine
      this.$router.push({ name: 'Checkout' });
    }
  }
};
</script>

<style scoped>
/* Dodatni stilovi za izgled košarice */
</style>
