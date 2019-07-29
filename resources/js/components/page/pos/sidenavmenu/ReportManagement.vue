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
                        <span class="card-title">Laporan Pembayaran Customer</span>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="last_name" v-model="cashSearch" type="text" class="validate" placeholder="Cari berdasarkan nama customer">
                            </div>
                            
                            <div class="input-field col s12">
                                <date-picker v-model="cashDate" valueType="format" range confirm :lang="lang" @change="printCash"></date-picker>
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
                                <input id="last_name" v-model="piutangSearch" type="text" class="validate" placeholder="Cari berdasarkan nama customer">
                            </div>
                            
                            <div class="input-field col s12">
                                <date-picker v-model="piutangDate" valueType="format" range confirm :lang="lang" @change="printPiutang"></date-picker>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content black-text">
                        <span class="card-title">Laporan penjualan</span>

                        <div class="row">
                            <!-- <div class="input-field col s12">
                                <input id="last_name" v-model="penjualanSearch" type="text" class="validate" placeholder="Cari berdasarkan nama product">
                            </div> -->
                            
                            <div class="input-field col s12">
                                <date-picker v-model="penjualanDate" valueType="format" range confirm :lang="lang" @change="printPenjualan"></date-picker>
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
            },
            options: [
                'foo',
                'bar'
            ]
        }
    },
    components: {
        DatePicker,
    },
    computed: {
        penjualanDate: {
            get(){
                return this.$store.getters.penjualanDate
            },

            set(value){
                this.$store.state.laporan.penjualan.date = value
            }
        },

        penjualanSearch: {
            get(){
                return this.$store.getters.penjualanSearch
            },

            set(value){
                this.$store.state.laporan.penjualan.search = value
            }
        },

        piutangDate: {
            get(){
                return this.$store.getters.piutangDate
            },

            set(value){
                this.$store.state.laporan.piutang.date = value
            }
        },

        piutangSearch: {
            get(){
                return this.$store.getters.piutangSearch
            },

            set(value){
                this.$store.state.laporan.piutang.search = value
            }
        },

        cashDate: {
            get(){
                return this.$store.getters.cashDate
            },

            set(value){
                this.$store.state.laporan.cash.date = value
            }
        },

        cashSearch:{
            get(){
                return this.$store.getters.cashSearch
            },

            set(value){
                this.$store.state.laporan.cash.search = value
            }
        }
    },
    methods: {
        printPiutang(){
            if(this.piutangDate[0]){
                window.open(`/api/laporan/${this.piutangDate}/${this.piutangSearch || null}/piutang`, '_blank');
            }else{
                console.log('empty')
            }
        },

        printPenjualan(){
            if(this.penjualanDate[0]){
                window.open(`/api/laporan/${this.penjualanDate}/${this.penjualanSearch || null}/penjualan`, '_blank');
            }else{
                console.log('empty')
            }
        },

        printCash(){
            if(this.cashDate[0]){
                window.open(`/api/laporan/${this.cashDate}/${this.cashSearch || null}/cash`, '_blank');
            }else{
                console.log('empty')
            }
        }
    }
}
</script>