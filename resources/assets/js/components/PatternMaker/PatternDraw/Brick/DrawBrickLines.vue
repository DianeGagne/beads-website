<template>
</template>
<script>
    export default {
        /**
         * When a brick stitch is selected, determine the size & location of the grid, and draw the background grid (thread)
         *
         * This will fill in the display within the canvas
         */

        props: {
            //We need to be aware & trigger changes when Zoom is updated
            actionBarValues: {
                type: Object,
            },
            patternValues: {
                type: Object,
            },
            //Update our grid whenever the Canvas changes
            canvasProps: {
                type: Object,
            },
            //We are in charge of the Display Props & will calculate them when drawing our grid
            displayProps: {
                type: Object,
            },
            //Calculate the edges of each bead
            beadMatrix: {
                type: Array,
            }
        },
        data: function () {
            return {
                display: this.displayProps,
                matrix: this.beadMatrix,
            }
        },
        methods: {
            isHeightLimited: function () {
                //Calculate the height * width of the pattern - assuming a bead height of 1 taking into account the bead aspect ratio
                let beadPatternHeight = this.patternValues.patternSize.height;
                let beadPatternWidth = this.patternValues.patternSize.width * this.patternValues.beadType.beadAspect;

                //calculate proportionOfCanvas that is covered by th3e pattern
                let canvasHeightCovered = beadPatternHeight * this.canvasProps.canvas.height;
                let canvasWidthCovered = beadPatternWidth * this.canvasProps.canvas.width;

                return canvasHeightCovered < canvasWidthCovered;
            },

            /*
             * Calculate the bead size given the canvas size & pattern size
             *
             * Find the direction the beads will squish off screen first
             * Then find the largest size the beads can be in that direction - while staying a consistent size
             * Using that size & the aspect ratio calculate the bead size in the other direction
             * Multiply everything by the scale offset so we zoom in/out as required
             */
            calculateBeadSize() {
                let scaleFactor = this.actionBarValues.panZoom.scaleFactor;
                let beadAspectRatio = this.patternValues.beadType.beadAspect;

                let baseBeadHeight = 1;
                let baseBeadWidth = 1;
                //If our pattern takes up more vertical space on our screen than horizontal
                if (this.isHeightLimited()) {
                    let canvasHeight = this.canvasProps.canvas.height;
                    let gridHeight = this.patternValues.patternSize.height;

                    //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
                    let smallestOffsetPossible = (canvasHeight % gridHeight) / 2;

                    //Calculate the bead size - based on the smallest offsets possible & the current zoom
                    baseBeadHeight = (canvasHeight - smallestOffsetPossible) / gridHeight;
                    baseBeadWidth = baseBeadHeight * beadAspectRatio;
                } else {
                    let canvasWidth = this.canvasProps.canvas.width;
                    let gridWidth = this.patternValues.patternSize.width;

                    //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
                    let smallestOffsetPossible = (canvasWidth % (gridWidth * beadAspectRatio)) / 2;

                    baseBeadWidth = (canvasWidth - smallestOffsetPossible) / (gridWidth * beadAspectRatio);
                    baseBeadHeight = baseBeadWidth / beadAspectRatio;
                }

                //apply the scale factor to the bead size
                this.display.beadHeight = baseBeadHeight * scaleFactor;
                this.display.beadWidth = baseBeadWidth * scaleFactor;
            },

            calculateOffset: function (canvasWidth, beadsAcross, beadWidth) {
                let totalPatternWidth = beadsAcross * beadWidth;
                return (canvasWidth - totalPatternWidth) / 2;
            },

            /**
             *  Using the bead sizes, pan & zoom calculate the offset from the sizes of the canvas to
             *  draw the pattern
             */
            calculateOffsets: function () {
                let widthOffset = this.calculateOffset(this.canvasProps.canvas.width, this.patternValues.patternSize.width, this.display.beadWidth);
                let heightOffset = this.calculateOffset(this.canvasProps.canvas.height, this.patternValues.patternSize.height, this.display.beadHeight);

                this.display.leftOffset = widthOffset + this.actionBarValues.panZoom.pan.horizontal;
                this.display.topOffset = heightOffset + this.actionBarValues.panZoom.pan.vertical;
                this.display.rightOffset = widthOffset - this.actionBarValues.panZoom.pan.horizontal;
                this.display.bottomOffset = heightOffset - this.actionBarValues.panZoom.pan.vertical;
            },

            drawHorizontalLines: function () {
                //draw horizontal lines
                let division = this.display.topOffset;
                let patternHeight = this.patternValues.patternSize.height;
                let beadHeight = this.display.beadHeight;
                let lineStart = this.display.leftOffset;
                let lineEnd = this.canvasProps.canvas.width - this.display.rightOffset;

                for (let rowCount = 0; rowCount <= patternHeight; rowCount++) {
                    this.canvasProps.ctx.moveTo(lineStart, division);
                    this.canvasProps.ctx.lineTo(lineEnd, division);

                    //While drawing the lines, update the borders of the beads within the beadMatrix
                    if (rowCount < patternHeight) {
                        for (let beadIndex in this.matrix) {
                            this.matrix[beadIndex][rowCount].topBound = division;
                            this.matrix[beadIndex][rowCount].bottomBound = division + beadHeight;
                        }
                    }

                    division += beadHeight;
                }
            },

            drawVerticalLines: function () {
                //draw vertical
                let division = this.display.leftOffset;
                let patternWidth = this.patternValues.patternSize.width;
                let beadWidth = this.display.beadWidth;
                let lineStart = this.display.topOffset;
                let lineEnd = this.canvasProps.canvas.height - this.display.bottomOffset;

                for (let columnCount = 0; columnCount <= patternWidth; columnCount++) {
                    this.canvasProps.ctx.moveTo(division, lineStart);
                    this.canvasProps.ctx.lineTo(division, lineEnd);

                    //While drawing the lines, update the borders of the beads within the beadMatrix
                    if (columnCount < patternWidth) {
                        for (let beadIndex in this.matrix[columnCount]) {
                            this.matrix[columnCount][beadIndex].leftBound = division;
                            this.matrix[columnCount][beadIndex].rightBound = division + beadWidth;
                        }
                    }

                    division += beadWidth;
                }
            },

            //Draw all beads currently set in the bead matrix as we have just refreshed the screen
            drawExistingBeads: function() {

                for(let xIndex in this.matrix){
                    if(this.matrix.hasOwnProperty(xIndex)) {
                        for (let yIndex in this.matrix[xIndex]) {
                            if(this.matrix[xIndex].hasOwnProperty(yIndex)) {
                                if (this.matrix[xIndex][yIndex].bead) {
                                    this.canvasProps.ctx.fillStyle = this.matrix[xIndex][yIndex].bead.color;
                                    this.canvasProps.ctx.fillRect(this.matrix[xIndex][yIndex].leftBound, this.matrix[xIndex][yIndex].topBound, this.display.beadWidth, this.display.beadHeight);
                                }
                            }
                        }
                    }
                }
            },

            /**
             * After any change to the pattern, simply erase it and draw a new one from the grid.
             * This destroys all current data on the canvas and redraws a new one with new values.
             */
            drawNewGrid: function () {
                this.canvasProps.ctx.setTransform(1, 0, 0, 1, 0, 0);
                this.canvasProps.ctx.clearRect(0, 0, this.canvasProps.canvas.width, this.canvasProps.canvas.height);
                this.canvasProps.ctx.scale(this.scaleFactor, this.scaleFactor);
                this.canvasProps.ctx.beginPath();
                this.canvasProps.ctx.strokeStyle = 'black';

                //calculate bead size
                this.calculateBeadSize();
                this.calculateOffsets();
                this.drawHorizontalLines();
                this.drawVerticalLines();
                this.drawExistingBeads();

                this.canvasProps.ctx.stroke();
                this.$emit('update:displayProps', this.display);
                this.$emit('update:beadMatrix', this.matrix);
            },
        },
        watch: {
            'actionBarValues.panZoom': {
                handler: function () {
                    this.drawNewGrid();
                },
                deep: true,
            },
            'canvasProps.canvasReady': {
                handler: function () {
                    this.drawNewGrid();
                },
                deep: true,
            },
        },
    }
</script>