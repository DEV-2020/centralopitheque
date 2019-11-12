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

const actions = [
  {
    namespace: 'spectacles',
    actions: [
      'getSpectacles',
    ],
  },
  {
    namespace: 'shops',
    actions: [
      'getShops',
    ],
  },
];

actions.forEach((action) => {
  action.actions.forEach((el) => {
    store.dispatch(`${action.namespace}/${el}`);
  });
});
