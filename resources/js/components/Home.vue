<template>
  <v-container>
    <!-- Polje za pretragu knjiga -->
    <v-text-field
      v-model="searchQuery"
      label="Pretraži knjige"
      @input="searchBooks"
      clearable
    ></v-text-field>

    <v-row>
      <!-- Prikaz filtriranih knjiga -->
      <v-col v-for="book in filteredBooks" :key="book.id" cols="12" md="4">
        <v-card class="book-card">
          <!-- Pozadina s slikom knjige -->
          <v-img :src="getImageUrl(book)" height="300px" class="book-image"></v-img>

          <!-- Informacije o knjizi -->
          <v-card-title class="book-title">{{ book.title }}</v-card-title>
          <v-card-subtitle>{{ book.author }}</v-card-subtitle>
          <v-card-subtitle>{{ book.price }} €</v-card-subtitle>
          <v-card-subtitle>Na stanju: {{ book.stock }}</v-card-subtitle>

          <!-- Gumbi za akciju -->
          <v-card-actions>
            <v-text-field
              v-model="quantities[book.id]"
              label="Količina"
              type="number"
              min="1"
              :max="book.stock"
            ></v-text-field>
            <v-btn @click="addToCart(book)" color="black">Naruči</v-btn>
            <v-btn v-if="orders[book.id]" @click="cancelOrder(orders[book.id])" color="red">Poništi narudžbu</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <!-- Ako nema rezultata pretrage -->
      <v-col cols="12" v-if="filteredBooks.length === 0">
        <p>Knjiga trenutno nije dostupna na stanju.</p>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      books: [], // Knjige će biti učitane ovdje
      searchQuery: '', // Unos za pretragu
      filteredBooks: [], // Drži filtrirane knjige
      quantities: {}, // Količine za svaku knjigu
      orders: {}, // Pohrani ID narudžbi
    };
  },
  mounted() {
    this.fetchBooks();
    this.loadCartItems(); // Učitaj narudžbe kad se komponenta montira
  },
  methods: {
    fetchBooks() {
      axios.get('http://localhost:8000/api/books')
        .then(response => {
          this.books = response.data;
          this.filteredBooks = this.books; // Početno prikazujemo sve knjige
        })
        .catch(error => {
          console.error('Greška prilikom dohvaćanja knjiga:', error);
        });
    },
    searchBooks() {
      // Filtriraj knjige prema nazivu
      this.filteredBooks = this.books.filter(book =>
        book.title.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    addToCart(book) {
      const quantity = this.quantities[book.id] || 1;
      const token = localStorage.getItem('token');

      if (quantity > 0 && quantity <= book.stock) {
        axios.post('http://localhost:8000/api/order', {
          book_id: book.id,
          quantity: quantity
        }, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        })
        .then(response => {
          const orderId = response.data.orderId; // Dohvati stvarni orderId
          alert('Narudžba uspješno kreirana!');

          // Pohrani orderId za poništavanje
          this.orders[book.id] = orderId;
        })
        .catch(error => {
          console.error('Greška prilikom narudžbe:', error.response ? error.response.data : error.message);
          alert('Greška prilikom narudžbe!');
        });
      } else {
        alert('Nevažeća količina!');
      }
    },
    cancelOrder(orderId) {
      const token = localStorage.getItem('token');

      axios.delete(`http://localhost:8000/api/order/${orderId}`, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
      .then(response => {
        alert('Narudžba uspješno poništena!');
        this.loadCartItems(); // Osvježi prikaz narudžbi
      })
      .catch(error => {
        console.error('Greška prilikom poništavanja narudžbe:', error.response ? error.response.data : error.message);
        alert('Greška prilikom poništavanja narudžbe!');
      });
    },
    loadCartItems() {
      const token = localStorage.getItem('token');
      axios.get('http://localhost:8000/api/cart', {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
      .then(response => {
        const orders = response.data;
        this.orders = orders.reduce((acc, order) => {
          order.orderItems.forEach(item => {
            acc[item.book_id] = order.id;
          });
          return acc;
        }, {});
      })
      .catch(error => {
        console.error('Greška prilikom dohvaćanja narudžbi:', error);
      });
    },
    getImageUrl(book) {
      // Pretpostavimo da se slike nalaze u mapi '/slike' i zovu se prema book.title
      return(`public/slike/${book.title.replace(/\s+/g, '-').toLowerCase()}.png`);
    }
  }
};
</script>

<style scoped>
/* Dodaj stilove po potrebi */
</style>
