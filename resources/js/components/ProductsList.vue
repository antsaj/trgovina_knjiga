<template>
  <div>
    <v-container>
      <v-row>
        <v-col v-for="product in products" :key="product.id" cols="12" md="4">
          <v-card class="product-card">
            <v-img :src="product.image" height="200px" class="product-image"></v-img>
            <v-card-title>{{ product.name }}</v-card-title>
            <v-card-subtitle>{{ product.price }} KM</v-card-subtitle>
            <v-card-actions>
              <v-btn text v-if="isUserLoggedIn" @click="orderProduct(product)" class="order-button">Naruči</v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  name: 'ProductsList',
  data() {
    return {
      products: [
        { id: 1, name: 'GOT 1', image: 'https://shop.skolskaknjiga.hr/media/catalog/product/cache/1/image/1800x/040ec09b1e35df139433887a97daa66f/1/7/174808_3.png', price: 100 },
        { id: 2, name: 'GOT 2', image: 'https://shop.skolskaknjiga.hr/media/catalog/product/1/7/175661.png', price: 150 },
        // Dodaj još proizvoda
      ],
      isUserLoggedIn: true, // Pretpostavka da je korisnik prijavljen
    };
  },
methods: {
  orderProduct(product) {
    axios.post('http://localhost:8000/api/cart/add', {
      book_id: product.id,
      quantity: 1, // Default quantity, možeš dodati mogućnost promjene
      price: product.price
    })
    .then(response => {
      alert(response.data.message);
    })
    .catch(error => {
      alert('Greška prilikom dodavanja u košaricu.');
    });
  }
}

}
</script>

<style scoped>
.product-card {
  border: 1px solid #ddd; /* Tanke sive obrube oko kartica proizvoda */
  border-radius: 8px; /* Zaokruženi kutovi */
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Blaga sjena */
  transition: box-shadow 0.3s ease; /* Animacija sjene pri hover */
}

.product-card:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Intenzivnija sjena pri hover */
}

.product-image {
  border-bottom: 1px solid #ddd; /* Tanka obruba ispod slike */
}

.order-button {
  color: #fff;
  background-color: #f44336; /* Crvena boja za gumb */
  border: none;
  margin-top: 8px; /* Razmak iznad gumba */
}

.order-button:hover {
  background-color: #e53935; /* Tamnija crvena pri hover */
}
</style>
