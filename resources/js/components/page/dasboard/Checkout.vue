<template>
    <div>
        <div class="card">
            <div class="card-content">
                <span class="card-title activator grey-text text-darken-4">ORDER #: 00000 <span class="right">NABILA</span></span>
                <hr>
                <table class="table">
                    <tbody>
                        <!-- <tr>
                            <td colspan="3" class="center-align">
                                <span class="blue-text text-darken-3">Belum ada menu yang dipilih</span>
                            </td>
                        </tr> -->

                        <tr class="item">
                            <td wrap="wrap">Test</td>
                            <td class="red-text text-darken-4 left-align" width="10%">2</td>
                            <td class="right">
                                30.000
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
                                    <!-- <number
                                        class="bold transition"
                                        ref="subtotal"
                                        :from="numberFrom.toString()"
                                        :format="theFormat"
                                        :to="subtotal.toString()"
                                        :duration="duration"
                                        easing="Power4.easeOut"
                                    /> -->
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Ppn (10%)</td>
                            <td class="right">
                                <strong>
                                    <!-- <number
                                        class="bold transition"
                                        ref="ppn"
                                        :from="numberFrom.toString()"
                                        :format="theFormat"
                                        :to="ppn.toString()"
                                        :duration="duration"
                                        easing="Power4.easeOut"
                                    /> -->
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td class="right">
                                <strong>
                                    <!-- <number
                                        class="bold transition"
                                        ref="total"
                                        :from="numberFrom.toString()"
                                        :format="theFormat"
                                        :to="total.toString()"
                                        :duration="duration"
                                        easing="Power4.easeOut"
                                    /> -->
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
            hide: false
        }
    },
    methods: {
        changeHide(){
            this.hide = !this.hide
            Bus.$emit('showItems', this.hide)
        }
    }
}
</script>