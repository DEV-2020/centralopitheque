import Vue from 'vue';
import Vuex, { StoreOptions } from 'vuex';
import { RootState } from '@/types/store';
import auth from './auth';

Vue.use(Vuex);

const store: StoreOptions<RootState> = {
  state: {
  },
  modules: {
    auth,
  },
};

export default new Vuex.Store<RootState>(store);
