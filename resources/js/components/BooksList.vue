<template>
  <div>
    <h1>Books List</h1>
    <v-data-table :headers="headers" :items="books" class="elevation-1">
      <template v-slot:item.author="{ item }">
        <strong>{{ item.author }}</strong>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  name: 'BooksList',
  data() {
    return {
      headers: [
        { text: 'Title', value: 'title' },
        { text: 'Author', value: 'author' },
      ],
      books: [
        { id: 1, title: 'The Hobbit', author: 'J.R.R. Tolkien' },
        { id: 2, title: '1984', author: 'George Orwell' },
        { id: 3, title: 'Harry Potter and the Sorcerer\'s Stone', author: 'J.K. Rowling' },
      ],
    };
  },
};
</script>

<style scoped>
/* Dodatni stilovi ako su potrebni */
</style>
