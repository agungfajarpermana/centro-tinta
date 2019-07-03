<template>
    <div>
        <!-- Navbar Component -->
        <Navbar />

        <div class="row animated fadeIn">
            <div class="col s12 m3 l3">

                <!-- list pos management component -->
                <SidenavPos/>

            </div>
            <div class="col s12 m9 l9">
                <div class="card z-depth-1">
                    <div class="card-content">
                        <!-- component customer orders -->
                        <CustomerOrders :menu="menu"/>

                        <!-- component items management -->
                        <ItemsManagement :menu="menu"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Bus} from '../../../app';
import Navbar from '../Navbar';
import SidenavPos from './SidenavPos';
import CustomerOrders from './sidenavmenu/CustomerOrders';
import ItemsManagement from './sidenavmenu/ItemsManagement';

export default {
    data(){
        return {
            menu: 'CO'
        }
    },
    components: {
        Navbar,
        SidenavPos,
        CustomerOrders,
        ItemsManagement
    },
    created(){
        Bus.$on('changeMenu', (data) => {
            this.menu = data
        })
    }
}
</script>
