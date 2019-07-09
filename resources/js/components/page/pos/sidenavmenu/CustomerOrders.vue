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
                <tr v-if="!loadingOrder">
                    <td colspan="14">
                        <div class="center-align animated flash loader">
                            Loading...
                        </div>
                    </td>
                </tr>

                <tr v-else class="animated" :class="{'fadeIn':loadingOrder}" v-for="order in orders" :key="order.customer_order.uniqid">
                    <td>INV-{{ order.customer_order.order }}</td>
                    <td colspan="5">{{ order.customer_order.branches }}</td>
                    <td colspan="5">{{ order.customer_order.customer }}</td>
                    <td colspan="2" class="center-align">{{ order.customer_order.qty }}</td>
                    <td colspan="2">Rp. {{ parseInt(order.customer_order.total_sales).toLocaleString('id') }}</td>
                    <td>
                        <i class="tiny material-icons teal-text">remove_red_eye</i> &nbsp;
                        <i class="tiny material-icons blue-text">edit</i> &nbsp;
                        <i class="tiny material-icons red-text">delete</i>
                    </td>
                </tr>
            </tbody>
        </table>

        <FooterOrder v-if="loadingOrder" />
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
        FooterOrder
    },
    computed: {
        loadingOrder(){
            return this.$store.getters.loadingOrder
        },

        orders(){
            return this.$store.getters.orders
        }
    },
    mounted(){
        this.$store.dispatch('getOrder', 'api/order')
    },
    watch: {
        searchOrder: _.debounce((event) => {
            Bus.$emit('searchCustomerOrder', event.trim())
        }, 800)
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
