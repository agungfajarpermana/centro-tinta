<template>
    <div>
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">CENTRO POINT OF SALE</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Inventory Management</a></li>
                    <li><a href="#" @click.prevent="$router.push({ name: 'Login' })">Sign out</a></li>
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
