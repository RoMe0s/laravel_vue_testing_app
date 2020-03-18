import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

import user from '@/store/user';
import monitors from '@/store/monitors';

export default new Vuex.Store({
  modules: {
    user,
    monitors
  }
})
