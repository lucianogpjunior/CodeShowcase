<template>
  <div id="app">
    <HeaderComponent/>

    <main class="main-content">
      <CardsComponent /> 
      <router-view />
    </main>

    <FooterComponent/>
  </div>
</template>

<script>
//import HelloWorld from './components/HelloWorld.vue'
import HeaderComponent from './components/HeaderComponent.vue';
import FooterComponent from './components/FooterComponent.vue';
import CardsComponent from './components/CardsComponent.vue';

export default {
  name: 'App',
  components: {
    HeaderComponent,
    FooterComponent,
    CardsComponent
  }
}
</script>
  
<style>
/* 1. O corpo do site deve ocupar a tela toda */
html, body {
  height: 100%;
  margin: 0;
}

/* 2. O container que envolve Header, Main e Footer */
.app-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* Altura mínima de 100% da tela */
}

/* 3. O 'main' que contém os cards */
.main-content {
  flex: 1; /* Isso faz o main "empurrar" o footer para baixo */
  display: block;
  position: relative;
  /* Adicione um padding para os cards não colarem no header ou footer */
  padding: 20px 0; 
}
</style>
