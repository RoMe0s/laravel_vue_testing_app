import {Http} from '@/lib/http';

export default {
  async authorize({commit, dispatch}, {email, password, remember}) {
    try {
      await Http.post('/login', {email, password, remember});
      await dispatch('fetchUser');
    } catch (e) {
      commit('setUser', null);
      throw e;
    }
  },
  async register(_context, {email, name, password, password_confirmation}) {
    await Http.post('/register', {email, name, password, password_confirmation});
  },
  async logout({commit}) {
    await Http.post('/logout');
    commit('setUser', null);
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
    if (getters.getUser === undefined) {
      await dispatch('fetchUser');
    }
  }
}