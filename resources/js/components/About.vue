<template>
  <div class="about-container">
    <div class="text-box">
      <h1 class="about-title">Autorica</h1>
      <p class="about-text">
        Pedagoginja po struci, Vinkovčanka Kristina Kulić zna koliko je važno djecu poticati na učenje od najranije dobi. Izazov u odgajanju i poučavanju svoja dva dječaka istih razvojnih potreba potaknuo ju je na razvijanje interaktivne mape kako bi ih zainteresirala i zabavila. Potez se pokazao kao pun pogodak pa se njezina privatna zbirka vrlo brzo proširila i na drugu djecu. Njezina Knjižuljica oduševljava i male i velike, a najsretnija je, kaže, što ispunjava svoju svrhu – djeca ju vole, zabavna im je i uz nju uče. Interaktivna mapa za poticanje ranog učenja donosi aktivnosti kakve se mogu pronaći u Montessori pedagogiji, a uključuje sličice koje se lijepe čičak točkama i piši-briši zadatci.
      </p>
      <p class="about-text">
        „Izrađujem i kartice za učenje namijenjene za učenje pojmova, razvoj i poticanje govora te za poticanje učenja djece s posebnim potrebama. Podijeljene su po kategorijama, npr. životinje, voće i povrće, osjećaji, zanimanja, boje, itd“, priča nam ova 35-godišnjakinja, magistrica pedagogije i edukacije filozofije, trenutno zaposlena u osnovnoj školi kao stručna suradnica pedagoginja.
      </p>
    </div>
    <div class="image-container">
      <img src="../slike/autorica.png" alt="Slika autorice" class="author-image" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'About',
};
</script>

<style scoped>
.about-container {
  display: flex;
  justify-content: space-between; /* Razmak između teksta i slike */
  align-items: flex-start; /* Poravnanje elemenata prema vrhu */
  padding: 20px;
  border: 1px solid #ccc; /* Blagi rub oko cijelog sadržaja */
  border-radius: 10px; /* Zaobljeni rubovi */
  background-color: #f9f9f9; /* Lagana pozadina */
}

.text-box {
  flex: 1; /* Zauzima veći dio prostora za tekst */
  margin-right: 20px; /* Razmak između teksta i slike */
}

.author-image {
  max-width: 300px; /* Maksimalna širina slike */
  height: auto;
  border-radius: 10px; /* Zaobljeni rubovi slike */
}

.about-title {
  font-size: 32px;
  font-weight: bold;
  color: #3f51b5;
  margin-bottom: 20px;
}

.about-text {
  font-size: 16px;
  color: #555;
  line-height: 1.6;
}
</style>
