<template>
</template>
<script>
    import SavedPattern from '../../../../StoredData/PatternValues.js';
    import CanvasLocations from '../../../../StoredData/CanvasLocations.js';
    import {mapMutations, mapState, mapGetters} from 'vuex';

    export default {
        /**
         * When a brick stitch is selected, determine the size & location of the grid, and draw the background grid (thread)
         *
         * This will fill in the display within the canvas
         */

        props: {
            //Update our grid whenever the Canvas changes
            canvasProps: {
                type: Object,
            },
            //We are in charge of the Display Props & will calculate them when drawing our grid
            displayProps: {
                type: Object,
            },
            canvasWidth: {
                type: Number,
            },
            canvasHeight:
                {
                    type: Number,
                },
        },
        data: function () {
            return {
                actionBarValues: SavedPattern.actionBarValues,
                beadMatrix: SavedPattern.beadMatrix,
                display: this.displayProps,
                matrix: SavedPattern.beadMatrix,
                beadType: SavedPattern.patternValues.beadType,
                beadAspect: SavedPattern.patternValues.beadType.beadAspect,
                locations: CanvasLocations,
            }
        },
        computed: {
            // beadCountHeight: function() {
            //     return this.$store.getters['pattern/height'];
            // },
            // beadCountWidth: function() {
            //     return this.$store.getters['pattern/width']
            // },
            // //the aspect multiple of a bead is always 1 for the height
            // aspectPatternHeight: function () {
            //     return this.$store.getters['pattern/height'];
            // },
            // //if we are working with not-square beads multiply by the aspect to get the size across
            // aspectPatternWidth: function () {
            //     return this.$store.getters['pattern/width'] * this.beadAspect;
            // },
            // //determine if the pattern goes all the way to the height edges or the width edges.
            //To display the entire pattern on the screen as large as possible one must be true
            // heightLimited: function () {
            //     let proportionHeightCovered = this.aspectPatternHeight / this.canvasHeight;
            //     let proportionWidthCovered = this.aspectPatternWidth / this.canvasWidth;
            //
            //     return proportionHeightCovered > proportionWidthCovered;
            // },
            //Determine how tall each bead is on the screen
            displayBeadHeight: function () {
                let baseBeadHeight = 1;
                //If our pattern takes up more vertical space on our screen than horizontal
                if (this.heightLimited) {
                    //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
                    let smallestOffsetPossible = (this.canvasHeight % this.beadCountHeight) / 2;

                    //Calculate the bead size - based on the smallest offsets possible & the current zoom
                    baseBeadHeight = (this.canvasHeight - smallestOffsetPossible) / this.beadCountHeight;
                } else {
                    //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
                    let smallestOffsetPossible = (this.canvasWidth % (this.beadCountWidth * this.beadAspect)) / 2;

                    let baseBeadWidth = (this.canvasWidth - smallestOffsetPossible) / (this.beadCountWidth * this.beadAspect);
                    baseBeadHeight = baseBeadWidth / this.beadAspect;
                }

                //apply the scale factor to the bead size
                this.locations.rowHeight = baseBeadHeight * SavedPattern.scaleFactor;
                return this.locations.rowHeight;
            },
            //Determine how wide each bead is on the screen
            displayBeadWidth: function () {
                let baseBeadHeight = 1;
                let baseBeadWidth = 1;
                //If our pattern takes up more vertical space on our screen than horizontal
                if (this.heightLimited) {
                    //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
                    let smallestOffsetPossible = (this.canvasHeight % this.beadCountHeight) / 2;

                    //Calculate the bead size - based on the smallest offsets possible & the current zoom
                    baseBeadHeight = (this.canvasHeight - smallestOffsetPossible) / this.beadCountHeight;
                    baseBeadWidth = baseBeadHeight * this.beadAspect;
                } else {
                    //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
                    let smallestOffsetPossible = (this.canvasWidth % (this.beadCountWidth * this.beadAspect)) / 2;

                    baseBeadWidth = (this.canvasWidth - smallestOffsetPossible) / (this.beadCountWidth * this.beadAspect);
                }

                //apply the scale factor to the bead size
                this.locations.columnWidth = baseBeadWidth * SavedPattern.scaleFactor;
                return this.locations.columnWidth;
            },
            totalPatternWidth: function () {
                this.locations.pixelWidth = this.beadCountWidth * this.displayBeadWidth;
                return this.locations.pixelWidth;
            },
            totalPatternHeight: function () {
                this.locations.pixelHeight = this.beadCountHeight * this.displayBeadHeight;
                return this.locations.pixelHeight;
            },
            leftOffset: function () {
                let baseOffset = (this.canvasWidth - this.totalPatternWidth) / 2;
                this.locations.leftOffset = baseOffset + SavedPattern.pan.horizontal;
                return this.locations.leftOffset;
            },
            topOffset: function () {
                let baseOffset = (this.canvasHeight - this.totalPatternHeight) / 2;
                this.locations.topOffset = baseOffset + SavedPattern.pan.vertical;
                return this.locations.topOffset;
            },
            rightOffset: function () {
                let baseOffset = (this.canvasWidth - this.totalPatternWidth) / 2;
                this.locations.rightOffset = baseOffset - SavedPattern.pan.horizontal;
                return this.locations.rightOffset;
            },
            bottomOffset: function () {
                let baseOffset = (this.canvasHeight - this.totalPatternHeight) / 2;
                this.locations.bottomOffset = baseOffset - SavedPattern.pan.vertical;
                return this.locations.bottomOffset;
            },
        },

        methods: {

        },
        watch: {

        },
    }
</script>