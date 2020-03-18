export default function authenticated({next, store}) {
  const user = store.getters['user/getUser'];
  if (undefined === user || null === user) {
    return next({name: 'login'});
  }
  return next();
}