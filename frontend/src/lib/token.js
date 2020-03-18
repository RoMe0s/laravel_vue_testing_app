export const refreshToken = (token, remember = false) => {
  const expiresAt = new Date();
  expiresAt.setDate((new Date()).getDate() + (remember ? 14 : 2)); //two weeks or two days

  localStorage.setItem('token', token);
  localStorage.setItem('token_expires_at', expiresAt.getTime().toString());
};

export const removeToken = () => {
  localStorage.removeItem('token');
  localStorage.removeItem('token_expires_at');
};

export const getToken = () => {
  const token = localStorage.getItem('token');
  const expiresAt = localStorage.getItem('token_expires_at');

  return token && expiresAt && parseInt(expiresAt) > (new Date()).getTime()
    ? token
    : null;
};
