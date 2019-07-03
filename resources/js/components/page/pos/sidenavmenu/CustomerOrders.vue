<template>
    <div v-if="menu == 'CO'" class="animated fadeIn">
        <span class="card-title">Customer Orders</span>
        <table class="striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Item Name</th>
                    <th>Item Price</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Alvin</td>
                    <td>Eclair</td>
                    <td>$0.87</td>
                </tr>
                <tr>
                    <td>Alan</td>
                    <td>Jellybean</td>
                    <td>$3.76</td>
                </tr>
                <tr>
                    <td>Jonathan</td>
                    <td>Lollipop</td>
                    <td>$7.00</td>
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