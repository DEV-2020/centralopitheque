/**
 * Augment the typings of Vue.js
 */

import Vue from 'vue';
import { AxiosInstance } from 'axios';

declare module 'vue/types/vue' {
  interface Vue {
    $api: AxiosInstance;
  }
}
