<template>
    <div id="patternMaker" style="height:87vh;">


        <div style="display: flex; height:100%;">
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

            <action-bar
                    style="height:100%; right:0"
                    :panHorizontal.sync="panHorizontal"
                    :panVertical.sync="panVertical"
                    :scaleFactor.sync="scaleFactor"
                    :gridWidth.sync="gridWidth"
                    :gridHeight.sync="gridHeight"
                    :bead.sync="bead"
                    :beadType.sync="beadType"
                    :beadMatrix.sync="beadMatrix"
            ></action-bar>
        </div>

    </div>


</template>
<script>
    export default {
        data: function () {
            return {
                currX: null,
                currY: null,
                prevX: null,
                prevY: null,
                beadX: null,
                beadY: null,
                drawing: false,
                drag: false,
                canvas: null,
                ctx: null,
                gridWidth: 20,
                gridHeight: 20,
                leftOffset: 0,
                topOffset: 0,
                beadWidth: 2,
                beadHeight: 2,
                beadAspect: 1,
                zoomChild: null,
                scaleFactor: 1,
                panHorizontal: 0,
                panVertical: 0,
                bead: null,
                beadType: 'delica',
                beadMatrix: null,
                lastState: null,
                offset: 0,
            }
        },

        mounted() {
            this.canvas = document.getElementById('canvas');
            this.ctx = canvas.getContext('2d');

            //resize the canvas
            this.canvas.width = this.canvas.clientWidth;
            this.canvas.height = this.canvas.clientHeight;

            console.log('add resize listener');
            window.addEventListener('resize', this.onResize)

            this.zoomChild = this.$refs.zoomControl;
            this.drawNewGrid();
        },
        beforeDestroy: function () {
            window.removeEventListener('resize', this.onResize)
        },
        methods: {
            onResize: function () {
                console.log('resize');
                this.beadWidth = 1;
                this.beadHeight = 1;

                this.canvas.width = this.canvas.clientWidth;
                this.canvas.height = this.canvas.clientHeight;
                this.drawNewGrid();

            },
            start: function (event) {
                this.ctx.beginPath();

                this.prevX = this.currX;
                this.prevY = this.currY;

                if (event.ctrlKey) {
                    this.drag = true;
                }
                if (this.beadX > this.gridWidth || this.beadX < 0) {
                    this.drag = true;
                }
                else if (this.beadY > this.gridHeight || this.beadY < 0) {
                    this.drag = true;
                }
                if (!this.drag) {
                    this.lastState = JSON.stringify(this.beadMatrix);
                    this.drawing = true;
                    this.drawBead(this.beadX - 1, this.beadY - 1, this.bead);
                }
            },
            move: function (event) {
                this.currX = event.clientX;
                this.currY = event.clientY;

                if (this.drag) {
                    if (this.zoomChild != null) {
                        this.zoomChild.changePan(this.currX - this.prevX, this.currY - this.prevY);
                        this.prevX = this.currX;
                        this.prevY = this.currY;
                        this.drawNewGrid();
                    }
                } else {

                    let rect = canvas.getBoundingClientRect();

                    this.beadX = (this.currX - (this.leftOffset * this.scaleFactor) - rect.left - ((this.currX - (this.leftOffset * this.scaleFactor) - rect.left) % (this.beadWidth * this.scaleFactor))) / (this.beadWidth * this.scaleFactor) + 1;
                    this.beadY = (this.currY - (this.topOffset * this.scaleFactor) - rect.top - ((this.currY - (this.topOffset * this.scaleFactor) - rect.top) % (this.beadHeight * this.scaleFactor))) / (this.beadHeight * this.scaleFactor) + 1;

                    if (this.beadX <= 0 || this.beadX > this.gridWidth || this.beadY <= 0 || this.beadY > this.gridHeight) {
                        this.beadX = '';
                        this.beadY = '';
                        return;
                    }
                    if (this.drawing) {
                        this.drawBead(this.beadX - 1, this.beadY - 1, this.bead);
                    }
                }
            },
            finishMove: function (event) {
                this.drawing = false;
                this.drag = false;
            },
            drawBead: function (beadX, beadY, bead) {
                this.ctx.fillStyle = bead.color;
                if (beadX === '' || beadY === '')
                    return;
                if (beadX < 0 || beadX >= this.gridWidth || beadY < 0 || beadY >= this.gridHeight)
                    return;

                let boxX = (this.leftOffset) + ((beadX) * this.beadWidth) + 1;
                let boxY = (this.topOffset) + ((beadY) * this.beadHeight) + 1;
                this.ctx.fillRect(boxX, boxY, this.beadWidth - 2, this.beadHeight - 2);
                this.beadMatrix[beadX][beadY] = bead;
            },
            handleScroll: function (event) {
                this.zoomChild.handleScroll(event);
            },
            clear: function () {
                this.beadMatrix = null;
                this.zoomChild.resetZoom();
                this.drawNewGrid();
            },
            save: function () {
                axios.post('/pattern/save', {
                    'height': this.gridHeight,
                    'width': this.gridWidth,
                    'bead_type': this.beadType,
                    'jsonPattern': this.beadMatrix
                })
                    .then(function (response) {
                        console.log(response)
                    }).catch(function (response) {
                    console.log('catch');
                });
            },
            undo: function () {
                this.beadMatrix = JSON.parse(this.lastState);
                this.drawNewGrid();
            },
            rotateLeft: function () {
                this.lastState = JSON.stringify(this.beadMatrix);
                let oldMatrix = this.beadMatrix;

                this.beadMatrix = new Array(this.gridHeight);
                for (let i = 0; i < this.gridHeight; i++) {
                    this.beadMatrix[i] = new Array(this.gridWidth);
                }

                if (oldMatrix) {
                    //go through our previous bead matrix, and draw out the beads stored there
                    for (let width = 0; width < this.gridWidth; width++) {
                        for (let height = 0; height < this.gridHeight; height++) {
                            if (oldMatrix[this.gridWidth - width]) {
                                this.beadMatrix[height][width] = oldMatrix[this.gridWidth - width][height];
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
                this.lastState = JSON.stringify(this.beadMatrix);
                let oldMatrix = this.beadMatrix;

                this.beadMatrix = new Array(this.gridHeight);
                for (let i = 0; i < this.gridHeight; i++) {
                    this.beadMatrix[i] = new Array(this.gridWidth);
                }

                if (oldMatrix) {
                    //go through our previous bead matrix, and draw out the beads stored there
                    for (let width = 0; width < this.gridWidth; width++) {
                        for (let height = 0; height < this.gridHeight; height++) {
                            if (oldMatrix[width]) {
                                this.beadMatrix[height][width] = oldMatrix[width][this.gridHeight - height];
                            }
                        }
                    }
                }

                let oldHeight = this.gridHeight;
                this.gridHeight = this.gridWidth;
                this.gridWidth = oldHeight;

                this.drawNewGrid();
            },

            /**
             * After any change to the pattern, simply erase it and draw a new one from the grid.
             * This destroys all current data on the canvas and redraws a new one with new values.
             */
            drawNewGrid: function () {
                this.ctx.setTransform(1, 0, 0, 1, 0, 0);
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                this.ctx.scale(this.scaleFactor, this.scaleFactor);
                this.ctx.beginPath();
                this.ctx.strokeStyle = 'black';

                //calculate bead size
                let widthOffset;
                let heightOffset;
                if ((this.gridWidth * this.canvas.height * this.beadAspect) < this.gridHeight * this.canvas.width) {
                    //height is larger
                    heightOffset = ((this.canvas.height / this.scaleFactor) % (this.gridHeight)) / 2;
                    this.beadHeight = (this.canvas.height - heightOffset) / this.gridHeight;
                    this.beadWidth = this.beadHeight * this.beadAspect;
                } else {
                    widthOffset = ((this.canvas.width / this.scaleFactor) % (this.gridWidth * this.beadAspect)) / 2;
                    this.beadWidth = (this.canvas.width - widthOffset) / (this.gridWidth * this.beadAspect);
                    this.beadHeight = this.beadWidth / this.beadAspect;
                }
                widthOffset = (this.canvas.width / this.scaleFactor) - (this.gridWidth * this.beadWidth);
                heightOffset = (this.canvas.height / this.scaleFactor) - (this.gridHeight * this.beadHeight);
                this.leftOffset = widthOffset / 2 + this.panHorizontal;
                this.topOffset = heightOffset / 2 + this.panVertical;
                let rightOffset = widthOffset - this.leftOffset;
                let bottomOffset = heightOffset - this.topOffset;

                //draw horizontal lines
                let division = this.topOffset;
                for (let beadCount = 0; beadCount <= (this.gridHeight); beadCount++) {
                    this.ctx.moveTo(this.leftOffset, division);
                    this.ctx.lineTo(this.canvas.width / this.scaleFactor - rightOffset, division);
                    division += this.beadHeight;
                }
                //draw vertical
                division = this.leftOffset;
                for (let beadCount = 0; beadCount <= (this.gridWidth); beadCount++) {
                    this.ctx.moveTo(division, this.topOffset);
                    this.ctx.lineTo(division, this.canvas.height / this.scaleFactor - bottomOffset);
                    division += this.beadWidth;
                }

                let oldMatrix = this.beadMatrix;

                this.beadMatrix = new Array(this.gridWidth);
                for (let i = 0; i < this.gridWidth; i++) {
                    this.beadMatrix[i] = new Array(this.gridHeight);
                }

                if (oldMatrix) {
                    //go through our previous bead matrix, and draw out the beads stored there
                    for (let width = 0; width < this.gridWidth; width++) {
                        for (let height = 0; height < this.gridHeight; height++) {
                            if (oldMatrix[width]) {
                                let setColor = oldMatrix[width][height];
                                if (setColor) {
                                    this.drawBead(width, height, setColor);
                                }
                            }
                        }
                    }
                }
                this.ctx.stroke();
            }
        }
        ,

        watch: {
            gridWidth: function () {
                this.drawNewGrid();
            }
            ,
            gridHeight: function () {
                this.drawNewGrid();
            }
            ,
            panHorizontal: function () {
                this.drawNewGrid();
            }
            ,
            panVertical: function () {
                this.drawNewGrid();
            }
            ,
            scaleFactor: function () {
                this.drawNewGrid();
            }
            ,
            beadType: function () {
                if (this.beadType == 'round') {
                    this.beadAspect = .63;
                } else {
                    this.beadAspect = 1;
                }
                this.drawNewGrid();
            }
        }
    }
</script>
