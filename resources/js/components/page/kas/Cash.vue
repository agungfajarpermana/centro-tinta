<template>
    <div>
        <Navbar/>

        <div class="container">
            <h5 class="center-align">Form Penerimaan Cash</h5>
            <hr>
            <div class="row" style="margin-top: 30px;">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12 m6 lg6">
                            <input id="order" type="text" class="validate" v-model="$v.order.$model">
                            <label for="order" class="active">No. order (invoice)</label>
                            <span class="red-text helper-text" v-if="!$v.order.required">{{ errOrder }}</span>
                            <span class="red-text helper-text" v-if="!$v.order.minLength">Minimal 4 karakter!</span>
                        </div>

                        <div class="input-field col s12 m6 lg6">
                            <select v-model="$v.metode.$model">
                                <option value="" disabled :selected="selected">Choose your payment</option>
                                <option value="tunai">Tunai</option>
                                <option value="bank">Bank</option>
                            </select>
                            <label>Metode Bayar</label>
                            <span class="red-text helper-text" v-if="!$v.metode.required">Tidak boleh kosong!</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m12 lg12">
                            <label class="typo__label">Nama Bank</label>
                            <multiselect v-model="$v.valueBank.$model" :options="bank"
                                placeholder="pilih bank"></multiselect>
                            <span class="red-text helper-text" v-if="!$v.valueBank.isRequired">Tidak boleh kosong!</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 m6 lg6">
                            <input id="bayar" type="text" class="validate" v-model="$v.bayar.$model">
                            <label for="bayar" class="active">Jumlah Bayar</label>
                            <span class="red-text helper-text" v-if="!$v.bayar.required">{{ errBayar }}</span>
                            <span class="red-text helper-text" v-if="!$v.bayar.minLength">Minimal 5 karakter!</span>
                        </div>

                        <div class="input-field col s6 m6 lg6">
                            <textarea id="textarea1" class="materialize-textarea" v-model="$v.keterangan.$model"></textarea>
                            <label for="textarea1" class="active">Keterangan (opsional)</label>
                            <span class="red-text helper-text" v-if="!$v.keterangan.minLength">Minimal 5 karakter!</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn-small white-text btn-small waves-effect orange"
                                :disabled="$v.validationGroup.$invalid || disabled"
                                @click.prevent="saveDataCash"
                            >
                                {{ btn }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
import Navbar from '../Navbar'
import Multiselect from 'vue-multiselect'
import { required, minLength } from 'vuelidate/lib/validators';

export default {
    data(){
        return {
            disabled: false,
            selected: true,
            isInvalid: true,
            valueBank: null,
            metode: null,
            bayar: null,
            errBayar: 'Tidak boleh kosong!',
            order: null,
            errOrder: 'Tidak boleh kosong!',
            keterangan: null,
            btn: 'Simpan',
            bank: ['BCA', 'MANDIRI', 'BNI', 'BII'],
        }
    },
    components: {
        Navbar,
        Multiselect 
    },
    watch: {
        order(valueOrder){
            const result = this.order = valueOrder.replace(/\D/g, "")
            if(result == '') this.errOrder = 'Harus berupa angka!';
            else console.log(valueOrder);
        },

        bayar(valueBayar){
            const result = this.bayar = valueBayar.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            if(result == '') this.errBayar = 'Harus berupa angka!';
            else this.errBayar = 'Tidak boleh kosong!';
        },
    },
    methods: {
        saveDataCash(){
            this.disabled = true
            this.btn = 'Loading..'

            this.$store.dispatch('saveDataPenerimaanCash', {
                url: 'api/piutang',
                order: this.order,
                metode: this.metode,
                bank: this.valueBank,
                bayar: this.bayar,
                ket: this.keterangan
            }).then(res => {

                if(res.status == true){
                    this.$swal({
                        title: 'Success',
                        text: res.msg,
                        type: 'success',
                    });

                    this.disabled = false
                    this.btn = 'Simpan'
                    this.order = this.valueBank = this.keterangan = this.metode = this.bayar = null
                }else{
                    this.$swal({
                        title: 'Oops!',
                        text: res.msg,
                        type: 'error',
                    });
                    this.disabled = false
                    this.btn = 'Simpan'
                }

            }).catch(err => {
                console.log(err.status)
            })
        }
    },

    validations: {
        metode: { required },
        valueBank: { 
            async isRequired(value){
                // console.log(this.metode)
                if(this.metode === 'bank' || this.metode === null) {
                    // console.log(value)
                    if(value === null) return await false;
                    else return await true;
                }else{
                    return await true;
                }
            }
         },
        order: { required, minLength: minLength(4) },
        bayar: { required, minLength: minLength(3) },
        keterangan: { minLength: minLength(5) },
        validationGroup: ['metode','valueBank','order','bayar','keterangan']
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>