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
  getShops({ commit }): void {
    api.get<Shop[]>(routes.SHOPS_LIST)
      .then(({ data }) => {
        commit('SET_SHOPS', data);
      })
      .catch(console.error);
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
};

const shop: Module<ShopState, RootState> = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};

export default shop;
