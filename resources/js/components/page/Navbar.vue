<template>
    <div>
        <nav>
            <div class="nav-wrapper">
                <router-link to="" class="brand-logo">CENTRO POINT OF SALE</router-link>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li class="active"><router-link to="">Dashboard</router-link></li>
                    <li><router-link to="">POS Management</router-link></li>
                    <li><router-link :to="{name: 'Login'}">Sign out</router-link></li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<style scoped>
.brand-logo{
    padding-left: 10px;
}
</style>