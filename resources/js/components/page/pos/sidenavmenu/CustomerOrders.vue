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
                    <th>Date</th>
                    <th>No.Order</th>
                    <th colspan="5">Branches</th>
                    <th colspan="5">Customer</th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="loadingOrder && orders.length < 1">
                    <td colspan="14">
                        <div class="center-align animated flash loader">
                            Data Belum Tersedia!
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
                    <td>{{ order.customer_order.date | dateformat }}</td>
                    <td>INV-{{ order.customer_order.order }}</td>
                    <td colspan="5">{{ order.customer_order.branches }}</td>
                    <td colspan="5">{{ order.customer_order.customer }}</td>
                    <td>
                        <a href="#modal1" class="modal-trigger"
                            @click.prevent="customerOrderModal(index, order.customer_order.uniqid)"   
                        >
                            <i class="tiny material-icons teal-text">remove_red_eye</i>
                        </a> &nbsp;
                        <a href="#" @click.prevent="deleteOrder(order.customer_order.uniqid, index)">
                            <i class="tiny material-icons red-text">delete</i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <FooterOrder v-if="loadingOrder && orders.length > 0" />

        <!-- Modal Structure -->
        <div id="modal1" class="modal modal-fixed-footer" v-if="true">
            <div class="modal-content">
                <h5>{{ customerModal.customer }}</h5>
                <br>
                <div class="row">
                    <div class="container-fluid">
                        <div class="col s2 m2 l2">
                            <p>No. Order</p>
                            <p>INV-{{ customerModal.order }}</p>
                        </div>

                        <div class="col s10 m10 l10">
                            <p>Cabang</p>
                            <p>{{ customerModal.branches }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="container-fluid">
                        <div class="col s12 m12 l12">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th class="left-align">Product <span v-if="!customerModal.confirm && !loadingModal"><i class="tiny material-icons red-text">edit</i></span></th>
                                        <th class="center-align">Qty <span v-if="!customerModal.confirm && !loadingModal"><i class="tiny material-icons red-text">edit</i></span></th>
                                        <th class="right-align">Price</th>
                                        <th class="right-align"></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr v-if="!loadingModal && ordersModal.length < 1">
                                        <td colspan="4" class="center-align">
                                            Data belum tersedia
                                        </td>
                                    </tr>

                                    <tr v-if="loadingModal">
                                        <td colspan="4" class="center-align">
                                            Loading..
                                        </td>
                                    </tr>

                                    <tr v-else v-for="(order, index) in ordersModal" :key="index">
                                        <td class="left-align">
                                            <span v-if="!order.editProduct" @dblclick="(!customerModal.confirm ? changeEdit(order.uniqid, 'product') : '')">{{ order.product }}</span>
                                            <div v-else @dblclick="(!customerModal.confirm ? cancelEdit(order.uniqid, 'product') : '')" class="col s12 m8 lg8" style="margin-left:-15px;">
                                                <multiselect v-model="valueProduct" :options="productEdit"
                                                    :loading="productEdit.length < 1 || isLoading"
                                                    :max-height="150"
                                                    :custom-label="nameWithLang"
                                                    track-by="product"
                                                    @select="editDataProduct"
                                                    placeholder="pilih product"></multiselect>
                                            </div>
                                        </td>
                                        <td class="center-align">
                                            <span v-if="!order.editQty" @dblclick="(!customerModal.confirm ? changeEdit(order.uniqid, 'qty') : '')">{{ order.qty }}</span>
                                            <div v-else @dblclick="!customerModal.confirm ? cancelEdit(order.uniqid, 'qty') : ''" class="col s2 offset-s5">
                                                <input type="text" v-model="productQty" @keyup.enter="editDataQty(order.uniqid)">
                                            </div>
                                        </td>
                                        <td class="right-align">
                                            Rp. {{ parseInt(order.total).toLocaleString('id') }}
                                        </td>
                                        <td class="right-align">
                                            <span><i class="tiny material-icons red-text" 
                                                v-if="!customerModal.confirm"
                                                @click.prevent="deleteOrderModal(order.uniqid, index)"
                                            >delete</i>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" v-if="customerModal.confirm" 
                    :disabled="loadingModal || ordersModal.length < 1 || isLoading"
                    class="waves-effect waves-red red btn"
                    @click.prevent="batalConfirm(customerModal.uniqid)">{{ btnCancel }}</a>

                <a href="#!" v-else :disabled="loadingModal || ordersModal.length < 1 || isLoading || customerModal.confirm" 
                    class="waves-effect waves-orange orange btn"
                    @click.prevent="confirmProduct(customerModal.uniqid)">{{ btn }}</a>

                <a href="#!" :disabled="loadingModal || ordersModal.length < 1" class="waves-effect waves-green btn"
                    @click="printSuratJalan(customerModal.order)">Surat Jalan</a>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
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
            searchOrder: '',
            valueProduct: null,
            productQty: 0,
            qty: null,
            id: 0,
            isLoading: false,
            btn: 'Konfirmasi barang diterima',
            btnCancel: 'batal konfirmasi barang diterima'
        }
    },
    components: {
        FooterOrder,
        Multiselect 
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
        },

        productEdit(){
            return this.$store.getters.productEdit
        },

        confirm(){
            return this.$store.getters.confirm
        }
    },
    mounted(){
        this.$store.dispatch('getOrder', 'api/order')
        this.$store.dispatch('productEdit', `api/orders`)
    },
    watch: {
        searchOrder: _.debounce((event) => {
            Bus.$emit('searchCustomerOrder', event.trim())
        }, 800),

        productQty(value){
            if(value >= (this.qty + 1)){
                this.productQty = 0
            }else if(isNaN(this.productQty)){
                this.productQty = 0
            }else{
                this.productQty = parseInt(value).toString()
            }
        }
    },
    methods: {
        nameWithLang ({ product }) {
            return `${product}`
        },
        
        customerOrderModal(index, id){
            M.AutoInit()
            this.productQty = 0;
            this.$store.state.modal.loadingModal = true
            this.$store.dispatch('getDataKonfirmasiSales')
            this.$store.dispatch('customerOrderModal', id)
        },

        printSuratJalan(order){
            window.open(`api/laporan/${order}/customer`, '_blank')
        },

        changeEdit(id, mode){
            const btnProduct = this.ordersModal.find(btn => btn.editProduct);
            const btnQty = this.ordersModal.find(btn => btn.editQty);
            const dataEdit = this.ordersModal.find(edit => edit.uniqid == id)
            const dataQty = this.productEdit.find(data => data.uniqid == dataEdit.prod_id)
            
            if(mode == 'product'){

                dataEdit.editProduct = true

            }else if(mode == 'qty'){

                dataEdit.editQty = true

            }

            if(btnProduct) btnProduct.editProduct = false; this.valueProduct = null;
            btnQty ? btnQty.editQty = false : ''
            this.qty = dataQty.qty
            this.id = id
        },

        cancelEdit(id, mode){
            const cancel = this.ordersModal.find(edit => edit.uniqid == id)
            
            if(mode == 'product'){
                cancel.editProduct = false
                this.id = 0
            }else{
                cancel.editQty = false
                this.productQty = this.id = 0
            }
        },

        editDataProduct(value){
            const btnProduct = this.ordersModal.find(btn => btn.editProduct);
            const btnQty = this.ordersModal.find(btn => btn.editQty);
            this.isLoading = !this.isLoading

            this.$store.dispatch('editOrderCustomer', {
                url: `api/order/${this.id}`,
                product: value.uniqid,
                price: value.price,
                branch: value.branch,
                qty: null
            }).then(res => {

                if(btnProduct) btnProduct.editProduct = false; this.valueProduct = null; btnProduct.product = value.product; btnProduct.total = value.price;
                btnQty ? btnQty.editQty = false : ''
                this.isLoading = !this.isLoading

            }).catch(err => {
                console.log(err)
            })
        },

        editDataQty(id){
            const btnQty = this.ordersModal.find(btn => btn.editQty);
            const dataEdit = this.ordersModal.find(edit => edit.uniqid == id)
            const data = this.productEdit.find(edit => edit.uniqid == dataEdit.prod_id)
            // console.log(data);
            if(this.productQty == 0){
                alert('Tidak boleh kosong')
            }else{
                this.$store.dispatch('editOrderCustomer', {
                    url: `api/order/${this.id}`,
                    product: data.uniqid,
                    price: data.price,
                    branch: data.branch,
                    qty: this.productQty
                }).then(res => {
                    if(btnQty) btnQty.editQty = false; btnQty.qty = this.productQty; btnQty.total = (this.productQty * data.price); this.productQty = 0; 
                }).catch(err => {
                    console.log(err)
                })
            }
        },

        deleteOrder(id, key){
            this.$swal({
                title: 'Anda Yakin?',
                text: 'Ingin menghapus data ini!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Jangan, nanti saja!',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if(result.value) {
                    M.toast({html: 'Loading..', displayLength: 800})

                    this.$store.dispatch('deleteOrder', `api/order/${id}`)
                    .then(res => {

                        if(res.status == true){
                            this.orders.splice(key, 1)
                            this.$swal('Deleted', res.msg, 'success')
                        }else{
                            this.$swal({
                                title: 'Oops!',
                                text: res.msg,
                                type: 'error',
                            });
                        }

                    }).catch(err => {
                        console.log(err)
                    })

                } else {
                    this.$swal('Cancelled', 'Your file is still intact', 'info')
                }
            })
        },

        deleteOrderModal(id, key){
            this.$swal({
                title: 'Anda Yakin?',
                text: 'Ingin menghapus data ini!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Jangan, nanti saja!',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if(result.value) {

                    this.$store.dispatch('deleteOrderModal', {
                        id: id,
                        url: 'api/orders'
                    }).then(res => {

                        if(res.status == true){
                            this.ordersModal.splice(key, 1)
                            this.$swal('Deleted', res.msg, 'success')
                        }

                    }).catch(err => {
                        console.log(err)
                    })

                } else {
                    this.$swal('Cancelled', 'Your file is still intact', 'info')
                }
            })
        },

        confirmProduct(id){
            this.isLoading = true
            this.btn = 'Loading...'

            this.$swal({
                title: 'Anda Yakin?',
                text: 'Ingin mengkofirmasi No. order ini!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, konfirmasi!',
                cancelButtonText: 'Jangan, nanti saja!',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if(result.value) {

                    this.$store.dispatch('confirmProductSales', {
                        url: `api/piutang/${id}`
                    }).then(res => {
                
                        if(res.data.status == true){

                            this.$swal({
                                title: 'Success',
                                text: res.data.msg,
                                type: 'success',
                            });
                            this.isLoading = false

                        }else{

                            this.$swal({
                                title: 'Opps!',
                                text: res.data.msg,
                                type: 'error',
                            });
                            this.isLoading = false

                        }
                    }).catch(err => {
                        console.log(err.response)
                        this.isLoading = false
                    })

                } else {
                    this.$swal('Cancelled', 'Your file is still intact', 'info')
                    this.isLoading = false
                    this.btn = 'Konfirmasi barang diterima'
                }
            })
        },

        batalConfirm(id){
            this.isLoading = true
            this.btnCancel = 'Loading..'

            this.$store.dispatch('cancelConfirmProductSales', {
                url: `api/piutang/${id}`
            }).then(res => {

                if(res.status == true){
                    this.$swal({
                        title: 'Success',
                        text: res.msg,
                        type: 'success',
                    });
                    this.isLoading = false
                    this.btn = 'Konfirmasi barang diterima'
                    this.btnCancel = 'batal konfirmasi barang diterima' 
                }else{
                    this.$swal({
                        title: 'Opps!',
                        text: res.msg,
                        type: 'error',
                    });
                    this.isLoading = false
                    this.btnCancel = 'batal konfirmasi barang diterima'
                }
            })
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
