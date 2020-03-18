import {Http} from '@/lib/http';

export default {
  async authorize({dispatch, commit}, {email, password, remember}) {
    try {
      const {data} = await Http.post('/login', {email, password});

      commit('setToken', data.token, remember);
      await dispatch('fetchUser');
    } catch (e) {
      commit('removeToken');
      throw e;
    }
  },
  async register({}, {email, name, password, password_confirmation}) {
    await Http.post('/register', {email, name, password, password_confirmation});
  },
  logout({commit}) {
    commit('setUser', null);
    commit('removeToken');
  },

  async fetchUser({commit}) {
    try {
      const {data} = await Http.get('/user');

      commit('setUser', data);
    } catch (e) {
      commit('setUser', null);
    }
  },
  async fetchUserOnce({dispatch, getters}) {
    if (
      typeof getters.getToken === typeof ''
      && getters.getUser === undefined
    ) {
      await dispatch('fetchUser');
    }
  }
}