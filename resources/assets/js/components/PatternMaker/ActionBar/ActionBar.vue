<template>
    <div id="action-bar" v-bind:style="{width: this.menuWidth + 'px'}">
        <action-bar-controls :menuWidth.sync="menuWidth"></action-bar-controls>

        <div class="actionBarSelects">
            <color-section></color-section>
            <selected-bead></selected-bead>

            <bead-type></bead-type>
            <pattern-type></pattern-type>
            <resize></resize>

            <undo></undo>
            <rotate></rotate>

            <hr>
            <div id="panZoom">
                <pan ref="panControl"></pan>
                <zoom ref="zoomControl"></zoom>
            </div>

            <button id="save" class="btn btn-default" @click="save">SAVE</button>
        </div>


    </div>
</template>
<script>
    import {mapGetters} from 'vuex';

    export default {

        data: function () {
            return {
                menuWidth: 0,
            }
        },
        computed: {
            ...mapGetters({
                patternJSON: "pattern/patternJSON",
            }),
        },
        methods: {
            save: function () {
                let returnPattern = this.patternJSON;
                axios.post('/pattern/save', {
                    returnPattern
                }).then(function (response) {
                    console.log(response);
                }).catch(function (response) {
                    console.log(response);
                })
            },
        }
    }
</script>
