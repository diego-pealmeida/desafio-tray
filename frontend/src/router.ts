import { createRouter, createWebHashHistory, type RouteRecordRaw } from "vue-router";
import PublicLayout from '@/layouts/PublicLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';

import LoginPage from "@/pages/LoginPage.vue";
import OrdersPage from "@/pages/OrdersPage.vue";
import SellersPage from "@/pages/SellersPage.vue";

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        component: PublicLayout,
        children: [
            { path: '', redirect: '/login' },
            { path: 'login', component: LoginPage }
        ]
    },
    {
        path: '/',
        component: AuthLayout,
        meta: { requiresAuth: true },
        children: [
            { path: 'orders', component: OrdersPage },
            { path: 'sellers', component: SellersPage }
        ]
    }
];

const router = createRouter({
    history: createWebHashHistory(),
    routes
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token'); // ou use um store
  if (to.path !== '/login' && to.meta.requiresAuth && !isAuthenticated) {
    next('/login');
  } else if (to.path === '/login' && isAuthenticated) {
    next('/orders');
  } else {
    next();
  }
});

export default router;