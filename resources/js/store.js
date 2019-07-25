import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        checkout: {
            check: false,
            mode: 'cash',
            order: null,
            numberFrom: 0,
            duration: 2,
            items: [],
            subtotal: 0,
            ppn: 0,
            total: 0
        },
        product: {
            loadingFirst: false,
            loading: false,
            items: [],
            attrPagination: []
        },
        customer: {
            loadingOrder: false,
            orders: [],
            attrPaginationOrder: []
        },
        management: {
            loadingManage: false,
            items: [],
            attrPaginationManagement: []
        },
        laporan: {
            piutang: {
                date: [],
                search: ''
            },
            penjualan: {
                date: [],
                search: ''
            },
            cash: {
                date: [],
                search: ''
            }
        },

        customers: {
            valueCust: null,
            disabled: false,
            loadingDisplay: true,
            customerName: [],
            customerDetail: []
        },

        modal: {
            customerModal: [],
            ordersModal: [],
            loadingModal: false
        }
    },
    getters: {
        // state checkout
        mode(state){
            return state.checkout.mode
        },

        order(state){
            return state.checkout.order
        },

        numberFrom(state){
            return state.checkout.numberFrom
        },

        duration(state){
            return state.checkout.duration
        },

        itemsCheckout(state){
            return state.checkout.items
        },

        subtotal(state){
            return state.checkout.subtotal
        },

        ppn(state){
            return state.checkout.ppn
        },

        total(state){
            return state.checkout.total
        },

        // state product
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

        loadingOrder(state){
            return state.customer.loadingOrder
        },

        orders(state){
            return state.customer.orders
        },

        attrPaginationOrder(state){
            return state.customer.attrPaginationOrder
        },

        loadingManage(state){
            return state.management.loadingManage
        },

        manageItems(state){
            return state.management.items
        },

        attrPaginationManagement(state){
            return state.management.attrPaginationManagement
        },

        // laporan CASH, PIUTANG, PENJUALAN
        piutangDate(state){
            return state.laporan.piutang.date
        },

        piutangSearch(state){
            return state.laporan.piutang.search
        },
        
        penjualanDate(state){
            return state.laporan.penjualan.date
        },

        penjualanSearch(state){
            return state.laporan.penjualan.search
        },

        cashDate(state){
            return state.laporan.cash.date
        },

        cashSearch(state){
            return state.laporan.cash.search
        },

        // data customer
        valueCust(state){
            return state.customers.valueCust
        },

        disabled(state){
           return state.customers.disabled
        },
        
        customerName(state){
            return state.customers.customerName
        },

        customerDetail(state){
            return state.customers.customerDetail
        },

        loadingDisplay(state){
            return state.customers.loadingDisplay
        },

        customerModal(state){
            return state.modal.customerModal
        },

        ordersModal(state){
            return state.modal.ordersModal
        },

        loadingModal(state){
            return state.modal.loadingModal
        }
    },
    mutations: {
        SET_DATA_PRODUCT_ITEMS(state, payloadProduct){
            const item = []
            payloadProduct.data.map(val => {
                item.push(Object.assign({}, val, {button:false,btnTextProduct:"pilih"}))
            })
            
            // validation condition button, btnTextProduct, stock
            const itemCheckout = state.checkout.items.map(itemCheckout => {
                return itemCheckout
            })

            item.forEach(productItem => {
                itemCheckout.forEach(productCheckout => {
                    if(productItem.detail_product.uniqid === productCheckout.detail_product.uniqid){
                        productItem.detail_stock.last_stock = productItem.detail_stock.last_stock - productCheckout.numberOfPurchases
                        
                        if(productItem.detail_stock.last_stock == 0){
                            productItem.button = true
                            productItem.btnTextProduct = 'stok habis'
                        }
                    }
                })
            })
            // end validation condition button, btnTextProduct, stock

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

            state.product.items.sort((a,b) => {
                if(a.detail_product.product < b.detail_product.product){
                    return -1
                }else if(a.detail_product.product > b.detail_product.product){
                    return 1
                }
            })
        },

        SET_DATA_PRODUCT_PAGINATION(state, payloadUrlProduct){
            state.product.loading = !state.product.loading
            store.dispatch('getProducts', payloadUrlProduct)
        },

        PUSH_ITEM_PRODUCT_TO_CHECK_OUT(state, items){
            const productCheckout = store.getters.itemsCheckout.find(products => products.detail_product.uniqid == items.id);
            
            if(!productCheckout){
                state.checkout.items.push(Object.assign({}, items.product, {numberOfPurchases:1}))
            }else{
                productCheckout.numberOfPurchases++
            }

            const priceProduct = store.getters.itemsCheckout.map((val,key) => {
                return val.detail_product.price * val.numberOfPurchases
            })

            const subtotal = priceProduct.reduce((accumulator, currentValue) => {
                return accumulator + currentValue
            })

            state.checkout.subtotal = subtotal
            state.checkout.ppn = (10 * subtotal)/100
            state.checkout.total = state.checkout.subtotal + state.checkout.ppn
        },

        DELETE_ITEM_PRODUCT_TO_CHECK_OUT(state, items){
            const products = state.product.items.find(product => product.detail_product.uniqid == items.id)

            const priceProduct = store.getters.itemsCheckout.map((val,key) => {
                return val.detail_product.price * val.numberOfPurchases
            })

            const subtotal = priceProduct.reduce((accumulator, currentValue) => {
                return accumulator + currentValue
            })

            items.itemsCheckout.numberOfPurchases--
            
            if(products){
                products.detail_stock.last_stock++

                if(products.detail_stock.last_stock > 0){
                    products.button = false
                    products.btnTextProduct = 'pilih'
                }
            }

            state.checkout.subtotal = subtotal - items.itemsCheckout.detail_product.price
            state.checkout.ppn = (10 * state.checkout.subtotal)/100
            state.checkout.total = state.checkout.subtotal + state.checkout.ppn

            if(items.itemsCheckout.numberOfPurchases >= 0 && items.itemsCheckout.numberOfPurchases <= 0){
                setTimeout(() => {
                    state.checkout.items.splice(items.key, 1)
                }, 100)
            }
        },

        CLEAR_ITEM_PRODUCT_TO_CHECKOUT(state){
            let i = 0
            while(state.checkout.items.length){
                let subtotal;
                const products = state.product.items.find(product => product.detail_product.uniqid == state.checkout.items[i].detail_product.uniqid)
                
                if(products){
                    subtotal = products.detail_product.price * state.checkout.items[i].numberOfPurchases
                
                    // set stock product items
                    products.detail_stock.last_stock = products.detail_stock.last_stock + state.checkout.items[i].numberOfPurchases
                    if(products.detail_stock.last_stock > 0){
                        products.button = false
                        products.btnTextProduct = 'pilih'
                    }
                }
                
                state.checkout.subtotal = (subtotal ? subtotal - (state.checkout.items[i].detail_product.price * state.checkout.items[i].numberOfPurchases) : 0)
                state.checkout.ppn = (10 * state.checkout.subtotal)/100
                state.checkout.total = state.checkout.subtotal - state.checkout.ppn
                
                state.checkout.items.splice(i, 1)
            }
        },

        SET_DATA_ORDER_CUSTOMER(state, payloadOrder){

            let data = []
            state.customer.loadingOrder = true

            // payloadOrder.data.map((item, key) => {
            //     if(data.length < 1){
            //         data.push(item)
            //     }else{
            //         data.map(items => {
            //             if(items.customer_order.order !== data.customer_order.order){
            //                 console.log('hai')
            //                 data.push(item)
            //             }
            //         })
            //     }
            //     console.log(state.customer.orders)
            // });

            state.customer.orders = payloadOrder.data

            const pagination = {
                current_page : payloadOrder.meta.current_page,
                last_page    : payloadOrder.meta.last_page,
                next_page_url: payloadOrder.links.next,
                prev_page_url: payloadOrder.links.prev
            }

            state.customer.attrPaginationOrder = pagination
        },

        SET_DATA_ORDER_PAGINATION(state, payloadUrlOrder){
            state.customer.loadingOrder = !state.customer.loadingOrder
            store.dispatch('getOrder', payloadUrlOrder)
        },

        SET_DATA_SEARCH_ORDER(state, payloadSearchOrder){
            let url

            if(payloadSearchOrder.search){
                url = `${payloadSearchOrder.url}/${payloadSearchOrder.search}/customer`
            }else{
                url = 'api/order'
            }

            state.customer.loadingOrder = false
            store.dispatch('getOrder', url)
        },

        SET_DATA_ITEM_MANAGEMENT(state, payloadItemManagement){
            const item = []
            payloadItemManagement.data.map(val => {
                item.push(Object.assign({}, val.detail_product, {stock:val.detail_stock.last_stock}))
            })

            const pagination = {
                current_page    : payloadItemManagement.meta.current_page,
                last_page       : payloadItemManagement.meta.last_page,
                next_page_url   : payloadItemManagement.links.next,
                prev_page_url   : payloadItemManagement.links.prev
            }

            state.management.loadingManage = true
            state.management.items = item
            state.management.attrPaginationManagement = pagination
        },

        SET_DATA_MANAGEMENT_PAGINATION(state, payloadUrlManage){
            state.management.loadingManage = !state.management.loadingManage
            store.dispatch('getItemManagement', payloadUrlManage)
        },

        SET_DATA_SEARCH_ITEM_MANAGEMENT(state, payloadSearchItem){
            let url;

            if(payloadSearchItem.search){
                url = `${payloadSearchItem.url}/${payloadSearchItem.search}/items`
            }else{
                url = 'api/products'
            }

            state.management.loadingManage = false
            store.dispatch('getItemManagement', url)
        },

        SET_DATA_CUSTOMER_SALES(state, payloadCustomer){
            let customers = []
            payloadCustomer.data.map(val => {
                customers.push(val)
            })

            state.customers.customerName = customers
        },

        SET_DATA_CUSTOMER_AFTER_SEARCH(state, payloadCustomer){
            state.customers.loadingDisplay = true
            state.customers.customerDetail = payloadCustomer.data
        },

        SET_DATA_CUSTOMER_MODAL(state, id){
            let order = state.customer.orders.find(x => x.customer_order.uniqid == id);
            state.modal.customerModal = order.customer_order

            store.dispatch('getDetailSalesCustomer', `api/order/${order.customer_order.order}/customers`)
        },

        SET_DATA_CUSTOMER_ORDERS(state, data){
            state.modal.loadingModal = false
            state.modal.ordersModal = data
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
        },

        pushItemToCheckOut({commit}, items){
            commit('PUSH_ITEM_PRODUCT_TO_CHECK_OUT', items)
        },

        cancelItems({commit}, items){
            commit('DELETE_ITEM_PRODUCT_TO_CHECK_OUT', items)
        },

        clearItemCheckout({commit}){
            commit('CLEAR_ITEM_PRODUCT_TO_CHECKOUT')
        },

        getOrder({commit}, url){
            axios.get(url)
                .then(res => {
                    commit('SET_DATA_ORDER_CUSTOMER', res.data)
                }).catch(err => {
                    console.log(err)
                })
        },

        getdataOrderPagination({commit}, url){
            commit('SET_DATA_ORDER_PAGINATION', url)
        },

        searchDataCustomerOrder({commit}, data){
            commit("SET_DATA_SEARCH_ORDER", data)
        },

        getItemManagement({commit}, url){
            axios.get(url)
                .then(res => {
                    commit('SET_DATA_ITEM_MANAGEMENT', res.data)
                }).catch(err => {
                    console.log(err)
                })
        },

        getDataPaginationManage({commit}, url){
            commit('SET_DATA_MANAGEMENT_PAGINATION', url)
        },

        searchDataItemManagement({commit}, value){
            commit('SET_DATA_SEARCH_ITEM_MANAGEMENT', value)
        },

        // data customer
        getDataCustomer({commit}, url){
            axios.get(url)
                .then(res => {
                    commit('SET_DATA_CUSTOMER_SALES', res.data)
                }).catch(err => {
                    console.log(err.response)
                })
        },

        detailDataCustomer({commit}, data){
            store.state.customers.loadingDisplay = false

            axios.post(data)
                .then(res => {
                    commit('SET_DATA_CUSTOMER_AFTER_SEARCH', res.data)
                }).catch(err => {
                    console.log(err.response)
                })
        },

        customerOrderModal({commit}, id){
            commit('SET_DATA_CUSTOMER_MODAL', id)
        },

        getDetailSalesCustomer({commit}, url){
            axios.get(url)
                .then(res => {
                    
                    commit('SET_DATA_CUSTOMER_ORDERS', res.data.data)

                }).catch(err => {

                    console.log(err)

                })
        },

        saveDataCustomerSales({commit}, url){
            return new Promise((resolve, reject) => {
                axios.post(url, {
                    order: store.state.checkout.order,
                    customerId: store.state.customers.customerDetail.uniqid,
                    products: store.state.checkout.items
                }).then(res => {
                    
                    commit('CLEAR_ITEM_PRODUCT_TO_CHECKOUT')
                    resolve(res)
    
                }).catch(err => {
                    
                    reject(err)

                })
            })
        }
    }
});