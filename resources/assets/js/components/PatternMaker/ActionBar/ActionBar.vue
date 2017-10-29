<template>
    <div id="action-bar" v-bind:style="{width: this.menuWidth + 'px'}">
            <action-bar-controls :menuWidth.sync="menuWidth" :bead="actionBarValues.bead"></action-bar-controls>

            <div class="actionBarSelects">
                <color-section :bead.sync="actionBarValues.bead" :palette="palette" @update:bead="updateSelectedBead"></color-section>
                <selected-bead :bead="actionBarValues.bead" :palette="palette"></selected-bead>

                <hr>
                <button id="undo" @click="actionBarValues.signals.undo=true" class="btn btn-default btn-sm"><span
                        class="glyphicon glyphicon-share-alt"></span></button>
                <button id="redo" @click="actionBarValues.signals.redo=true" class="btn btn-default btn-sm"><span
                        class="glyphicon glyphicon-share-alt glyphicon-flip-horizontal"></span></button>

                <hr>
                <rotate :rotations="actionBarValues.signals.rotations"></rotate>

                <hr>
                <div id="panZoom">
                <pan ref="panControl" :pan="actionBarValues.panZoom.pan"></pan>
                <zoom ref="zoomControl" :scaleFactor.sync="actionBarValues.panZoom.scaleFactor"></zoom>
                </div>
            </div>
    </div>
</template>
<script>
    export default {
        props: {
            actionBarValues: {
                type: Object,
            },
            palette: {
                type: Object,
            }
        },
        data: function () {
            return {
                //Read only from the pattern
                palette: null,

                actionBarValues: this.actionBarValues,


                //internal variables for controlling the action bar size
                menuWidth: 500,
            }
        },
        mounted() {
        },
        methods: {
            updateSelectedBead:
                function() {
                    console.log('bead method');
                    console.log(this);
                }
            ,
        },
        watch: {
            actionBarValues: {
                handler (actionBarValues) {
                    this.$emit('update:actionBarValues', this.actionBarValues)
                },
                deep: true,
            }
        }
    }
</script>
