<template>

    <div class="canvasBlock" style="border: 1px solid black; margin-left:15px; margin-right:15px; width:100%;">
        <canvas
                id="canvas" style="width:100%; height:100%;"
                @mousedown="start"
                @mousemove="move"
                @mouseup="drag=false,drawing=false"
                @mouseout="finishMove"
                @keyup.ctrl="drag=false"
                @wheel="handleScroll"

        ></canvas>
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
            },
            beadMatrix: {
                type: Object,
            },
            patternValues: {
                type: Object
            },
        },
        data: function () {
            return {
                //Read only from the pattern
                beadPalette: this.palette,
                updatableMatrix: this.beadMatrix,
                history: null,
                canvasProps: {
                    canvas: null,
                    ctx: null,
                },
                drawProps: {
                    currX: null,
                    currY: null,
                    prevX: null,
                    prevY: null,
                    beadX: null,
                    beadY: null,
                    drawing: false,
                },
                displayProps: {
                    beadWidth: 1,
                    beadHeight: 1,
                    topOffset: 0,
                    leftOffset: 0,
                    rightOffset: 0,
                    bottomOffset: 0,
                },

            }
        },
        mounted() {
            this.canvasProps.canvas = document.getElementById('canvas');
            this.canvasProps.ctx = this.canvasProps.canvas.getContext('2d');

            //resize the canvas
            this.canvasProps.canvas.width = this.canvasProps.canvas.clientWidth;
            this.canvasProps.canvas.height = this.canvasProps.canvas.clientHeight;

            window.addEventListener('resize', this.onResize);
            this.drawNewGrid();
        },
        beforeDestroy: function () {
            window.removeEventListener('resize', this.onResize);
        },
        methods: {
            /**
             * Changing the size of the canvas
             */
            onResize: function () {
                this.canvasProps.canvas.width = this.canvasProps.canvas.clientWidth;
                this.canvasProps.canvas.height = this.canvasProps.canvas.clientHeight;
                this.drawNewGrid();

            },
            start: function (event) {
                this.canvasProps.ctx.beginPath();

                this.drawProps.prevX = this.drawProps.currX;
                this.drawProps.prevY = this.drawProps.currY;

                if (event.ctrlKey) {
                    this.drag = true;
                }
                if (this.drawProps.beadX > this.gridWidth || this.beadX < 0) {
                    this.drag = true;
                }
                else if (this.beadY > this.gridHeight || this.beadY < 0) {
                    this.drag = true;
                }
                if (!this.drag) {
                    this.lastState = JSON.stringify(this.updatableMatrix);
                    this.drawing = true;
                    this.drawBead(this.drawProps.beadX - 1, this.drawProps.beadY - 1, this.actionBarValues.bead);
                }
            },
            move: function (event) {
                let currX = event.clientX;
                let currY = event.clientY;

                let leftOffset = this.displayProps.leftOffset;
                let topOffset = this.displayProps.topOffset;
                let scaleFactor = this.actionBarValues.panZoom.scaleFactor;
                let beadWidth = this.displayProps.beadWidth;
                let beadHeight = this.displayProps.beadHeight;

                if (this.drag) {
                    if (this.zoomChild != null) {
                        this.zoomChild.changePan(this.currX - this.prevX, this.currY - this.prevY);
                        this.prevX = this.currX;
                        this.prevY = this.currY;
                        this.drawNewGrid();
                    }
                } else {

                    let rect = canvas.getBoundingClientRect();

                    this.drawProps.beadX = (currX - (leftOffset * scaleFactor) - rect.left - ((currX - (leftOffset * scaleFactor) - rect.left) % (beadWidth * scaleFactor))) / (beadWidth * scaleFactor) + 1;
                    this.drawProps.beadY = (currY - (topOffset * scaleFactor) - rect.top - ((currY - (topOffset * scaleFactor) - rect.top) % (beadHeight * scaleFactor))) / (beadHeight * scaleFactor) + 1;

                    if (this.drawProps.beadX <= 0 || this.drawProps.beadX > this.patternValues.patternSize.width || this.drawProps.beadY <= 0 || this.drawProps.beadY > this.patternValues.patternSize.height) {
                        this.drawProps.beadX = '';
                        this.drawProps.beadY = '';
                        return;
                    }
                    if (this.drawing) {
                        this.drawBead(this.drawProps.beadX - 1, this.drawProps.beadY - 1, this.actionBarValues.bead);
                    }
                }
            },
            finishMove: function (event) {
                this.drawing = false;
                this.drag = false;
            },
            drawBead: function (beadX, beadY, bead) {
                this.canvasProps.ctx.fillStyle = bead.color;
                if (beadX === '' || beadY === '')
                    return;
                if (beadX < 0 || beadX >= this.gridWidth || beadY < 0 || beadY >= this.gridHeight)
                    return;

                let boxX = (this.displayProps.leftOffset) + ((beadX) * this.displayProps.beadWidth) + 1;
                let boxY = (this.displayProps.topOffset) + ((beadY) * this.displayProps.beadHeight) + 1;
                this.canvasProps.ctx.fillRect(boxX, boxY, this.displayProps.beadWidth - 2, this.displayProps.beadHeight - 2);
                this.updatableMatrix[beadX][beadY] = bead;
            },
            handleScroll: function (event) {
                this.zoomChild.handleScroll(event);
            },
            clear: function () {
                this.updatableMatrix = null;
                this.zoomChild.resetZoom();
                this.drawNewGrid();
            },
            save: function () {
                axios.post('/pattern/save', {
                    'actionBarValues': this.actionBarValues,
                    'palette': this.beadPalette,
                    'beadMatrix': this.updatableMatrix,
                    'patternValues': this.patternValues,
                })
                    .then(function (response) {
                        console.log(response)
                    }).catch(function (response) {
                    console.log('catch');
                });
            },
            undo: function () {
                this.updatableMatrix = JSON.parse(this.lastState);
                this.drawNewGrid();
            },
            rotateLeft: function () {
                this.lastState = JSON.stringify(this.updatableMatrix);
                let oldMatrix = this.updatableMatrix;

                this.updatableMatrix = new Array(this.gridHeight);
                for (let i = 0; i < this.gridHeight; i++) {
                    this.updatableMatrix[i] = new Array(this.gridWidth);
                }

                if (oldMatrix) {
                    //go through our previous bead matrix, and draw out the beads stored there
                    for (let width = 0; width < this.gridWidth; width++) {
                        for (let height = 0; height < this.gridHeight; height++) {
                            if (oldMatrix[this.gridWidth - width]) {
                                this.updatableMatrix[height][width] = oldMatrix[this.gridWidth - width][height];
                            }
                        }
                    }
                }

                let oldHeight = this.gridHeight;
                this.gridHeight = this.gridWidth;
                this.gridWidth = oldHeight;

                this.drawNewGrid();
            },
            rotateRight: function () {
                this.lastState = JSON.stringify(this.updatableMatrix);
                let oldMatrix = this.updatableMatrix;

                this.updatableMatrix = new Array(this.gridHeight);
                for (let i = 0; i < this.gridHeight; i++) {
                    this.updatableMatrix[i] = new Array(this.gridWidth);
                }

                if (oldMatrix) {
                    //go through our previous bead matrix, and draw out the beads stored there
                    for (let width = 0; width < this.gridWidth; width++) {
                        for (let height = 0; height < this.gridHeight; height++) {
                            if (oldMatrix[width]) {
                                this.updatableMatrix[height][width] = oldMatrix[width][this.gridHeight - height];
                            }
                        }
                    }
                }

                let oldHeight = this.gridHeight;
                this.gridHeight = this.gridWidth;
                this.gridWidth = oldHeight;

                this.drawNewGrid();
            },



            isHeightLimited: function() {
                //Calculate the height * width of the pattern - assuming a bead height of 1 taking into account the bead aspect ratio
                let beadPatternHeight = this.patternValues.patternSize.height;
                let beadPatternWidth = this.patternValues.patternSize.width * this.patternValues.beadType.beadAspect;

                //calculate proportionOfCanvas that is covered by th3e pattern
                let canvasHeightCovered = beadPatternHeight * this.canvasProps.canvas.height;
                let canvasWidthCovered = beadPatternWidth * this.canvasProps.canvas.width;

                return canvasHeightCovered < canvasWidthCovered;
            },

            /**
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

                //If our pattern takes up more vertical space on our screen than horizontal
                if (this.isHeightLimited()) {
                    let canvasHeight = this.canvasProps.canvas.height;
                    let gridHeight = this.patternValues.patternSize.height;

                    //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
                    let smallestOffsetPossible = (canvasHeight % gridHeight) / 2;
                    let scaledHeightOffset = smallestOffsetPossible * scaleFactor;

                    //Calculate the bead size - based on the smallest offsets possible & the current zoom
                    this.displayProps.beadHeight = (canvasHeight - scaledHeightOffset) / gridHeight;
                    this.displayProps.beadWidth = this.displayProps.beadHeight * beadAspectRatio;
                } else {
                    let canvasWidth = this.canvasProps.canvas.width;
                    let gridWidth = this.patternValues.patternSize.width;

                    //get the remainder after evenly dividing the number of beads into the canvas & divide by 2 - so its evenly distributed on the top and bottom
                    let smallestOffsetPossible = (canvasWidth % (gridWidth * beadAspectRatio)) / 2;
                    let scaledWidthOffset = smallestOffsetPossible * scaleFactor;

                    this.displayProps.beadWidth = (canvasWidth - scaledWidthOffset) / (gridWidth * beadAspectRatio);
                    this.displayProps.beadHeight = this.displayProps.beadWidth / beadAspectRatio;
                }
            },

            calculateOffset: function(canvasWidth, scaleFactor, beadsAcross, beadWidth) {
                let scaledTotalWidth = canvasWidth/scaleFactor;
                let totalPatternWidth = beadsAcross * beadWidth;

                return scaledTotalWidth - totalPatternWidth;
            },

            /**
             *  Using the bead sizes, pan & zoom calculate the offset from the sizes of the canvas to
             *  draw the pattern
             */
            calculateOffsets: function() {
                let widthOffset = this.calculateOffset(this.canvasProps.canvas.width, this.actionBarValues.panZoom.scaleFactor, this.patternValues.patternSize.width, this.displayProps.beadWidth);
                let heightOffset = this.calculateOffset(this.canvasProps.canvas.height, this.actionBarValues.panZoom.scaleFactor, this.patternValues.patternSize.height, this.displayProps.beadHeight);

                this.displayProps.leftOffset = widthOffset / 2 + this.actionBarValues.panZoom.pan.horizontal;
                this.displayProps.topOffset = heightOffset / 2 + this.actionBarValues.panZoom.pan.vertical;
                this.displayProps.rightOffset = widthOffset - this.displayProps.leftOffset;
                this.displayProps.bottomOffset = heightOffset - this.displayProps.topOffset;
            },

            drawHorizontalLines: function(){
                //draw horizontal lines
                let division = this.displayProps.topOffset;
                let patternHeight = this.patternValues.patternSize.height;
                let beadHeight = this.displayProps.beadHeight;
                let lineStart = this.displayProps.leftOffset;
                let lineEnd = (this.canvasProps.canvas.width / this.actionBarValues.panZoom.scaleFactor) - this.displayProps.rightOffset;

                for (let rowCount = 0; rowCount <= patternHeight; rowCount++) {
                    console.log(rowCount);

                    this.canvasProps.ctx.moveTo(lineStart, division);
                    this.canvasProps.ctx.lineTo(lineEnd, division);
                    division += beadHeight;
                }
            },

            drawVerticalLines: function() {
                //draw vertical
                let division = this.displayProps.leftOffset;
                let patternWidth = this.patternValues.patternSize.width;
                let beadWidth = this.displayProps.beadWidth;
                let lineStart = this.displayProps.topOffset;
                let lineEnd = (this.canvasProps.canvas.height / this.actionBarValues.panZoom.scaleFactor) - this.displayProps.bottomOffset;

                for (let columnCount = 0; columnCount <= patternWidth; columnCount++) {
                    this.canvasProps.ctx.moveTo(division, lineStart);
                    this.canvasProps.ctx.lineTo(division, lineEnd);
                    division += beadWidth;
                }
            },

            drawBeadMatrix: function() {
                let oldMatrix = this.updatableMatrix;

                let gridWidth = this.patternValues.patternSize.width;
                let gridHeight = this.patternValues.patternSize.height;

                this.updatableMatrix = new Array(gridWidth);
                for (let i = 0; i < this.gridWidth; i++) {
                    this.updatableMatrix[i] = new Array(gridHeight);
                }

                if (oldMatrix) {
                    //go through our previous bead matrix, and draw out the beads stored there
                    for (let width = 0; width < gridWidth; width++) {
                        for (let height = 0; height < gridHeight; height++) {
                            if (oldMatrix[width]) {
                                let setColor = oldMatrix[width][height];
                                if (setColor) {
                                    this.drawBead(width, height, setColor);
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
                this.drawBeadMatrix();

                this.canvasProps.ctx.stroke();
            },
        },
        watch: {
            'actionBarValues.panZoom': function () {
                this.drawNewGrid();
            },
            'actionBarValues.signals': function () {
                this.drawNewGrid();
            }
        }
    }
</script>
