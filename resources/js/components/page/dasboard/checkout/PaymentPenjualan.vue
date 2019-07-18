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
                
                <div class="row">
                    <div class="col s12 m6">
                        <h6>{{ customerDetail.nama_customer }}</h6>
                    </div>

                    <div class="col s12 m6">
                        <h6>{{ customerDetail.perusahaan }}</h6>
                    </div>
                </div>

                <div class="row" v-if="customerDetail.length != 0">
                    <div class="input-field col s6">
                        <button type="submit" class="btn btn-flat amber darken-4 white-text">Simpan</button>
                        <button type="submit" class="btn btn-flat amber darken-4 white-text">Batalkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import { Bus } from '../../../../app';
import _ from 'lodash'

export default {
    props: {
        mode: {
            type: String,
            required: true
        }
    },
    components: {
        Multiselect
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
        }
    }
}
</script>

<style scoped>
/* .cash{
    margin-top: 20px;
} */
</style>
