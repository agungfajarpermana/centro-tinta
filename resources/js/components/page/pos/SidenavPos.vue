<template>
    <div>
        <ul id="slide-out" class="sidenav sidenav-fixed">
            <li><a class="subheader">POS Management List Menu</a></li>
            <li>
                <a href="#" class="waves-effect" @click.prevent="selectMenu('CO')">
                    <i class="material-icons">web_assets</i> Customer Order
                </a>
            </li>
            <li>
                <a href="#!" class="waves-effect" @click.prevent="selectMenu('IM')">
                    <i class="material-icons">web</i> Items Management
                </a>
            </li>
            <li>
                <a href="#!" class="waves-effect" @click.prevent="selectMenu('RM')">
                    <i class="material-icons">insert_chart</i> Report Management
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
import {Bus} from '../../../app';

export default {
    methods: {
        selectMenu(menu){
            Bus.$emit('changeMenu', menu)
        }
    }
}
</script>

<style scoped>
.sidenav.sidenav-fixed{
    top: 9% !important;
    /* width: 390px; */
    width: 290px;
}
</style>