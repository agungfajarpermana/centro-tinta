<template>
    <div>
        <div class="col s12 cash animated fadeInLeft" v-if="mode == 'cash'">
            <form action="#" class="col s12">
                <div class="row">
                    <div class="input-field col s6">
                        <input id="total" type="text" class="validate">
                        <label for="total">Total Bayar (Rp)</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="customer" type="text" class="validate">
                        <label for="customer">Nama Pelanggan</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="bayar" type="text" class="validate">
                        <label for="bayar">Jumlah Bayar (Rp)</label>
                    </div>
                    <!-- <div class="input-field col s6">
                        <input id="kembali" type="text" class="validate">
                        <label for="kembali">Kembali</label>
                    </div> -->
                </div>
                
                <div class="row">
                    <div class="input-field col s6">
                        <button type="submit" class="btn btn-flat amber darken-4 white-text">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        mode: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>
.cash{
    margin-top: 40px;
}
</style>
