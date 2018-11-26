<template>
    <div id="action-bar" v-bind:style="{width: this.menuWidth + 'px'}">
        <action-bar-controls :menuWidth.sync="menuWidth"></action-bar-controls>

        <div class="actionBarSelects">
            <color-section></color-section>
            <selected-bead></selected-bead>

           <undo></undo>
            <rotate></rotate>

            <hr>
            <div id="panZoom">
                <pan ref="panControl"></pan>
                <zoom ref="zoomControl"></zoom>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        data: function () {
            return {
                menuWidth: 0,
            }
        },


    }
</script>
