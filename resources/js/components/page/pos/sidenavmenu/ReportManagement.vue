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
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content black-text">
                        <span class="card-title">Card Title</span>
                        <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                        <a href="#">This is a link</a>
                        <a href="#">This is a link</a>
                    </div>
                </div>
            </div>

            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content black-text">
                        <span class="card-title">Card Title</span>
                        <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                        <a href="#">This is a link</a>
                        <a href="#">This is a link</a>
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
            if(this.valueDate[0]){
                window.open(`/api/piutang/${this.valueDate}/order`, '_blank');
            }else{
                console.log('empty')
            }
        }
    }
}
</script>