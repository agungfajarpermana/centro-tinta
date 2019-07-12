<template>
    <div>
        <div class="navbar-fixed">
            <nav class="light-blue darken-1">
                <div class="nav-wrapper">
                    <a href="#" class="left burger-menu sidenav-trigger" data-target="slide-out">
                        <i class="material-icons">menu</i>
                    </a>
                    <h5 class="brand-logo hide-on-med-and-down">CENTRO POINT OF SALE</h5>
                    <h5 class="brand-logo hide-on-med-and-up">CENTRO (POS)</h5>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><router-link :to="{name: 'Home'}">Dashboard</router-link></li>
                        <li><router-link :to="{name: 'POS'}">POS Management</router-link></li>
                        <li><router-link exact :to="{name: 'Login'}">Sign out</router-link></li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- component base sidenav -->
        <SideNav />

        <div class="clearfix"></div>
    </div>
</template>

<script>
import SideNav from './SideNav';

export default {
    mounted(){
        M.AutoInit()

    },
    components: {
        SideNav
    }
}
</script>

<style scoped>
.brand-logo, .burger-menu{
    padding-left: 10px;
}

.burger-menu{
    margin-top: 2px;
}
</style>