import Echo from 'laravel-echo';
import io from 'socket.io-client';

export const socket = new Echo({
  broadcaster: 'socket.io',
  host: window.location.hostname + ':6001',
  client: io
});
