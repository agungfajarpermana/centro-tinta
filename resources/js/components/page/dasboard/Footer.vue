<template>
    <div v-if="!show">
        <div class="col s6 l6">
            <ul class="pagination">
                <li>
                    <a href="#!">
                        <i class="material-icons">chevron_left</i>
                    </a>
                </li>
                <li style="margin-top:3px;margin-left:-12px;">
                    <span class="badge teal white-text">0/0</span>
                </li>
                <li>
                    <a href="#!">
                        <i class="material-icons">chevron_right</i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="col s6 l6 center-align">
            <div class="input-field">
                <input id="icon_prefix" type="text" class="validate">
                <label for="icon_prefix">Cari Items</label>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            required: true
        }
    }
}
</script>

<style scoped>
.pagination{
    margin-bottom:0;
    position: fixed;
    top:90%;
    left: -1%;
}
.input-field{
    width:20%;
    margin-top:-3px;
    margin-left:50px;
    margin-bottom:0;
    position: fixed;
    top:90%;
    left: 40%
}
</style>