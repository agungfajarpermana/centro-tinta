<template>
    <div>
        <Navbar/>

        <div class="row">
            <div class="col s12 m8 l8">
                <Items :show="show" />

                <PaymentBase :show="show" />
            </div>

            <div class="col s12 m4 l4">
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
