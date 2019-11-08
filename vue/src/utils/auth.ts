/* eslint-disable import/prefer-default-export */

import axios from 'axios';
import routes from '@/constants/routes';
import { LoginJson, JWT } from '@/types/jwt';

export function readJwt(token: string): JWT {
  return JSON.parse(atob(token.split('.')[1]));
}

export function updateRefreshToken(token: string): void {
  localStorage.setItem('refreshToken', token);
}

export function updateAccessToken(token: string): void {
  localStorage.setItem('accessToken', token);
}

export function getAccessToken(): string | null {
  return localStorage.getItem('accessToken');
}

export function getRefreshToken(): string | null {
  return localStorage.getItem('refreshToken');
}

export function clearTokens(): void {
  localStorage.removeItem('refreshToken');
  localStorage.removeItem('accessToken');
}

export function isTokenValid(): boolean {
  const token = getAccessToken();
  if (!token) return false;

  const jwt = readJwt(token);
  return jwt.exp * 1000 > Date.now();
}

export function refreshToken(): Promise<void> {
  const token = getRefreshToken();
  return axios.post<LoginJson>(routes.TOKEN_REFRESH, {
    refresh_token: token,
  })
    .then(({ data }) => {
      updateAccessToken(data.token);
      updateRefreshToken(data.refresh_token);
    })
    .catch(console.log);
}
