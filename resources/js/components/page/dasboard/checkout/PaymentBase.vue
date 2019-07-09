<template>
    <div class="container" v-if="show">
        <h6 class="center-align title">Metode Pembayaran</h6>

        <div class="row animated fadeIn">
            <div class="col s10 offset-s2">
                <div class="col s5">
                    <label>
                        <input class="with-gap" name="group3" type="radio" 
                            checked
                            @change="modeChange('cash')"
                            value="cash" />
                        <span>Piutang</span>
                    </label>
                </div>
                <div class="col s5">
                    <label>
                        <input class="with-gap" name="group3" type="radio"
                            @change="modeChange('card')" 
                            value="credit" 
                        />
                        <span>Bayar Cash</span>
                    </label>
                </div>
            </div>

            <PaymentCash :mode="mode"/>
            <paymentCard :mode="mode"/>
        </div>
    </div>
</template>

<script>
import PaymentCash from './PaymentCash';
import PaymentCard from './PaymentCard';

export default {
    props: {
        show: {
            type: Boolean,
            required: true
        }
    },
    components: {
        PaymentCash,
        PaymentCard
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
