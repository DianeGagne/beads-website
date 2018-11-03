<template>
</template>
<script>
    import SavedPattern from '../../../../StoredData/PatternValues.js';

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
        computed: {
            //the aspect multiple of a bead is always 1 for the height
            aspectPatternHeight: function() {
                return this.beadCountHeight;
            },
            //if we are working with not-square beads multiply by the aspect to get the size across
            aspectPatternWidth: function() {
                return this.beadCountWidth * this.beadAspect;
            },
            //determine if the pattern goes all the way to the height edges or the width edges.
            //To display the entire pattern on the screen as large as possible one must be true
            heightLimited: function() {
                let proportionHeightCovered = this.aspectPatternHeight / this.canvasHeight;
                let proportionWidthCovered = this.aspectPatternWidth / this.canvasWidth;

                console.log('height '+proportionHeightCovered + ' width ' + proportionWidthCovered);
                if(proportionHeightCovered > proportionWidthCovered){
                    return true;
                }else {
                    return false;
                }
            },
            displayBeadHeight: function() {
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
                return baseBeadHeight * this.scaleFactor;
            },
            displayBeadWidth: function() {
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
                return baseBeadWidth * this.scaleFactor
            },
            totalPatternWidth: function() {
              return this.beadCountWidth * this.displayBeadWidth;
            },
            totalPatternHeight: function() {
                return this.beadCountHeight * this.displayBeadHeight;
            },
            leftOffset: function() {
                let baseOffset = (this.canvasWidth - this.totalPatternWidth) / 2;
                return baseOffset + this.horizontalOffset;
            },
            topOffset: function() {
                let baseOffset =(this.canvasHeight - this.totalPatternHeight) / 2;
                return baseOffset + this.verticalOffset;
            },
            rightOffset: function() {
                let baseOffset = (this.canvasWidth - this.totalPatternWidth) / 2;
                return baseOffset - this.horizontalOffset;
            },
            bottomOffset: function() {
                let baseOffset = (this.canvasHeight - this.totalPatternHeight) / 2;
                return baseOffset - this.verticalOffset;
            },
        },
        data: function () {
            return {
                actionBarValues: SavedPattern.actionBarValues,
                patternValues: SavedPattern.patternValues,
                beadMatrix: SavedPattern.beadMatrix,
                display: this.displayProps,
                matrix: SavedPattern.beadMatrix,
                beadCountHeight: SavedPattern.patternValues.patternSize.height,
                beadCountWidth: SavedPattern.patternValues.patternSize.width,
                beadType: SavedPattern.patternValues.beadType,
                beadAspect: SavedPattern.patternValues.beadType.beadAspect,
                scaleFactor: SavedPattern.actionBarValues.panZoom.scaleFactor,
                horizontalOffset : SavedPattern.actionBarValues.panZoom.pan.horizontal,
                verticalOffset: SavedPattern.actionBarValues.panZoom.pan.vertical,

            }
        },
        methods: {
            drawHorizontalLines: function () {
                //draw horizontal lines
                let division = this.topOffset;
                let patternHeight = this.beadCountHeight;
                let beadHeight = this.displayBeadHeight;
                let lineStart = this.leftOffset;
                let lineEnd = this.canvasWidth - this.rightOffset;

                for (let rowCount = 0; rowCount <= patternHeight; rowCount++) {
                    console.log(lineStart, division);
                    this.canvasProps.ctx.moveTo(lineStart, division);
                    this.canvasProps.ctx.lineTo(lineEnd, division);

                    //While drawing the lines, update the borders of the beads within the beadMatrix
                    //todo: store these values in a separate global matrix - it makes rotation difficult
                    if (rowCount < patternHeight) {
                        for (let beadIndex in this.matrix) {
                            if (this.matrix.hasOwnProperty(beadIndex)) {
                                this.matrix[beadIndex][rowCount].topBound = division;
                                this.matrix[beadIndex][rowCount].bottomBound = division + beadHeight;
                            }
                        }
                    }

                    division += beadHeight;
                }
            },

            drawVerticalLines: function () {
                //draw vertical
                let division = this.leftOffset;
                let patternWidth = this.beadCountWidth;
                let beadWidth = this.displayBeadWidth;
                let lineStart = this.topOffset;
                let lineEnd = this.canvasHeight - this.bottomOffset;

                for (let columnCount = 0; columnCount <= patternWidth; columnCount++) {
                    this.canvasProps.ctx.moveTo(division, lineStart);
                    this.canvasProps.ctx.lineTo(division, lineEnd);

                    //While drawing the lines, update the borders of the beads within the beadMatrix
                    //todo: store this in a separate global values as well
                    if (columnCount < patternWidth) {
                        for (let beadIndex in this.matrix[columnCount]) {
                            if (this.matrix[columnCount].hasOwnProperty(beadIndex)) {
                                this.matrix[columnCount][beadIndex].leftBound = division;
                                this.matrix[columnCount][beadIndex].rightBound = division + beadWidth;
                            }
                        }
                    }

                    division += beadWidth;
                }
            },

            //Draw all beads currently set in the bead matrix as we have just refreshed the screen
//            drawExistingBeads: function () {
//
//                for (let xIndex in this.matrix) {
//                    if (this.matrix.hasOwnProperty(xIndex)) {
//                        for (let yIndex in this.matrix[xIndex]) {
//                            if (this.matrix[xIndex].hasOwnProperty(yIndex)) {
//                                if (this.matrix[xIndex][yIndex].bead) {
//                                    this.canvasProps.ctx.fillStyle = this.matrix[xIndex][yIndex].bead.color;
//                                    this.canvasProps.ctx.fillRect(this.matrix[xIndex][yIndex].leftBound, this.matrix[xIndex][yIndex].topBound, this.display.beadWidth, this.display.beadHeight);
//                                }
//                            }
//                        }
//                    }
//                }
//            },

            /**
             * After any change to the pattern, simply erase it and draw a new one from the grid.
             * This destroys all current data on the canvas and redraws a new one with new values.
             */
            drawNewGrid: function () {
                console.log('draw new grid');
                this.canvasProps.ctx.setTransform(1, 0, 0, 1, 0, 0);
                this.canvasProps.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);
                this.canvasProps.ctx.scale(this.scaleFactor, this.scaleFactor);
                this.canvasProps.ctx.beginPath();
                this.canvasProps.ctx.strokeStyle = 'black';


                this.drawHorizontalLines();
                this.drawVerticalLines();

                this.canvasProps.ctx.stroke();
                this.$emit('update:displayProps', this.display);
//                this.$emit('update:beadMatrix', this.matrix);
            },
        },
        watch: {
//            'actionBarValues.panZoom': {
//                handler: function () {
//                    this.drawNewGrid();
//                },
//                deep: true,
//            },

            'canvasWidth': {
                handler: function () {
this.drawNewGrid();
                }
            },
            'canvasProps.canvasReady': {
                handler: function () {
                    this.drawNewGrid();
                },
                deep: true,
            },
            'actionBarValues.signals.redraw': {
                handler: function () {
                    if (this.actionBarValues.signals.redraw) {
                        console.log('draw new grid!');
                        this.drawNewGrid();
                        this.actionBarValues.signals.redraw = false;
                        this.$emit('update:actionBarValues', this.actionBarValues);
                    }
                }
            },
            'beadMatrix': {
                handler: function () {
                    this.matrix = this.beadMatrix;
                }
            }
        },
    }
</script>