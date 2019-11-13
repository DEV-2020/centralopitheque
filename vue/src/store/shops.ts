/* eslint-disable no-shadow */

import {
  Module, ActionTree, MutationTree, GetterTree,
} from 'vuex';
import api from '@/utils/api';
import routes from '@/constants/routes';
import { RootState } from '@/types/store';
import { Shop } from '@/types/shops';

interface ShopState {
  shops: Shop[];
}

export const state: ShopState = {
  shops: [],
};

const actions: ActionTree<ShopState, RootState> = {
  setShops({ commit }, data: Shop[]) {
    commit('SET_SHOPS', data);
  },
  getShops({ commit }): Promise<void> {
    return api.get<Shop[]>(routes.SHOPS_LIST)
      .then(({ data }) => {
        commit('SET_SHOPS', data);
      })
      .catch(console.error);
  },
  updateShop({ commit }, data: Shop): void {
    commit('UPDATE_SHOP', data);
  },
};

const getters: GetterTree<ShopState, RootState> = {
  shops(state: ShopState): Shop[] {
    return state.shops;
  },
};

const mutations: MutationTree<ShopState> = {
  SET_SHOPS(state: ShopState, payload: Shop[]) {
    state.shops = payload;
  },
  UPDATE_SHOP(state: ShopState, payload: Shop): void {
    const index = state.shops.findIndex(shop => shop.id === payload.id);
    state.shops.splice(index, 1, payload);
  },
};

const shop: Module<ShopState, RootState> = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};

export default shop;
