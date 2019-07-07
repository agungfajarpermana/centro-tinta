<template>
    <div>
        <Navbar/>

        <div class="row animated fadeIn">
            <div class="col s12 m12 l9">
                <Items :show="show" />

                <PaymentBase :show="show" />
            </div>

            <div class="col s12 m12 l3">
                <Checkout/>
            </div>

            <div class="col s8 m8 l8">
                <Footer :show="show" />
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from './Navbar';
import Items from './dasboard/Items';
import Checkout from './dasboard/Checkout';
import PaymentBase from './dasboard/checkout/PaymentBase';
import Footer from './dasboard/Footer';

import {Bus} from '../../app';

export default {
    data(){
        return {
            show: false
        }
    },
    created(){
        Bus.$on('showItems', (hide) => {
            this.show = hide
        })
    },
    components: {
        Navbar,
        Items,
        Checkout,
        PaymentBase,
        Footer
    }
}
</script>
