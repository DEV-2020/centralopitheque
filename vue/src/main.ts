import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import i18n from './i18n';
import api from './utils/api';
import './plugins';
import './plugins/components';
import init from './utils/init';

Vue.config.productionTip = false;
Vue.prototype.$api = api;

init()
  .finally(() => {
    new Vue({
      router,
      store,
      i18n,
      render: h => h(App),
    }).$mount('#app');
  });
