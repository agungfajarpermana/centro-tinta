<template>
    <div>
        <div class="col s12 cards" v-if="mode == 'card'">
            <form action="#" class="col s12">
                <div class="row">
                    <div class="input-field col s6">
                        <input id="bank" type="text" class="validate">
                        <label for="bank">Nama Bank</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="nokartu" type="text" class="validate">
                        <label for="nokartu">No. Kartu</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="bayar" type="text" class="validate">
                        <label for="bayar">Jumlah Bayar (Rp)</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s6">
                        <button type="submit" class="btn btn-flat cyan darken-2 white-text">Simpan</button>
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
.cards{
    margin-top: 40px;
}
</style>
