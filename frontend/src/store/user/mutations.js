import {refreshToken, removeToken} from '@/lib/token';

export default {
  setToken(state, token, remember = false) {
    refreshToken(token, remember);
  },
  removeToken,
  setUser(state, user) {
    state.user = user;
  }
}