import Echo from 'laravel-echo';
import io from 'socket.io-client';
import {getToken} from '@/lib/token';

export const socket = new Echo({
  broadcaster: 'socket.io',
  host: window.location.hostname + ':6001',
  client: io,
  auth: {
    headers: {
      Authorization: `Bearer ${getToken()}`
    }
  }
});
