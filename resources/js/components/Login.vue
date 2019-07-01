<template>
    <div>
        <div class="row">
            <div class="col s12 m6 offset-m3 login">
                <div class="card blue-grey darken-1 z-depth-3">
                    <div class="card-content white-text">
                        <span class="card-title">Centro Link Indonesia (POS)</span>
                        
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="username" type="text">
                                <label for="username" class="white-text">Username</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" type="password">
                                <label for="password" class="white-text">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="#" class="right" @click.prevent="$router.push({ name: 'Home' })">Signin</a>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <Footer/>
    </div>
</template>

<script>
import Footer from './Footer';

export default {
    components:{
        Footer
    }
}
</script>

<style scoped>
.login{
    margin-top: 13%;
}
</style>
