/* eslint-disable import/prefer-default-export */

export function readJwt(token: string) {
  return JSON.parse(atob(token.split('.')[1]));
}

export function updateRefreshToken(token: string) {
  localStorage.setItem('refreshToken', token);
}

export function updateAccessToken(token: string) {
  localStorage.setItem('accessToken', token);
}
