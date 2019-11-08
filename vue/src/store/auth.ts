/* eslint-disable no-shadow */

import {
  Module, ActionTree, MutationTree, GetterTree,
} from 'vuex';
import { RootState } from '@/types/store';
import { User, LoginJson } from '@/types/jwt';
import { readJwt, clearTokens } from '@/utils/auth';

interface AuthState {
  user?: User;
}

export const state: AuthState = {
  user: undefined,
};

const actions: ActionTree<AuthState, RootState> = {
  setUser({ commit }, data: LoginJson) {
    const user: User = readJwt(data.token);
    commit('SET_USER', user);
  },
  logout({ commit }) {
    clearTokens();
    commit('LOGOUT');
  },
};

const getters: GetterTree<AuthState, RootState> = {
  loggedIn(state: AuthState): boolean {
    return !!state.user;
  },
  user(state: AuthState): User | undefined {
    return state.user;
  },
  isAdmin(state: AuthState): boolean {
    return state.user !== undefined && state.user!.roles.includes('ROLE_ADMIN');
  },
};

const mutations: MutationTree<AuthState> = {
  SET_USER(state: AuthState, payload: User) {
    state.user = payload;
  },
  LOGOUT(state: AuthState) {
    state.user = undefined;
  },
};

const auth: Module<AuthState, RootState> = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};

export default auth;
