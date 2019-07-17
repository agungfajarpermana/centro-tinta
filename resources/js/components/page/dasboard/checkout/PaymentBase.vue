<template>
    <div class="container" v-if="show">
        <div class="row animated fadeIn">
            <h5 class="center-align title">Form Penjualan</h5>
            <FormPenjualan :mode="mode"/>
        </div>
    </div>
</template>

<script>
import FormPenjualan from './PaymentPenjualan';

export default {
    props: {
        show: {
            type: Boolean,
            required: true
        }
    },
    components: {
        FormPenjualan,
    },
    computed: {
        mode(){
            return this.$store.getters.mode
        }
    },
    methods: {
        modeChange(modes){
            this.$store.state.checkout.mode = modes
        }
    }
}
</script>

<style scoped>
.title{
    margin-bottom: 20px;
}
</style>
