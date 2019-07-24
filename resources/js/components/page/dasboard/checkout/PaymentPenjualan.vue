<template>
    <div>
        <div class="col s12 cash animated fadeInLeft" v-if="mode == 'cash'">
            <form action="#" class="col s12">
                <div class="row">
                    <div class="col s12">
                        <label class="typo__label">Nama Customer</label>
                        <multiselect v-model="valueCust" :options="customerName"
                            :options-limit="30" :limit="3"
                            :max-height="150"
                            :disabled="disabled"
                            :custom-label="nameWithLang"
                            track-by="customer"
                            placeholder="pilih customer">
                                <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.customer }}</strong></template>
                                <span slot="noResult">Oops! Nama Customer Belum Terdaftar.</span>
                            </multiselect>
                    </div>
                </div>
                
                <div v-if="!loadingDisplay" class="row" style="margin-top: 80px;">
                    <preLoad/>
                </div>

                <div v-if="customerDetail.length != 0 && loadingDisplay" class="row">
                    <div class="col s12">
                        <div class="card">
                            <div class="card-title">
                                <span style="padding:5px;">PT. {{ customerDetail.company }}</span>
                            </div>
                            
                            <div class="card-content">
                                <p>
                                    Telphone :
                                </p>
                                <p>
                                    {{ customerDetail.telephone }}
                                </p>

                                <br>

                                <p>
                                    Alamat :
                                </p>
                                <p>
                                    {{ customerDetail.address }}
                                </p>
                            </div>

                            <div class="card-action">
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="customerDetail.length != 0 && loadingDisplay">
                    <div class="input-field col s6">
                        <button type="submit" class="btn amber darken-4 white-text"
                        :class="{'disabled':itemsCheckout.length == 0 || btnDisabled}" 
                        @click.prevent="saveDataCustomerSales">{{ btnSales }}</button>
                        <!-- <button type="submit" class="btn amber darken-4 white-text">Batalkan</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import PreLoad from '../items/PreLoad';
import { Bus } from '../../../../app';
import _ from 'lodash'

export default {
    props: {
        mode: {
            type: String,
            required: true
        }
    },
    data(){
        return {
            btnSales: 'Simpan',
            btnDisabled: false
        }
    },
    components: {
        Multiselect,
        PreLoad
    },
    computed: {
        valueCust: {
            get(){
                return this.$store.getters.valueCust
            },

            set(value){
                this.$store.state.customers.valueCust = value
            }
        },

        disabled(){
            return this.$store.getters.disabled
        },

        customerName(){
            return this.$store.getters.customerName
        },

        customerDetail(){
            return this.$store.getters.customerDetail
        },

        loadingDisplay(){
            return this.$store.getters.loadingDisplay
        },

        itemsCheckout(){
            return this.$store.getters.itemsCheckout
        }
    },
    created(){
        Bus.$on('searchCustomer', (data) => {
            if(data){
                this.$store.dispatch('detailDataCustomer', `/api/customers/${data.uniqid}`)
            }else{
                this.$store.state.customers.customerDetail = []
            }
        })

        this.$store.dispatch('getDataCustomer', '/api/customers')
    },
    watch: {
        valueCust: _.debounce((event) => {
            Bus.$emit('searchCustomer', event)
        }, 800)
    },
    methods: {
        nameWithLang ({ customer }) {
            return `${customer}`
        },

        saveDataCustomerSales(){
            this.btnDisabled = true
            this.btnSales = 'Loading'

            this.$store.dispatch('saveDataCustomerSales', 'api/customer')
                .then(res => {
                    this.btnDisabled = false
                    this.btnSales = 'Simpan'
                    this.$store.state.customers.valueCust = ''
                    this.$store.state.customers.customerDetail = []

                    alert(res.data.msg)
                }).catch(err => {
                    this.btnDisabled = false
                    console.log(err.response.data.msg)
                })
        }
    }
}
</script>

<style scoped>
/* .cash{
    margin-top: 20px;
} */
</style>
