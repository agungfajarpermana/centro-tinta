<template>
    <div class="row">
        <div class="col s6 l6">
            <ul class="pagination">
                <li>
                    <a href="#!" class="waves-effect" @click.prevent="!attrPaginationOrder.prev_page_url ? '' : getPaginationOrder(attrPaginationOrder.prev_page_url)">
                        <i class="material-icons">chevron_left</i>
                    </a>
                </li>
                <li style="margin-top:3px;margin-left:-12px;">
                    <span class="badge teal white-text">{{ attrPaginationOrder.current_page }} / {{ attrPaginationOrder.last_page }}</span>
                </li>
                <li>
                    <a href="#!" class="waves-effect" @click.prevent="!attrPaginationOrder.next_page_url ? '' : getPaginationOrder(attrPaginationOrder.next_page_url)">
                        <i class="material-icons">chevron_right</i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        attrPaginationOrder(){
            return this.$store.getters.attrPaginationOrder
        }
    },
    methods: {
        getPaginationOrder(url){
            this.$store.dispatch('getdataOrderPagination', url)
        }
    }
}
</script>

<style scoped>
.pagination{
    padding: 20px, 20px, 0px, 0px;
    margin-top: 20px;
    margin-bottom: -5px;
}
</style>
