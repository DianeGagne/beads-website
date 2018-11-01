<template>
    <div id="patternMaker" style="height:87vh;">
        <div style="height:30px; display:flex; width:100%;">

            <pattern-name :patternName.sync="patternValues.patternName"></pattern-name>

            <new-pattern :patternValues.sync="patternValues"
                         :beadMatrix.sync="beadMatrix"
                         :palette.sync="palette"></new-pattern>
        </div>
        <div style="display: flex; height:100%;">

            <pattern-canvas
                    style="height:100%; width:100%;"
                    :actionBarValues.sync="actionBarValues"
                    :patternValues="patternValues"
                    :beadMatrix.sync="beadMatrix"
                    :palette.sync="palette"
            ></pattern-canvas>


            <action-bar

                    :actionBarValues.sync="actionBarValues"
                    :patternValues="patternValues"
                    :beadMatrix.sync="beadMatrix"
                    :palette.sync="palette"
            ></action-bar>
        </div>

    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                //Values set from the action bar for creating the pattern
                actionBarValues: {
                    bead: {
                        color: '#666666',
                        image: 'db0023',
                        key: 14,
                        otherValue: 'something',
                    },
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
                        redraw: false,
                    },
                    panZoom: {
                        scaleFactor: 1,
                        pan: {
                            horizontal: 0,
                            vertical: 0,
                        },
                    },
                },

                patternValues: {
                    patternName: 'New Pattern',
                    beadType: {
                        name: 'delica',
                        beadAspect: 1,
                        beadWidth: 1.96,
                        beadHeight: 1.96,
                        beadWeight: .030,
                    },
                    stitchType: {
                        name: 'brick',
                    },
                    patternSize: {
                        height: 30,
                        width: 30,
                    }
                },

                beadMatrix: [],
                palette: null,
            }
        },
        mounted: function () {
            //Initialize beadMatrix with default values for sanity
            console.log(this.patternValues.patternSize.width);
            for (let i = 0; i < this.patternValues.patternSize.width; i++) {
                this.beadMatrix[i] = [];
                for (let j = 0; j < this.patternValues.patternSize.height; j++) {
                    this.beadMatrix[i][j] = {};
                }
            }
        },

        methods: {},
        watch: {}
    }
</script>

