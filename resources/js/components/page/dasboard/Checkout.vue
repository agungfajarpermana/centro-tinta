<template>
    <div>
        <div class="card">
            <div class="card-content">
                <span class="card-title activator grey-text text-darken-4">
                    #: INV-{{ order }}  
                    <span class="grey-text text-darken-4"
                        v-if="itemsCheckout.length > 0">
                            <i class="material-icons right" @click.prevent="clearItemCheckout">close</i>
                    </span>
                </span>
                <hr>
                <table class="table table-order scroll">
                    <tbody>
                        <tr v-if="itemsCheckout.length < 1">
                            <td colspan="3" class="center-align empty">
                                <span class="blue-text text-darken-3">Belum ada produk yang dipilih</span>
                            </td>
                        </tr>

                        <tr v-else class="item" v-for="(items, index) in itemsCheckout" :key="index"
                            @click.prevent="cancelItems(index, items.detail_product.uniqid)">
                            <td class="notEmpty">{{ items.detail_product.product }}</td>
                            <td class="red-text text-darken-4 left-align notEmpty" width="10%">
                                {{ items.numberOfPurchases }}
                            </td>
                            <td class="notEmpty">
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
                    <button class="btn-small waves-effect light-blue darken-1" @click="changeHide" v-else>Bayar</button>
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
        order(){
            return this.$store.getters.order
        },
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
    mounted(){
        this.$store.state.checkout.order = new Date().getTime().toString().slice(-8,10)
        this.scrollTableVertical()
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
        },

        clearItemCheckout(){
            this.$store.dispatch('clearItemCheckout')
        },

        scrollTableVertical(){
            let $table = $('table.scroll'),
                $bodyCells = $table.find('tbody tr:first').children(),
                colWidth;
        
            $(window).resize(function() {
                // Get the tbody columns width array
                colWidth = $bodyCells.map(function() {
                    return $(this).width();
                }).get();
                
                // Set the width of thead columns
                $table.find('thead tr').children().each(function(i, v) {
                    v.width(colWidth[i]);
                });    
            }).resize();
        }
    }
}
</script>

<style scoped>
.item:hover{
    cursor: pointer;
}

.table-order.scroll tbody { 
    display: block; 
}

.table-order.scroll tbody {
    height: 215px;
    overflow-y: auto;
    overflow-x: hidden;
}

.table-order .notEmpty {
    width: 80%;
}

.table-order .empty {
    width: 50%;
}

.table-order tbody::-webkit-scrollbar {
  -webkit-appearance: none;
  width: 14px;
  height: 14px;
}

.table-order tbody::-webkit-scrollbar-thumb {
  border-radius: 8px;
  border: 3px solid #fff;
  background-color: rgba(240, 9, 9, 0.3);
}
</style>
