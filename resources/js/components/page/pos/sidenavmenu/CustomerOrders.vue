<template>
    <div v-if="menu == 'CO'" class="banner-card">
        <div class="row">
            <div class="col s8 m8 l8">
                <span class="card-title">Customer Order</span>
            </div>

            <div class="input-field col s4 m4 l4" style="margin-top:-15px;">
                <input type="text" v-model="searchOrder" placeholder="Search by no.order">
            </div>
        </div>
        <table class="striped responsive-table">
            <thead>
                <tr>
                    <th>No.Order</th>
                    <th colspan="5">Branches</th>
                    <th colspan="5">Customer</th>
                    <th colspan="2" class="center-align">Total Items</th>
                    <th colspan="2">Total Price</th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="loadingOrder && orders.length < 1">
                    <td colspan="14">
                        <div class="center-align animated flash loader">
                            No.order yang dicari tidak ditemukan!
                        </div>
                    </td>
                </tr>

                <tr v-if="!loadingOrder">
                    <td colspan="14">
                        <div class="center-align animated flash loader">
                            Loading...
                        </div>
                    </td>
                </tr>

                <tr v-else class="animated" :class="{'fadeIn':loadingOrder}" v-for="(order, index) in orders" :key="order.customer_order.uniqid">
                    <td>INV-{{ order.customer_order.order }}</td>
                    <td colspan="5">{{ order.customer_order.branches }}</td>
                    <td colspan="5">{{ order.customer_order.customer }}</td>
                    <td colspan="2" class="center-align">{{ order.customer_order.qty }}</td>
                    <td colspan="2">Rp. {{ parseInt(order.customer_order.total_sales).toLocaleString('id') }}</td>
                    <td>
                        <a href="#modal1" class="modal-trigger"
                            @click.prevent="customerOrderModal(index, order.customer_order.uniqid)"    
                        >
                            <i class="tiny material-icons teal-text">remove_red_eye</i>
                        </a> &nbsp;
                        <a href="#">
                            <i class="tiny material-icons blue-text">edit</i>
                        </a> &nbsp;
                        <i class="tiny material-icons red-text">delete</i>
                    </td>
                </tr>
            </tbody>
        </table>

        <FooterOrder v-if="loadingOrder && orders.length > 0" />

        <!-- Modal Structure -->
        <div id="modal1" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h5>{{ customerModal.customer }}</h5>
                <p>No.order</p>
                <p>INV-{{ customerModal.order }}</p>
                <br>
                <div class="row">
                    <div class="container-fluid">
                        <div class="col s4 m4 l4">
                            <p>Cabang</p>
                            <p>{{ customerModal.branches }}</p>
                        </div>

                        <div class="col s4 m4 l4">
                            <p class="center-align">Total Item</p>
                            <p class="center-align">{{ customerModal.qty }}</p>
                        </div>

                        <div class="col s4 m4 l4">
                            <p class="right-align">Total Harga</p>
                            <p class="right-align">Rp. {{ parseInt(customerModal.total_sales).toLocaleString('id') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="container-fluid">
                        <div class="col s12 m12 l12">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th class="left-align">Product</th>
                                        <th class="center-align">Qty</th>
                                        <th class="right-align">Price</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-if="loadingModal">
                                        <td colspan="3" class="center-align">
                                            Loading..
                                        </td>
                                    </tr>

                                    <tr v-else v-for="(order, index) in ordersModal" :key="index">
                                        <td class="left-align">{{ order.product }}</td>
                                        <td class="center-align">{{ order.qty }}</td>
                                        <td class="right-align">Rp. {{ parseInt(order.total).toLocaleString('id') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" :disabled="loadingModal" class="waves-effect waves-green btn"
                    @click="printSuratJalan(customerModal.order)">Surat Jalan</a>
            </div>
        </div>
    </div>
</template>

<script>
import FooterOrder from './FooterOrder';
import { Bus } from '../../../../app';
import _ from 'lodash';

export default {
    props: {
        menu: {
            type: String,
            required: true
        }
    },
    data(){
        return {
            searchOrder: ''
        }
    },
    components: {
        FooterOrder,
    },
    computed: {
        loadingOrder(){
            return this.$store.getters.loadingOrder
        },

        orders(){
            return this.$store.getters.orders
        },

        customerModal(){
            return this.$store.getters.customerModal
        },

        ordersModal(){
            return this.$store.getters.ordersModal
        },

        loadingModal(){
            return this.$store.getters.loadingModal
        }
    },
    mounted(){
        M.AutoInit();
        this.$store.dispatch('getOrder', 'api/order')
    },
    watch: {
        searchOrder: _.debounce((event) => {
            Bus.$emit('searchCustomerOrder', event.trim())
        }, 800)
    },
    methods: {
        customerOrderModal(index, id){
            this.$store.state.modal.loadingModal = true
            this.$store.dispatch('customerOrderModal', id)
        },

        printSuratJalan(order){
            window.open(`api/laporan/${order}/customer`, '_blank')
        }
    }
}
</script>

<style scoped>
i:hover{
    cursor: pointer;
}

.banner-card{
    margin-bottom: -20px;
}
</style>
