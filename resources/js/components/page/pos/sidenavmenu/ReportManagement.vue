<template>
    <div v-if="menu == 'RM'">
        <div class="row">
            <div class="col s12 m12 l7" style="margin-bottom:20px;">
                <span class="card-title">Report Management</span>
            </div>

            <div class="input-field col s12 m12 l5" style="margin-top:-14px;">
                <date-picker v-model="valueDate" valueType="format" range confirm :lang="lang" @change="eventDate"></date-picker>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <p class="center-align">Laporan penjualan tidak ditemukan!</p>
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
            valueDate: [],
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
    methods: {
        eventDate(){
            console.log(this.valueDate)
        }
    }
}
</script>