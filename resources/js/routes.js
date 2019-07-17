import Login from './components/Login.vue';
import Home from './components/page/Home.vue';
import Cash from './components/page/kas/Cash';
import PosManagement from './components/page/pos/PosManagement.vue';

export const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/dashboard',
        name: 'Home',
        component: Home
    },
    {
        path: '/cash',
        name: 'Cash',
        component: Cash
    },
    {
        path: '/management',
        name: 'POS',
        component: PosManagement
    }
];