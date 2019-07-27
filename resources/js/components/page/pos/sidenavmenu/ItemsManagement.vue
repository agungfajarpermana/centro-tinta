<template>
    <div v-if="menu == 'IM'" class="animated fadeIn">
        <div class="row">
            <div class="col s8 m8 l8">
                <span class="card-title">Items Management</span>
                <a href="#modal1" class="waves-effect waves-light btn-small modal-trigger"
                    @click.prevent="show">Add Items</a>
            </div>

            <div class="input-field col s4 m4 l4" style="margin-top:-15px;">
                <input type="text" v-model="searchItems" placeholder="Search by product">
            </div>
        </div>
        <table class="striped responsive-table">
            <thead>
                <tr>
                    <th>Branches</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
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

                <tr v-else v-for="item in manageItems" :key="item.uniqid">
                    <td>{{ item.branch }}</td>
                    <td>{{ item.product }}</td>
                    <td>{{ item.type }}</td>
                    <td>{{ item.category }}</td>
                    <td>Rp. {{ parseInt(item.price).toLocaleString('id') }}</td>
                    <td>{{ item.stock }} item</td>
                    <td>{{ item.sales }} Item</td>
                    <td>
                        <i class="tiny material-icons blue-text">edit</i> &nbsp;
                        <i class="tiny material-icons red-text">delete</i>
                    </td>
                </tr>
            </tbody>
        </table>

        <FooterItem v-if="loadingManage && manageItems.length > 0" />
         <!-- Modal Structure -->
        <div id="modal1" class="modal modal-fixed-footer">
            <div class="modal-content">
                <div class="row">
                    <div class="col s12">
                        <ul id="tabs-swipe-demo" class="tabs">
                            <li class="tab col s6"><a href="#test-swipe-1" class="active">Add Items</a></li>
                            <li class="tab col s6"><a href="#test-swipe-2">Upload Items</a></li>
                        </ul>
                        <div id="test-swipe-1" class="col s12">
                            <form class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="product" type="text" v-model="$v.product.$model">
                                        <label for="product">Product</label>
                                        <span class="red-text helper-text" v-if="!$v.product.required">Tidak boleh kosong!</span>
                                        <span class="red-text helper-text" v-if="!$v.product.minLength">Minimal 5 karakter!</span>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:-20px;">
                                    <div class="input-field col s6">
                                        <input id="price" type="text" v-model="$v.price.$model">
                                        <label for="price">Price</label>
                                        <span class="red-text helper-text" v-if="!$v.price.required">{{ errPrice }}</span>
                                        <span class="red-text helper-text" v-if="!$v.price.minLength">Minimal 3 karakter!</span>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="stock" type="text" v-model="$v.stock.$model">
                                        <label for="stock">Stock</label>
                                        <span class="red-text helper-text" v-if="!$v.stock.required">Tidak boleh kosong!</span>
                                        <span class="red-text helper-text" v-if="!$v.stock.minLength">Minimal 1 karakter!</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="test-swipe-2" class="col s12">
                            <form action="#">
                                <br>

                                <div>
                                    <p class="green-text">
                                        <strong>Perhatian!</strong>
                                    </p>
                                    <p>
                                        Silahkan anda <a href="#">unduh</a> file ini, lalu anda inputkan data - data items (product tinta) 
                                        yang akan anda jual ke dalam file tersebut, kemudian silahkan anda upload 
                                        kembali melalui form dibawah ini.
                                    </p>
                                </div>
                                
                                <br>

                                <div class="row">
                                    <form action="" enctype="multipart/form-data">
                                        <div class="col s9 m9 l9">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>File</span>
                                                    <input type="file" ref="file" name="file">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" ref="files" placeholder="Upload one or more files excel">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col s3 m3 l3">
                                            <a href="#" class="btn waves-block red upload">Upload</a>
                                        </div>

                                        <!-- <div class="col s12" v-if="loadingUpload">
                                            <div class="progress">
                                                <div class="determinate" :style="{'width': progressBar + '%'}"></div>
                                            </div>
                                        </div> -->
                                    </form>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat" :disabled="$v.validationGroup.$invalid || disabled">Save data</a>
            </div>
        </div>  
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
            disabled: false,
            errPrice: 'Tidak boleh kosong!'
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

        product: {
            get(){
                return this.$store.getters.product
            },

            set(value){
                this.$store.state.items.product = value
            }
        },

        price: {
            get(){
                return this.$store.getters.price
            },

            set(value){
                this.$store.state.items.price = value
            }
        },

        stock: {
            get(){
                return this.$store.getters.stock
            },

            set(value){
                this.$store.state.items.stock = value
            }
        }
    },
    watch:{
        searchItems: _.debounce((event) => {
            Bus.$emit('searchItemManagement', event.trim())
        }, 800),

        price(valuePrice){
            const result = this.$store.state.items.price = valuePrice.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            if(result == '') this.errPrice = 'Harus berupa angka!';
            else this.errPrice = 'Tidak boleh kosong!';
        },
    },
    methods: {
        show(){
            M.AutoInit()
        }
    },

    validations: {
        product: { required, minLength: minLength(5) },
        price: { required, minLength: minLength(3) },
        stock: { required, minLength: minLength(1) },
        validationGroup: ['product','price','stock']
    }
}
</script>

<style scoped>
i:hover{
    cursor: pointer;
}
.upload{
    margin-top: 18px;
}
</style>
