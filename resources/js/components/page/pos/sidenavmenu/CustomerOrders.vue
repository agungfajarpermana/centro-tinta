<template>
    <div v-if="menu == 'CO'" class="animated fadeIn">
        <span class="card-title">Customer Orders</span>
        <table class="striped">
            <thead>
                <tr>
                    <th colspan="5">Branches</th>
                    <th colspan="5">Customer</th>
                    <th colspan="2">Total Items</th>
                    <th colspan="2">Total Price</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td colspan="5">Centro Link (Jakarta)</td>
                    <td colspan="5">M. Arif Nur</td>
                    <td colspan="2">3 Item</td>
                    <td colspan="2">Rp. 500.000</td>
                    <td>
                        <i class="material-icons dropdown-trigger" data-target='dropdown1'>more_vert</i>
                    </td>

                    <!-- Dropdown Structure -->
                    <ul id='dropdown1' class='dropdown-content'>
                        <li><a href="#!"><i class="material-icons">edit</i>edit</a></li>
                        <li><a href="#!"><i class="material-icons">delete</i>delete</a></li>
                        <li><a href="#!"><i class="material-icons">add</i>detail</a></li>
                    </ul>
                </tr>
                <tr>
                    <td colspan="5">Centro Link (Bekasi)</td>
                    <td colspan="5">Agung Fajar Permana</td>
                    <td colspan="2">5 Item</td>
                    <td colspan="2">Rp. 700.000</td>
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
    },
    mounted(){
        M.AutoInit()
    }
}
</script>

<style scoped>
i:hover{
    cursor: pointer;
}
</style>
