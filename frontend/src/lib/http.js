import axios from "axios";
import {getToken} from '@/lib/token';

axios.defaults.baseURL = 'http://localhost:8000/api/';
axios.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

const tokenKeeper = (method) => (...args) => {
  axios.defaults.headers.common["Authorization"] = `Bearer ${getToken()}`;

  return method(...args);
};

export const Http = {
  get: tokenKeeper(axios.get),
  post: tokenKeeper(axios.post),
  put: tokenKeeper(axios.put),
  patch: tokenKeeper(axios.patch),
  delete: tokenKeeper(axios.delete),
  head: tokenKeeper(axios.head)
};
