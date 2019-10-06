import { RouteConfig } from 'vue-router';
import Home from '@/views/Home.vue';

const routes: RouteConfig[] = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/sign-up',
    name: 'sign-up',
    component: () => import(/* webpackChunkName: "sign-up" */ '@/views/SignUp.vue'),
  },
  {
    path: '/sign-in',
    name: 'sign-in',
    component: () => import(/* webpackChunkName: "sign-in" */ '@/views/SignIn.vue'),
  },
];

export default routes;
