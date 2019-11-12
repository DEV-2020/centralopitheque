/* eslint-disable no-shadow */

import {
  Module, ActionTree, MutationTree, GetterTree,
} from 'vuex';
import api from '@/utils/api';
import routes from '@/constants/routes';
import { RootState } from '@/types/store';
import { Spectacle } from '@/types/spectacles';

interface SpectacleState {
  spectacles: Spectacle[];
}

export const state: SpectacleState = {
  spectacles: [],
};

const actions: ActionTree<SpectacleState, RootState> = {
  setSpectacles({ commit }, data: Spectacle[]): void {
    commit('SET_SPECTACLES', data);
  },
  getSpectacles({ commit }): void {
    api.get<Spectacle[]>(routes.SPECTACLES_LIST)
      .then(({ data }) => {
        commit('SET_SPECTACLES', data);
      })
      .catch(console.error);
  },
};

const getters: GetterTree<SpectacleState, RootState> = {
  spectacles(state: SpectacleState): Spectacle[] {
    return state.spectacles;
  },
};

const mutations: MutationTree<SpectacleState> = {
  SET_SPECTACLES(state: SpectacleState, payload: Spectacle[]) {
    state.spectacles = payload;
  },
};

const shop: Module<SpectacleState, RootState> = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};

export default shop;
