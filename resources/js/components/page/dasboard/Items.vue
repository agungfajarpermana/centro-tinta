<template>
    <div v-if="!show">

        <!-- component pre loading -->
        <PreLoad v-if="!loadingFirst"/>

        <!-- component text empty product -->
        <TextEmptyProduct v-if="products.length < 1 && loadingFirst"/>

        <div v-else class="col s6 l3 animated" :class="{'fadeIn':loading}" v-for="product in products" :key="product.uniqid">
            <div class="clearfix"></div>

            <div class="ph-item" v-if="!loading">
                <div class="ph-col-12">
                    <div class="ph-picture"></div>
                    <div class="ph-row">
                        <div class="ph-col-8"></div>
                        <div class="ph-col-6"></div>
                        <div class="ph-col-12 big"></div>
                    </div>
                </div>
            </div>

            <div v-else class="card medium hoverable">
                <div class="card-image waves-block">
                    <img class="activator" src="assets/toner.jpg" width="100" height="100">
                </div>
                <div class="card-content">
                    <div>
                        <p class="grey-text text-darken-4" nowrap="nowrap">{{ product.product }}</p>
                        <p><span class="blue-text ph-col-4">Rp. {{ product.detail.harga ? parseInt(product.detail.harga).toLocaleString('id') : 0 }}</span></p>
                    </div>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                    <p class="justify-align">{{ product.description }}</p>
                </div>
                <div class="card-action">
                    <a class="waves-block waves-effect btn-small amber darken-4">
                        PILIH
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PreLoad from './items/PreLoad';
import TextEmptyProduct from './items/TextEmptyProduct';

export default {
    props: {
        show: {
            type: Boolean,
            required: true
        }
    },
    components: {
        PreLoad,
        TextEmptyProduct
    },
    created(){
        this.$store.dispatch('getProducts', '/api/products')
    },
    computed: {
        loadingFirst(){
            return this.$store.getters.loadingFirst
        },
        loading(){
            return this.$store.getters.loading
        },
        products(){
            return this.$store.getters.products
        }
    }
}
</script>

<style scoped>
.ph-item{
    margin-top: 5px;
}
.medium{
    margin-left: -11px;
    height: 275px;
}
</style>
