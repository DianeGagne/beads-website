<template>
    <div class="canvasBlock" style="border: 1px solid black; margin-left:15px; margin-right:15px; width:100%;">
        <draw-brick-lines
        :actionBarValues="actionBarValues"
        :canvasProps="canvasProps"
        :patternValues="patternValues"
        :beadMatrix.sync="updatableMatrix"
        :displayProps.sync="displayProps">
        </draw-brick-lines>

        <brick-bead-calc
            :displayProps="displayProps"
            :beadProps.sync="beadProps"
            :canvasProps="canvasProps"
            :panZoom="actionBarValues.panZoom"
            :mouseProps="mouseProps"
            :patternSize="patternValues.patternSize">
        </brick-bead-calc>
        <canvas
                id="canvas" style="width:100%; height:100%;"
                @mousedown="start"
                @mousemove="move"
                @mouseup="finishMove"
                @mouseout="finishMove"
                @keyup.ctrl="finishMove"
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
                type: Array,
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
                    canvasReady: false,
                },

                //The current display settings as calculated when drawing a grid
                displayProps: {
                    beadWidth: 1,
                    beadHeight: 1,
                    topOffset: 0,
                    leftOffset: 0,
                    rightOffset: 0,
                    bottomOffset: 0,
                },
                //Keep track of the current & previous mouse position
                mouseProps: {
                    currX: null,
                    currY: null,
                    drawing: false,
                },
                //The bounds of the selected Bead
                beadProps: {
                    xIndex: null,
                    yIndex: null,
                },
            }
        },
        mounted() {
            this.canvasProps.canvas = document.getElementById('canvas');
            this.canvasProps.ctx = this.canvasProps.canvas.getContext('2d');

            //resize the canvas
            this.canvasProps.canvas.width = this.canvasProps.canvas.clientWidth;
            this.canvasProps.canvas.height = this.canvasProps.canvas.clientHeight;

            this.canvasProps.canvasReady = true;
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

                this.canvasProps.canvasReady = true;
            },
            start: function (event) {
                this.canvasProps.ctx.beginPath();

                this.mouseProps.prevX = this.mouseProps.currX;
                this.mouseProps.prevY = this.mouseProps.currY;

                if (event.ctrlKey) {
                    this.drag = true;
                }
                if (!this.drag) {
                    this.lastState = JSON.stringify(this.updatableMatrix);
                    this.mouseProps.drawing = true;
                    this.mouseProps.currX = event.clientX;
                    this.mouseProps.currY = event.clientY;
                }
            },
            move: function (event) {
                if(this.mouseProps.drawing) {
                    this.mouseProps.currX = event.clientX;
                    this.mouseProps.currY = event.clientY;
                }

                if (this.drag) {
                    if (this.zoomChild != null) {
                        this.zoomChild.changePan(this.currX - this.prevX, this.currY - this.prevY);
                        this.prevX = this.currX;
                        this.prevY = this.currY;
                    }
                }
            },
            finishMove: function (event) {
                this.mouseProps.drawing = false;
                this.mouseProps.drag = false;
            },
            drawBead: function () {
                this.canvasProps.ctx.fillStyle = this.actionBarValues.bead.color;
                if (this.beadProps.xIndex === null)
                    return;

                let matrixValue = this.updatableMatrix[this.beadProps.xIndex][this.beadProps.yIndex];
                this.canvasProps.ctx.fillRect(matrixValue.leftBound, matrixValue.topBound, matrixValue.rightBound - matrixValue.leftBound, matrixValue.bottomBound - matrixValue.topBound);
                this.updatableMatrix[this.beadProps.xIndex][this.beadProps.yIndex].bead = this.actionBarValues.bead;
            },
            handleScroll: function (event) {
                this.actionBarValues.zoom.handleScroll(event);
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



        },
        watch: {
            'patternValues': {
                handler: function () {
                    this.drawNewGrid();
                }, deep: true,
            },
            'beadProps' : {
                handler: function () {
                    this.drawBead();
                },
                deep: true,
            },
            'beadMatrix' : {
                handler: function() {
                    this.updatableMatrix = this.beadMatrix;
                },
                deep: true,
            },
        }
    }
</script>
