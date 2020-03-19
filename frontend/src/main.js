import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import '@/assets/styles/app.css';

import {ValidationProvider, localize} from 'vee-validate';
import en from 'vee-validate/dist/locale/en.json';
localize({en});
Vue.component('ValidationProvider', ValidationProvider);

import {enableCookie} from '@/lib/http';

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App),
  async beforeCreate() {
    await enableCookie();
  }
}).$mount('#app');
