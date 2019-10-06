/* eslint-disable import/prefer-default-export */

import { User } from '@/types/jwt';

export function readJwt(token: string): User {
  return JSON.parse(atob(token.split('.')[1]));
}

export function updateRefreshToken(token: string): void {
  localStorage.setItem('refreshToken', token);
}

export function updateAccessToken(token: string): void {
  localStorage.setItem('accessToken', token);
}

export function clearTokens(): void {
  localStorage.removeItem('refreshToken');
  localStorage.removeItem('accessToken');
}
