import ForgotPassword from '@/pages/ForgotPassword.vue';
import LandingPage from '@/pages/LandingPage.vue';
import Login from '@/pages/Login.vue';
import Register from '@/pages/Register.vue';
import VerifyEmail from '@/pages/VerifyEmail.vue';
import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    { path: '/', name: 'Landing', component: LandingPage },
    { path: '/login', name: 'Login', component: Login },
    { path: '/register', name: 'Register', component: Register },
    { path: '/forgotpassword', name: 'ForgotPassword', component: ForgotPassword },
    { path: '/verifyemail', name: 'VerifyEmail', component: VerifyEmail },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
