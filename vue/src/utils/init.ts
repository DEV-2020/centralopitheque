import store from '@/store';
import { getAccessToken, getRefreshToken } from './auth';

const token: string | null = getAccessToken();
const refreshToken: string | null = getRefreshToken();

export default function init(): Promise<void[]> {
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

  const promises: Promise<void>[] = [];

  actions.forEach((action) => {
    action.actions.forEach((el) => {
      promises.push(store.dispatch(`${action.namespace}/${el}`) as Promise<any>);
    });
  });

  return Promise.all(promises);
}
