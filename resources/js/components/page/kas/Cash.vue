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
                            <select>
                                <option value="" disabled selected>Choose your payment</option>
                                <option value="1">Tunai</option>
                                <option value="2">Bank</option>
                            </select>
                            <label>Metode Bayar</label>
                        </div>

                        <div class="col s12 m6 lg6">
                            <label class="typo__label">Nama Bank</label>
                            <multiselect v-model="valueBank" :options="bank"
                                placeholder="pilih bank"></multiselect>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 lg6">
                            <label class="typo__label">Nama Customer</label>
                            <multiselect v-model="valueCust" :options="customer"
                                placeholder="pilih customer"></multiselect>
                            <!-- <label class="typo__label form__label" v-show="isInvalid">Must have at least one value</label> -->
                        </div>

                        <div class="input-field col s12 m6 lg6">
                            <input id="bayar" type="text" class="validate">
                            <label for="bayar">Jumlah Bayar</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="textarea1" class="materialize-textarea"></textarea>
                            <label for="textarea1">Keterangan (opsional)</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn btn-flat white-text btn-small waves-effect orange">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from '../Navbar'
import Multiselect from 'vue-multiselect'

export default {
    data(){
        return {
            isInvalid: true,
            valueCust: null,
            valueBank: null,
            bank: ['BCA', 'MANDIRI', 'BNI'],
            customer: ['list', 'of', 'options']
        }
    },
    components: {
        Navbar,
        Multiselect 
    },
    mounted(){
        
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>