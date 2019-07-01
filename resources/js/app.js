require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import MainApp from './components/MainApp.vue';
import 'materialize-css/dist/js/materialize.min';

import { routes } from './routes';
import { store } from './store';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router,
    store,
    components:{
        MainApp
    }
});
