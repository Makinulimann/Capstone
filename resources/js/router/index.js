import LandingPage from '@/pages/LandingPage.vue';
import { createRouter, createWebHistory } from 'vue-router';

const routes = [{ path: '/', name: 'Landing', component: LandingPage }];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
