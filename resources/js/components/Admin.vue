<template>
  <v-container>
    <h2>Administracija knjiga</h2>

    <!-- Form for adding new books -->
    <v-form @submit.prevent="addBook">
      <v-text-field v-model="newBook.title" label="Naslov"></v-text-field>
      <v-text-field v-model="newBook.author" label="Autor"></v-text-field>
      <v-text-field v-model="newBook.price" label="Cijena"></v-text-field>
      <v-text-field v-model="newBook.stock" label="Stanje"></v-text-field>
      <v-btn type="submit" color="black">Dodaj knjigu</v-btn>
    </v-form>

    <!-- List of existing books for editing -->
    <v-list>
      <v-list-item v-for="book in books" :key="book.id">
        <v-list-item-content>
          <v-list-item-title>{{ book.title }}</v-list-item-title>
          <v-text-field v-model="book.price" label="Cijena"></v-text-field>
          <v-text-field v-model="book.stock" label="Stanje"></v-text-field>
          <v-btn @click="updateBook(book)" color="black">Ažuriraj</v-btn>
          <v-btn @click="deleteBook(book.id)" color="red">Obriši</v-btn>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      books: [],
      newBook: {
        title: '',
        author: '',
        price: '',
        stock: '',
      }
    };
  },
  mounted() {
    this.fetchBooks();
  },
  methods: {
    fetchBooks() {
      axios.get('http://localhost:8000/api/books')
        .then(response => {
          this.books = response.data;
        })
        .catch(error => {
          console.error('Greška prilikom dohvaćanja knjiga:', error);
        });
    },
    async addBook() {
      try {
        const token = localStorage.getItem('token'); // Retrieve the token
        const response = await axios.post('http://localhost:8000/api/admin/books', this.newBook, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });

        alert('Knjiga uspješno dodana!');
        this.newBook = { title: '', author: '', price: '', stock: '' }; // Resetiraj formu
        this.fetchBooks(); // Osvježi listu knjiga
      } catch (error) {
        alert("Greška prilikom dodavanja knjige");
        console.error('Greška prilikom dodavanja knjige:', error.response ? error.response.data : error.message);
      }
    },
    async updateBook(book) {
      try {
        const token = localStorage.getItem('token'); // Provjerite imate li token
        const response = await axios.put(`http://localhost:8000/api/admin/books/${book.id}`, {
          title: book.title,
          author: book.author,
          price: book.price,
          stock: book.stock,
        }, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });

        alert(response.data.message); // Ispis uspješne poruke
        this.fetchBooks(); // Osvježi listu knjiga
      } catch (error) {
        console.error('Greška prilikom ažuriranja knjige:', error.response ? error.response.data : error.message);
        alert('Greška prilikom ažuriranja knjige: ' + (error.response ? error.response.data.message : error.message));
      }
    },
    async deleteBook(bookId) {
      try {
        const token = localStorage.getItem('token'); // Retrieve the token
        const response = await axios.delete(`http://localhost:8000/api/admin/books/${bookId}`, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });

        alert('Knjiga uspješno obrisana!');
        this.fetchBooks(); // Osvježi listu knjiga
      } catch (error) {
        console.error('Greška prilikom brisanja knjige:', error.response ? error.response.data : error.message);
        alert('Greška prilikom brisanja knjige: ' + (error.response ? error.response.data.message : error.message));
      }
    }
  }
};
</script>
