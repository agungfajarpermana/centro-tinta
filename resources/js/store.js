import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        checkout: {
            check: false,
            mode: 'cash'
        }
    },
    getters: {
        mode(state){
            return state.checkout.mode
        }
    },
    mutations: {},
    actions: {}
});