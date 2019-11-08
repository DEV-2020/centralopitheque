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
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import(/* webpackChunkName: "sign-in" */ '@/views/Dashboard.vue'),
  },
];

export default routes;
