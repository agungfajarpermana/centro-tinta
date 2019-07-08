<template>
    <div v-if="menu == 'CO'" class="banner-card">
        <span class="card-title">Customer Orders</span>
        <table class="striped">
            <thead>
                <tr>
                    <th colspan="5">Branches</th>
                    <th colspan="5">Customer</th>
                    <th colspan="2" class="center-align">Total Items</th>
                    <th colspan="2">Total Price</th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="!loadingOrder">
                    <td colspan="13">
                        <div class="center-align animated flash loader">
                            Loading...
                        </div>
                    </td>
                </tr>

                <tr v-else class="animated" :class="{'fadeIn':loadingOrder}" v-for="order in orders" :key="order.customer_order.uniqid">
                    <td colspan="5">{{ order.customer_order.branches }}</td>
                    <td colspan="5">{{ order.customer_order.customer }}</td>
                    <td colspan="2" class="center-align">{{ order.customer_order.qty }}</td>
                    <td colspan="2">Rp. {{ parseInt(order.customer_order.total_sales).toLocaleString('id') }}</td>
                    <td>
                        <i class="material-icons">more_vert</i>
                    </td>
                </tr>
            </tbody>
        </table>

        <FooterOrder v-if="loadingOrder" />
    </div>
</template>

<script>
import FooterOrder from './FooterOrder';

export default {
    props: {
        menu: {
            type: String,
            required: true
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
