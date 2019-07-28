<template>
    <div class="container" v-if="show">
        <div class="row animated fadeIn">
            <h5 class="center-align title">Form Penjualan</h5>
            <FormPenjualan :mode="mode"/>
        </div>

        <!-- Modal Structure -->
        <div id="modal1" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h5>Form Tambah Data Pelanggan</h5>
                
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="customer" type="text" class="validate" v-model="$v.customer.$model">
                                <label for="customer">Nama Pelanggan</label>
                                <span class="red-text helper-text" v-if="!$v.customer.required">Tidak boleh kosong!</span>
                                <span class="red-text helper-text" v-if="!$v.customer.minLength">Minimal 5 karakter!</span>
                            </div>
                            <div class="input-field col s6">
                                <input id="company" type="text" class="validate" v-model="$v.company.$model">
                                <label for="company">Nama Perushaan</label>
                                <span class="red-text helper-text" v-if="!$v.company.required">Tidak boleh kosong!</span>
                                <span class="red-text helper-text" v-if="!$v.company.minLength">Minimal 5 karakter!</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="telpon" type="text" class="validate" v-model="$v.telpon.$model">
                                <label for="telpon">Telephone</label>
                                <span class="red-text helper-text" v-if="!$v.telpon.required">{{ errTelpon }}</span>
                                <span class="red-text helper-text" v-if="!$v.telpon.minLength">Minimal 8 karakter!</span>
                                <span class="red-text helper-text" v-if="!$v.telpon.maxLength">Maksimal 12 karakter!</span>
                            </div>
                            <div class="input-field col s6">
                                <textarea id="alamat" class="materialize-textarea" v-model="$v.alamat.$model"></textarea>
                                <label for="alamat">Alamat</label>
                                <span class="red-text helper-text" v-if="!$v.alamat.required">Tidak boleh kosong!</span>
                                <span class="red-text helper-text" v-if="!$v.alamat.minLength">Minimal 5 karakter!</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="waves-effect waves-green btn" :class="{'modal-close':close}"
                    :disabled="$v.validationGroup.$invalid || disabled"
                    @click.prevent="saveDataCustomer">{{ btn }}</a>
            </div>
        </div>
    </div>
</template>

<script>
import FormPenjualan from './PaymentPenjualan';
import { required, minLength, maxLength } from 'vuelidate/lib/validators';

export default {
    props: {
        show: {
            type: Boolean,
            required: true
        }
    },
    data(){
        return {
            disabled: false,
            close: false,
            customer: null,
            company: null,
            telpon: null,
            alamat: null,
            btn: 'Simpan',
            errTelpon: 'Tidak boleh kosong!'
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
    watch: {
        telpon(valueTelpon){
            const result = this.telpon = valueTelpon.replace(/\D/g, "")
            if(result == '') this.errTelpon = 'Harus berupa angka!';
            else this.errTelpon = 'Tidak boleh kosong!';
        },
    },
    methods: {
        modeChange(modes){
            this.$store.state.checkout.mode = modes
        },

        saveDataCustomer(){
            this.disabled = true
            this.btn = 'Loading..'

            this.$store.dispatch('saveDataNewCustomer', {
                url: 'api/customer/create',
                customer: this.customer,
                company: this.company,
                telpon: this.telpon,
                alamat: this.alamat,
            }).then(res => {

                if(res.data.status == true){
                    this.$swal({
                        title: 'Success',
                        text: res.data.msg,
                        type: 'success',
                    });
                    this.disabled = false
                    this.btn = 'Simpan'
                    this.customer = this.company = this.telpon = this.alamat = null
                    this.$store.dispatch('getDataCustomer', '/api/customers')
                }else{
                    this.$swal({
                        title: 'Success',
                        text: res.data.msg,
                        type: 'error',
                    });
                    this.disabled = false
                    this.btn = 'Simpan'
                }

            }).catch(err => {

                console.log(err)

            })
        }
    },

    validations: {
        customer: { required, minLength: minLength(5) },
        company: { required, minLength: minLength(5) },
        telpon: { required, minLength: minLength(8), maxLength: maxLength(12) },
        alamat: { required, minLength: minLength(5) },
        validationGroup: ['customer','company','telpon','alamat']
    }
}
</script>

<style scoped>
.title{
    margin-bottom: 20px;
}
</style>
