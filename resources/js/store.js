import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        checkout: {
            check: false,
            mode: 'cash'
        },
        product: {
            loadingFirst: false,
            loading: false,
            items: [],
            attrPagination: []
        }
    },
    getters: {
        mode(state){
            return state.checkout.mode
        },
        loadingFirst(state){
            return state.product.loadingFirst
        },
        loading(state){
            return state.product.loading
        },
        products(state){
            return state.product.items
        },
        attrPagination(state){
            return state.product.attrPagination
        },
    },
    mutations: {
        SET_DATA_PRODUCT_ITEMS(state, payloadProduct){
            const item = []
            payloadProduct.data.map(val => {
                item.push(Object.assign({}, val, {button:false,btnTextProduct:"pilih"}))
            })
            
            const pagination = {
                current_page : payloadProduct.meta.current_page,
                last_page    : payloadProduct.meta.last_page,
                next_page_url: payloadProduct.links.next,
                prev_page_url: payloadProduct.links.prev
            }

            state.product.loadingFirst   = true
            state.product.loading        = true
            state.product.items          = item
            state.product.attrPagination = pagination
        },
        SET_DATA_PRODUCT_PAGINATION(state, payloadUrlProduct){
            state.product.loading = !state.product.loading
            store.dispatch('getProducts', payloadUrlProduct)
        }
    },
    actions: {
        getProducts({commit}, url){
            axios.get(url)
                .then(res => {
                    commit("SET_DATA_PRODUCT_ITEMS", res.data)
                })
        },
        getDataProductPagination({commit}, url){
            commit("SET_DATA_PRODUCT_PAGINATION", url)
        }
    }
});