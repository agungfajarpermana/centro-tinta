<template>
    <div v-if="menu == 'IM'" class="animated fadeIn">
        <span class="card-title">Items Management</span>
        <table class="striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Sales</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Toner Catrige Refill</td>
                    <td>Catrige-CO1</td>
                    <td>Tinta</td>
                    <td>Rp. 35.000</td>
                    <td>10 Item</td>
                    <td>
                        <i class="material-icons">more_vert</i>
                    </td>
                </tr>
                <tr>
                    <td>Toner Catrige Refill Series</td>
                    <td>Catrige-CO1S</td>
                    <td>Tinta</td>
                    <td>Rp. 80.000</td>
                    <td>10 Item</td>
                    <td>
                        <i class="material-icons">more_vert</i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        menu: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>
i:hover{
    cursor: pointer;
}
</style>
