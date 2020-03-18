import {getToken} from '@/lib/token';

export default {
  getToken: getToken,
  getUser: state => state.user,
}