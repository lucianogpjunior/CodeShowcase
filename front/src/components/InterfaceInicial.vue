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
import HeaderComponent from './HeaderComponent.vue';
import FooterComponent from './FooterComponent.vue';
import CardsComponent from './CardsComponent.vue';

export default{
    name: 'InterfaceInicial',
    components: {
        HeaderComponent,
        FooterComponent,
        CardsComponent
    }
}

</script>

<style scoped>
</style>