require('./bootstrap');

import Vue from 'vue';
import moment from 'moment';
import Vuelidate from 'vuelidate';
import VueRouter from 'vue-router';
import VueNumber from 'vue-number-animation';
import MainApp from './components/MainApp.vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'materialize-css/dist/js/materialize.min';
import 'sweetalert2/dist/sweetalert2.min.css';

import { routes } from './routes';
import { store } from './store';

Vue.use(VueRouter);
Vue.use(VueNumber);
Vue.use(Vuelidate);
Vue.use(VueSweetalert2);

Vue.filter('dateformat', (value) => {
    return moment(value).format('D MMMM, Y')
})

export const Bus = new Vue();

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
