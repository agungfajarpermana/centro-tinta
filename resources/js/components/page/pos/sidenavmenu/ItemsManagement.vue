<template>
    <div v-if="menu == 'IM'" class="animated fadeIn">
        <div class="row">
            <div class="col s8 m8 l8">
                <span class="card-title">Items Management</span>
                <a href="#modal1" class="waves-effect waves-light btn-small modal-trigger"
                    @click.prevent="$router.push({name: 'ADD'})">Add Items</a>
            </div>

            <div class="input-field col s4 m4 l4" style="margin-top:-15px;">
                <input type="text" v-model="searchItems" placeholder="Search by product">
            </div>
        </div>
        <table class="striped responsive-table">
            <thead>
                <tr>
                    <th>Branches</th>
                    <th>Product <span><i class="tiny material-icons red-text">edit</i></span></th>
                    <th>Type <span><i class="tiny material-icons red-text">edit</i></span></th>
                    <th>Category <span><i class="tiny material-icons red-text">edit</i></span></th>
                    <th>Price <span><i class="tiny material-icons red-text">edit</i></span></th>
                    <th>Stock <span><i class="tiny material-icons red-text">edit</i></span></th>
                    <th>Sales</th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="loadingManage && manageItems.length < 1">
                    <td colspan="13">
                        <div class="center-align animated flash loader">
                            Product yang dicari tidak ditemukan!
                        </div>
                    </td>
                </tr>

                <tr v-if="!loadingManage">
                    <td colspan="13">
                        <div class="center-align animated flash loader">
                            Loading...
                        </div>
                    </td>
                </tr>

                <tr v-else v-for="(item, index) in manageItems" :key="item.uniqid">
                    <td>
                        {{ item.branch }}
                    </td>
                    <td>
                        <span v-if="!item.productEdit" @dblclick="changeEdit(item.uniqid, 'product')">{{ item.product }}</span>
                        <div v-else @dblclick="cancelEdit(item.uniqid, 'product')" class="input-field col s12">
                            <input id="product" type="text" class="validate" v-model="$v.product.$model" @keyup.enter="editDataProduct(item.uniqid, 'product')">
                            <label for="product">Product</label>
                            <span class="red-text helper-text" v-if="!$v.product.required">Tidak boleh kosong!</span>
                            <span class="red-text helper-text" v-if="!$v.product.minLength">Minimal 5 karakter!</span>
                        </div>
                    </td>
                    <td>
                        <span v-if="!item.typeEdit" @dblclick="changeEdit(item.uniqid, 'type')">{{ item.type }}</span>
                        <div v-else @dblclick="cancelEdit(item.uniqid, 'type')" class="input-field col s12">
                            <input id="type" type="text" class="validate" v-model="$v.type.$model" @keyup.enter="editDataProduct(item.uniqid, 'type')">
                            <label for="type">Type</label>
                            <span class="red-text helper-text" v-if="!$v.type.required">Tidak boleh kosong!</span>
                            <span class="red-text helper-text" v-if="!$v.type.minLength">Minimal 5 karakter!</span>
                        </div>
                    </td>
                    <td>
                        <span v-if="!item.categoryEdit" @dblclick="changeEdit(item.uniqid, 'category')">{{ item.category }}</span>
                        <div v-else @dblclick="cancelEdit(item.uniqid, 'category')" class="input-field col s12">
                            <input id="category" type="text" class="validate" v-model="$v.category.$model" @keyup.enter="editDataProduct(item.uniqid, 'category')">
                            <label for="category">Category</label>
                            <span class="red-text helper-text" v-if="!$v.category.required">Tidak boleh kosong!</span>
                            <span class="red-text helper-text" v-if="!$v.category.minLength">Minimal 5 karakter!</span>
                        </div>
                    </td>
                    <td>
                        <span v-if="!item.priceEdit" @dblclick="changeEdit(item.uniqid, 'price')">Rp. {{ parseInt(item.price).toLocaleString('id') }}</span>
                        <div v-else @dblclick="cancelEdit(item.uniqid, 'price')" class="input-field col s12">
                            <input id="price" type="text" class="validate" v-model="$v.price.$model" @keyup.enter="editDataProduct(item.uniqid, 'price')">
                            <label for="price">Price</label>
                            <span class="red-text helper-text" v-if="!$v.price.required">{{ errPrice }}</span>
                            <span class="red-text helper-text" v-if="!$v.price.minLength">Minimal 3 karakter!</span>
                        </div> 
                    </td>
                    <td>
                        <span v-if="!item.stockEdit" @dblclick="changeEdit(item.uniqid, 'stock')">{{ item.stock }} item</span>
                        <div v-else @dblclick="cancelEdit(item.uniqid, 'stock')" class="input-field col s12">
                            <input id="stock" type="text" class="validate" v-model="$v.stock.$model" @keyup.enter="editDataProduct(item.uniqid, 'stock')">
                            <label for="stock">Stock</label>
                            <span class="red-text helper-text" v-if="!$v.stock.required">{{ errStock }}</span>
                            <span class="red-text helper-text" v-if="!$v.stock.minLength">Minimal 1 karakter!</span>
                        </div>
                    </td>
                    <td>
                        <span>{{ item.sales }} Item</span>
                    </td>
                    <td>
                        <i class="tiny material-icons red-text" @click.prevent="deleteProduct(item.uniqid, index)">delete</i>
                    </td>
                </tr>
            </tbody>
        </table>

        <FooterItem v-if="loadingManage && manageItems.length > 0" />

    </div>
</template>

<script>
import { required, minLength } from 'vuelidate/lib/validators';
import FooterItem from './FooterItem';
import { Bus } from '../../../../app';
import _ from 'lodash';

export default {
    props: {
        menu: {
            type: String,
            required: true
        }
    },
    data(){
        return {
            searchItems: '',
            product: '',
            type: '',
            category: '',
            price: '',
            stock: '',
            errPrice: 'Tidak boleh kosong!',
            errStock: 'Tidak boleh kosong!'
        }
    },
    components: {
        FooterItem,
    },
    mounted(){
        this.$store.dispatch('getItemManagement', 'api/products')
    },
    computed: {
        loadingManage(){
            return this.$store.getters.loadingManage
        },

        manageItems(){
            return this.$store.getters.manageItems
        },
    },
    watch:{
        searchItems: _.debounce((event) => {
            Bus.$emit('searchItemManagement', event.trim())
        }, 800),
        
        price(valuePrice){
            const result = this.price = valuePrice.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            if(result == '') this.errPrice = 'Harus berupa angka!';
            else this.errPrice = 'Tidak boleh kosong!';
        },

        stock(valueStock){
            const result = this.stock = valueStock.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            if(result == '') this.errStock = 'Harus berupa angka!';
            else this.errStock = 'Tidak boleh kosong!';
        },
    },
    methods: {
        changeEdit(id, mode){
            const items  = this.manageItems.find(item => item.uniqid == id);
            // active edit
            const activeProduct     = this.manageItems.find(item => item.productEdit);
            const activeType        = this.manageItems.find(item => item.typeEdit);
            const activeCategory    = this.manageItems.find(item => item.categoryEdit);
            const activePrice       = this.manageItems.find(item => item.priceEdit);
            const activeStock       = this.manageItems.find(item => item.stockEdit);

            switch (mode) {
                case 'product':
                    items.productEdit = true
                    break;

                case 'type':
                    items.typeEdit = true
                    break;
                
                case 'category':
                    items.categoryEdit = true
                    break;

                case 'price':
                    items.priceEdit = true
                    break;
            
                default:
                    items.stockEdit = true
                    break;
            }

            if(activeProduct){

                activeProduct.productEdit = false 

            }else if(activeType){

                activeType.typeEdit = false 

            }else if(activeCategory){

                activeCategory.categoryEdit = false 

            }else if(activePrice){

                activePrice.priceEdit = false 

            }else if(activeStock){

                activeStock.stockEdit = false

            }

        },

        cancelEdit(id, mode){
            const items = this.manageItems.find(item => item.uniqid == id);

            switch (mode) {
                case 'product':
                    items.productEdit = false
                    this.product = ''
                    break;

                case 'type':
                    items.typeEdit = false
                    this.type = ''
                    break;
                
                case 'category':
                    items.categoryEdit = false
                    this.category = ''
                    break;

                case 'price':
                    items.priceEdit = false
                    this.price = ''
                    break;
            
                default:
                    items.stockEdit = false
                    this.stock = ''
                    break;
            }

        },

        editDataProduct(id, mode){
            let item = ''
            const items = this.manageItems.find(item => item.uniqid == id);

            switch (mode) {
                case 'product':
                    item = this.product
                    break;

                case 'type':
                    item = this.type
                    break;
                
                case 'category':
                    item = this.category
                    break;

                case 'price':
                    item = this.price
                    break;
            
                default:
                    item = this.stock
                    break;
            }

            if(!this.$v.product.$invalid || !this.$v.type.$invalid || !this.$v.category.$invalid || !this.$v.price.$invalid || !this.$v.stock.$invalid){
                this.$store.dispatch('updateProductsItemsManagement', {
                    mode: mode,
                    id: id,
                    item: item,
                    url: `api/products/${id}`
                }).then(res => {
                    switch (mode) {
                        case 'product':
                            items.product = this.product
                            items.productEdit = false
                            this.product = ''
                            break;

                        case 'type':
                            items.type = this.type
                            items.typeEdit = false
                            this.type = ''
                            break;
                        
                        case 'category':
                            items.category = this.category
                            items.categoryEdit = false
                            this.category = ''
                            break;

                        case 'price':
                            items.price = this.price
                            items.priceEdit = false
                            this.price = ''
                            break;
                    
                        default:
                            items.stock = this.stock
                            items.stockEdit = false
                            this.stock = ''
                            break;
                    }

                }).catch(err => {

                    console.log(err.response)

                })
            }else{
                alert('error')
            }
        },

        deleteProduct(id, key){
            this.$swal({
                title: 'Anda Yakin?',
                text: 'Ingin menghapus data ini!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Jangan, nanti saja!',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if(result.value) {

                    this.$store.dispatch('deleteItemProduct', `api/products/${id}`)
                        .then(res => {
                            
                            if(res.status == true){
                                this.manageItems.splice(1, key)
                                this.$swal('Deleted', res.msg, 'success')
                            }
                        })
                    
                } else {
                    this.$swal('Cancelled', 'Your file is still intact', 'info')
                }
            })
            
        }
    },

    validations: {
        product: { required, minLength: minLength(5) },
        type: { required, minLength: minLength(5) },
        category: { required, minLength: minLength(5) },
        price: { required, minLength: minLength(3) },
        stock: { required, minLength: minLength(1) },
    }
}
</script>

<style scoped>
i:hover{
    cursor: pointer;
}
</style>
