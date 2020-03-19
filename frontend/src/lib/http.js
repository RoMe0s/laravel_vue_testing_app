import axios from "axios";

const apiDomain = 'http://localhost:8000';

axios.defaults.baseURL = apiDomain + '/api/';
axios.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

export const Http = {
  get: axios.get,
  post: axios.post,
  delete: axios.delete
};

export const enableCookie = async () => axios.get(apiDomain + '/airlock/csrf-cookie');
