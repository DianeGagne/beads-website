<template>
    <div id="action-bar" v-bind:style="{width: this.menuWidth + 'px'}">
        <div class="flex">
            <action-bar-controls :menuWidth.sync="menuWidth" :bead="actionBarValues.bead"
                                 style="height:100%; width:20px;"></action-bar-controls>

            <div class="actionBarSelects">
                <color-section :actionBarValues.bead.sync="bead" :palette="palette"></color-section>
                <selected-bead :actionBarValues.bead="bead" :palette="palette"></selected-bead>

                <button id="undo" @click="undo=true" class="btn btn-default btn-sm"><span
                        class="glyphicon glyphicon-share-alt"></span></button>
                <button id="redo" @click="redo=true" class="btn btn-default btn-sm"><span
                        class="glyphicon glyphicon-share-alt glyphicon-flip-horizontal"></span></button>

                <rotate :actionBarValues.signals.rotations="rotations"></rotate>

                <pan ref="panControl" :pan.sync="pan"></pan>
                <zoom ref="zoomControl" :scaleFactor.sync="scaleFactor"></zoom>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                //Read only from the pattern
                palette: null,

                //Values set from the action bar for creating the pattern
                actionBarValues: {
                    bead: null,
                    signals: {
                        //signals that trigger an action on the main pattern
                        //they will trigger the action on true, then be set to false again.
                        rotations: {
                            rotateLeft: false,
                            rotateRight: false,
                            flipX: false,
                            flipY: false,
                        },
                        undo: false,
                        redo: false,
                    },
                    panZoom: {
                        scaleFactor: 1,
                        pan: {
                            horizontal: 0,
                            vertical: 0,
                        },
                    },
                },

                //internal variables for controlling the action bar size
                menuWidth: 500,
            }
        },
        mounted() {
        },
        methods: {},
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
