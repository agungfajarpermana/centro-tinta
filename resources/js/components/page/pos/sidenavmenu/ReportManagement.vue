<template>
    <div v-if="menu == 'RM'">
        <div class="row">
            <div class="col s12 m12 l7" style="margin-bottom:20px;">
                <span class="card-title">Report Management</span>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content black-text">
                        <span class="card-title">Laporan penjualan</span>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="last_name" type="text" class="validate" placeholder="Cari berdasarkan nama product">
                            </div>
                            
                            <div class="input-field col s12">
                                <date-picker v-model="penjualan" valueType="format" range confirm :lang="lang" @change="printPenjualan"></date-picker>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content black-text">
                        <span class="card-title">Laporan piutang</span>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="last_name" type="text" class="validate" placeholder="Cari berdasarkan nama product">
                            </div>
                            
                            <div class="input-field col s12">
                                <date-picker v-model="piutang" valueType="format" range confirm :lang="lang" @change="printPiutang"></date-picker>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content black-text">
                        <span class="card-title">Laporan Cash</span>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="last_name" type="text" class="validate" placeholder="Cari berdasarkan nama product">
                            </div>
                            
                            <div class="input-field col s12">
                                <date-picker v-model="cash" valueType="format" range confirm :lang="lang" @change="printCash"></date-picker>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker'

export default {
    props: {
        menu:{
            type: String,
            required: true
        }
    },
    data(){
        return {
            lang: {
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                placeholder: {
                    dateRange: 'Pilih tanggal cetak laporan penjualan'
                }
            }
        }
    },
    components: {
        DatePicker
    },
    computed: {
        penjualan: {
            get(){
                return this.$store.getters.penjualan
            },

            set(value){
                this.$store.state.laporan.penjualan = value
            }
        },

        piutang: {
            get(){
                return this.$store.getters.piutang
            },

            set(value){
                this.$store.state.laporan.piutang = value
            }
        },

        cash: {
            get(){
                return this.$store.getters.cash
            },

            set(value){
                this.$store.state.laporan.cash = value
            }
        }
    },
    methods: {
        printPiutang(){
            if(this.piutang[0]){
                window.open(`/api/piutang/${this.piutang}/order`, '_blank');
            }else{
                console.log('empty')
            }
        },

        printPenjualan(){

        },

        printCash(){

        }
    }
}
</script>