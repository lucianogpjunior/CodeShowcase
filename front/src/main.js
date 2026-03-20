import Vue from 'vue';
import App from './App.vue';
import { createPinia } from "pinia";

const pinia = createPinia()

Vue.config.productionTip = false

new Vue({
  pinia,
  render: h => h(App),
}).$mount('#app')
