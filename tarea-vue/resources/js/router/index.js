import { createRouter, createWebHistory } from 'vue-router';

import WelcomePage from '../views/WelcomePage.vue'
import Dashboard from "../views/Dashboard.vue"


const routes = [
    { path: '/', component: WelcomePage },
    { path: '/dashboard', component: Dashboard },
    {path: '/authors',name: 'authors',component: () => import('@/views/Authors.vue')},
    {path: '/publishers',name: 'publishers',component: () => import('@/views/Publishers.vue')},
    {path: '/books',name: 'books',component: () => import('@/views/Books.vue')}
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
