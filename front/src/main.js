import Vue from 'vue';
import App from './App.vue';

// Importa Pinia
import { createPinia, PiniaVuePlugin } from 'pinia';

// Importa BootstrapVue
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

// Configurações
Vue.use(PiniaVuePlugin);
const pinia = createPinia();

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

Vue.config.productionTip = false;

new Vue({
  pinia,
  render: h => h(App),
}).$mount('#app');