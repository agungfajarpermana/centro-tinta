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
                            track-by="key"
                            :loading="loadingCust"
                            @search-change="searchCustomer"
                            placeholder="pilih customer">
                                <span slot="noResult">Oops! Nama Customer Belum Terdaftar.</span>
                            </multiselect>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s6">
                        <button type="submit" class="btn btn-flat amber darken-4 white-text">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

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

        loadingCust(){
            return this.$store.getters.loadingCust
        },

        customerName(){
            return this.$store.getters.customerName
        }
    },
    watch: {

    },
    mounted(){
        
    },
    methods: {
        searchCustomer(val){
            this.$store.state.customers.loadingCust = true
            this.$store.dispatch('getDataCustomer', '/api/customers')
        }
    }
}
</script>

<style scoped>
/* .cash{
    margin-top: 20px;
} */
</style>
