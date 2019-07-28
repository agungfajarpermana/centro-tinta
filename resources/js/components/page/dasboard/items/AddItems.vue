<template>
    <div>
        <Navbar /> 
        <br><br>

        <div class="container">
            <div class="row">
                <div class="col s12">
                    <ul id="tabs-swipe-demo" class="tabs">
                        <li class="tab col s6"><a href="#test-swipe-1" class="active">Add Items</a></li>
                        <li class="tab col s6"><a href="#test-swipe-2">Upload Items</a></li>
                    </ul>
                    <div id="test-swipe-1" class="col s12">
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
                                <span class="red-text helper-text" v-if="!$v.stock.required">{{ errStock }}</span>
                                <span class="red-text helper-text" v-if="!$v.stock.minLength">Minimal 1 karakter!</span>
                            </div>
                        </div>
                        <a href="#!" class="modal-close waves-effect waves-green btn-small right" 
                            :disabled="$v.validationGroup.$invalid || disabled"
                            @click.prevent="saveDataItems"
                        >
                            Save data
                        </a>
                    </div>
                    <div id="test-swipe-2" class="col s12">
                        <form action="#">
                            <br>

                            <div>
                                <p class="green-text">
                                    <strong>Perhatian!</strong>
                                </p>
                                <p>
                                    Silahkan anda <a href="#" @click.prevent="downloadFile">unduh</a> file ini, lalu anda inputkan data - data items (product tinta) 
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
                                                <input type="file" ref="file" name="file" @change="getFile">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" ref="files" placeholder="Upload one or more files excel">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col s3 m3 l3">
                                        <a href="#" class="btn waves-block red upload" :disabled="loadingUpload" @click.prevent="importFile">Upload</a>
                                    </div>

                                    <div class="col s12" v-if="loadingUpload">
                                        <div class="progress">
                                            <div class="determinate" :style="{'width': progressBar + '%'}"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { required, minLength } from 'vuelidate/lib/validators';
import Navbar from '../../Navbar';

export default {
    data(){
        return {
            excel: null,
            extension: '',
            disabled: false,
            errPrice: 'Tidak boleh kosong!',
            errStock: 'Tidak boleh kosong!'
        }
    },
    components: {
        Navbar
    },
    computed: {
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
        },

        loadingUpload(){
            return this.$store.getters.loadingUpload
        },

        progressBar(){
            return this.$store.getters.progressBar
        }
    },
    watch: {
        price(valuePrice){
            const result = this.$store.state.items.price = valuePrice.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            if(result == '') this.errPrice = 'Harus berupa angka!';
            else this.errPrice = 'Tidak boleh kosong!';
        },

        stock(valueStock){
            const result = this.$store.state.items.stock = valueStock.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            if(result == '') this.errStock = 'Harus berupa angka!';
            else this.errStock = 'Tidak boleh kosong!';
        },
    },
    methods: {
        saveDataItems(){
            this.disabled = !this.disabled

            this.$store.dispatch('saveDataItems', {
                url: 'api/products',
                product: this.product,
                price: this.price,
                stock: this.stock
            }).then(res => {
                
                if(res.status == true){
                    this.disabled = !this.disabled
                    M.toast({html: res.msg})
                }

            }).catch(err => {
                console.log(err.status)
            })
        },

        downloadFile(){
            window.location.href = 'api/products/file/downloadFile'
        },
        
        getFile(e){
            this.excel = e.target.files[0]
            this.extension = e.target.files[0].name.split('.').pop()
        },

        importFile(){
            if(this.excel !== null){

                if(this.extension == 'xlsx' || this.extension == 'xls'){

                    this.$store.dispatch('importFile', this.excel).then(status => {

                    if(status === true){
                        setTimeout(() => {
                            this.$refs.file.value = this.$refs.files.value = this.excel = null
                        }, 2000);
                    }

                    }).catch(err => {

                        this.$refs.file.value = this.$refs.files.value = this.excel = null
                        M.toast({html: 'Proses upload bermasalah, silahkan upload ulang!'})

                    })

                }else{
                    M.toast(
                        {
                            html: `Extension file tidak sesuai unduhan! 
                                   &nbsp; <span class="yellow-text text-darken-4"> .${this.extension} </span> 
                                   &nbsp; (Ga Boleh!)`
                        }
                    )
                }

            }else{
                M.toast({html: 'Tidak boleh kosong!'})
            }
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
.upload{
    margin-top: 18px;
}
</style>
