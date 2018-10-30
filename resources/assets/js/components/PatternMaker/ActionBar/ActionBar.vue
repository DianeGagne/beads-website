<template>
    <div id="action-bar" v-bind:style="{width: this.menuWidth + 'px'}">
            <action-bar-controls :menuWidth.sync="menuWidth" :bead="values.bead"></action-bar-controls>

            <div class="actionBarSelects">
                <color-section :bead.sync="values.bead" :palette="palette" @update:bead="updateSelectedBead"></color-section>
                <selected-bead :bead="values.bead" :palette="palette"></selected-bead>

                <hr>
                <button id="undo" @click="values.signals.undo=true" class="btn btn-default btn-sm"><span
                        class="glyphicon glyphicon-share-alt"></span></button>
                <button id="redo" @click="values.signals.redo=true" class="btn btn-default btn-sm"><span
                        class="glyphicon glyphicon-share-alt glyphicon-flip-horizontal"></span></button>

                <hr>
                <rotate :rotations="values.signals.rotations"></rotate>

                <hr>
                <div id="panZoom">
                <pan ref="panControl" :pan="values.panZoom.pan"></pan>
                <zoom ref="zoomControl" :scaleFactor.sync="values.panZoom.scaleFactor"></zoom>
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
                values: this.actionBarValues,
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
                    this.$emit('update:actionBarValues', this.values)
                },
                deep: true,
            }
        }
    }
</script>
