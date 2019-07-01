import Login from './components/Login.vue';
import Home from './components/page/Home.vue';

export const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/home',
        name: 'Home',
        component: Home
    }
];