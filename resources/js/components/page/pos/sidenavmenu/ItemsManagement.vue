<template>
    <div v-if="menu == 'IM'" class="animated fadeIn">
        <div class="row">
            <div class="col s8 m8 l8">
                <span class="card-title">Items Management</span>
            </div>

            <div class="input-field col s4 m4 l4" style="margin-top:-15px;">
                <input type="text" v-model="searchItems" placeholder="Search by product">
            </div>
        </div>
        <table class="striped responsive-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Sales</th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="loadingManage && manageItems.length < 1">
                    <td colspan="13">
                        <div class="center-align animated flash loader">
                            Product yang dicari tidak ditemukan!
                        </div>
                    </td>
                </tr>

                <tr v-if="!loadingManage">
                    <td colspan="13">
                        <div class="center-align animated flash loader">
                            Loading...
                        </div>
                    </td>
                </tr>

                <tr v-else v-for="item in manageItems" :key="item.uniqid">
                    <td>{{ item.product }}</td>
                    <td>{{ item.type }}</td>
                    <td>{{ item.category }}</td>
                    <td>Rp. {{ parseInt(item.price).toLocaleString('id') }}</td>
                    <td>{{ item.sales }} Item</td>
                    <td>
                        <i class="tiny material-icons blue-text">edit</i> &nbsp;
                        <i class="tiny material-icons red-text">delete</i>
                    </td>
                </tr>
            </tbody>
        </table>

        <FooterItem v-if="loadingManage && manageItems.length > 0" />
    </div>
</template>

<script>
import FooterItem from './FooterItem';
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
            searchItems: ''
        }
    },
    components: {
        FooterItem
    },
    mounted(){
        this.$store.dispatch('getItemManagement', 'api/products')
    },
    computed: {
        loadingManage(){
            return this.$store.getters.loadingManage
        },
        manageItems(){
            return this.$store.getters.manageItems
        }
    },
    watch:{
        searchItems: _.debounce((event) => {
            Bus.$emit('searchItemManagement', event.trim())
        }, 800)
    }
}
</script>

<style scoped>
i:hover{
    cursor: pointer;
}
</style>
