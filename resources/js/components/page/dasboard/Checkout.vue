<template>
    <div>
        <div class="card">
            <div class="card-content">
                <span class="card-title activator grey-text text-darken-4">ORDER #: 00000 <span class="right">NABILA</span></span>
                <hr>
                <table class="table">
                    <tbody>
                        <tr v-if="itemsCheckout.length < 1">
                            <td colspan="3" class="center-align">
                                <span class="blue-text text-darken-3">Belum ada produk yang dipilih</span>
                            </td>
                        </tr>

                        <tr v-else class="item" v-for="(items, index) in itemsCheckout" :key="index"
                            @click.prevent="cancelItems(index, items.detail_product.uniqid)">
                            <td wrap="wrap">{{ items.detail_product.product }}</td>
                            <td class="red-text text-darken-4 left-align" width="10%">
                                {{ items.numberOfPurchases }}
                            </td>
                            <td class="right">
                                <number
                                    class="bold transition"
                                    ref="price"
                                    :from="numberFrom"
                                    :format="theFormat"
                                    :to="items.detail_product.price * items.numberOfPurchases"
                                    :duration="duration"
                                    easing="Power4.easeOut"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Subtotal</td>
                            <td class="right">
                                <strong>
                                    <number
                                        class="bold transition"
                                        ref="subtotal"
                                        :from="numberFrom"
                                        :format="theFormat"
                                        :to="subtotal"
                                        :duration="duration"
                                        easing="Power4.easeOut"
                                    />
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Ppn (10%)</td>
                            <td class="right">
                                <strong>
                                    <number
                                        class="bold transition"
                                        ref="ppn"
                                        :from="numberFrom"
                                        :format="theFormat"
                                        :to="ppn"
                                        :duration="duration"
                                        easing="Power4.easeOut"
                                    />
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td class="right">
                                <strong>
                                    <number
                                        class="bold transition"
                                        ref="total"
                                        :from="numberFrom"
                                        :format="theFormat"
                                        :to="total"
                                        :duration="duration"
                                        easing="Power4.easeOut"
                                    />
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-action">
                <div class="col s6 m6 l6">
                    <button class="btn-small waves-effect red darken-4" @click="changeHide" v-if="hide">Batalkan</button>
                    <button class="btn-small waves-effect light-blue darken-1" @click="changeHide" v-else>Lanjut Bayar</button>
                </div>
                
                <div class="col s6 m6 l6">
                    <button class="btn-small waves-effect amber darken-4 right">Skip Bayar</button>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</template>

<script>
import {Bus} from '../../../app';

export default {
    data(){
        return {
            hide: false,
        }
    },
    computed: {
        numberFrom(){
            return this.$store.getters.numberFrom
        },
        duration(){
            return this.$store.getters.duration
        },
        itemsCheckout(){
            return this.$store.getters.itemsCheckout
        },
        subtotal(){
            return this.$store.getters.subtotal
        },
        ppn(){
            return this.$store.getters.ppn
        },
        total(){
            return this.$store.getters.total
        },
    },
    methods: {
        theFormat(number){
            return parseInt(number).toLocaleString('id')
        },

        changeHide(){
            this.hide = !this.hide
            Bus.$emit('showItems', this.hide)
        },

        cancelItems(key,id){
            let itemsCheckout = this.itemsCheckout[key]
            this.$store.dispatch('cancelItems', {
                itemsCheckout:itemsCheckout,
                key:key,
                id:id
            })
        }
    }
}
</script>

<style scoped>
.item:hover{
    cursor: pointer;
}
</style>
