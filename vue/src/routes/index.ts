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
  {
    path: '/dashboard/spectacles/manage',
    name: 'spectacles-manage',
    component: () => import(/* webpackChunkName: "spectacles-manage" */ '@/views/ManageSpectacles.vue'),
  },
  {
    path: '/dashboard/spectacles/manage/add',
    name: 'new-spectacle',
    component: () => import(/* webpackChunkName: "new-spectacle" */ '@/views/SpectacleNew.vue'),
  },
];

export default routes;
