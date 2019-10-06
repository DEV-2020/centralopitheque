import store from '@/store';
import { getAccessToken, getRefreshToken } from './auth';

const token: string | null = getAccessToken();
const refreshToken: string | null = getRefreshToken();

if (token) {
  store.dispatch('auth/setUser', {
    token,
    refresh_token: refreshToken,
  });
}
