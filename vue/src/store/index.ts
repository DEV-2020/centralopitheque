import Vue from 'vue';
import Vuex, { StoreOptions } from 'vuex';
import { RootState } from '@/types/store';
import auth from './auth';
import shops from './shops';
import spectacles from './spectacles';

Vue.use(Vuex);

const store: StoreOptions<RootState> = {
  state: {
  },
  modules: {
    auth,
    shops,
    spectacles,
  },
};

export default new Vuex.Store<RootState>(store);
