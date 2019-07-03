<template>
    <div class="col s6 l3 animated fadeIn" v-if="!show">
        <div class="card medium hoverable">
            <div class="card-image waves-block">
                <img class="activator" src="assets/toner.jpg" width="100" height="100">
            </div>
            <div class="card-content">
                <div>
                    <p class="grey-text text-darken-4" nowrap="nowrap">Tinta Catrige Toner Refill</p>
                    <p><span class="blue-text">Rp. 100.000</span></p>
                </div>
            </div>
            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                <p class="justify-align">Here is some more information about this product that is only revealed once clicked on.</p>
            </div>
            <div class="card-action">
                <a class="waves-block btn-small red red-darken-4">
                    PILIH
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            required: true
        }
    }
}
</script>

<style scoped>
.medium{
    margin-left: -11px;
    height: 260px;
}
</style>
