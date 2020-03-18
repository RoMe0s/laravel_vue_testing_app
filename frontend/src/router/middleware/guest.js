export default function guest({next, store}) {
  const user = store.getters['user/getUser'];
  if (undefined === user || null === user) {
    return next();
  }
  return next({name: 'home'});
}