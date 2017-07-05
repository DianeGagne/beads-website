<template>
    <div class="container">
        <div id="patternMaker">
            <div style="display: flex;">
                <canvas
                        id="canvas"
                        :height=canvasHeight :width=canvasWidth style="border: 1px solid black;"
                        @mousedown="start"
                        @mousemove="move"
                        @mouseup="drag=false,drawing=false"
                        @mouseout="finishMove"
                        @keyup.ctrl="drag=false"
                        @wheel="handleScroll"
                ></canvas>
                <div style="min-width: 200px; overflow:scroll">
                    <div>
                        {{ (drawing ? 'drawing ' : '') + beadX + ', ' + beadY }}
                    </div>
                    <color-picker :color.sync="color" color="red"></color-picker>
                    <color-picker :color.sync="color" color="orange"></color-picker>
                    <color-picker :color.sync="color" color="yellow"></color-picker>
                    <color-picker :color.sync="color" color="green"></color-picker>
                    <color-picker :color.sync="color" color="blue"></color-picker>
                    <color-picker :color.sync="color" color="purple"></color-picker>
                    <color-picker :color.sync="color" color="black"></color-picker>
                    <color-picker :color.sync="color" color="white"></color-picker>
                    <grid-size :gridWidth.sync="gridWidth" :gridHeight.sync="gridHeight"></grid-size>
                    <div class="radio">
                        <label><input type="radio" id="delica" value="delica" v-model="beadType">Delica</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" id="round" value="round" v-model="beadType">Round (Czech)</label>
                    </div>

                    <button id="clear" @click="clear">Clear</button>
                    <zoom ref="zoomControl" :panHorizontal.sync="panHorizontal" :panVertical.sync="panVertical" :scaleFactor.sync="scaleFactor"></zoom>
                </div>
            </div>
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
                beadWidth: 20,
                beadHeight: 20,
                beadAspect: 1,
                zoomChild: null,
                scaleFactor: 1,
                panHorizontal: 0,
                panVertical: 0,
                canvasWidth: 600,
                canvasHeight: 600,
                color: 'black',
                beadType: 'delica',
                beadMatrix: null,
            }
        },

        mounted() {
            this.canvas = document.getElementById('canvas');
            this.ctx = canvas.getContext('2d');
            this.drawNewGrid();
            this.zoomChild = this.$refs.zoomControl;
        },
        methods: {
            start: function (event) {
                this.drawing = true;

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
                    this.drawBead(this.beadX - 1, this.beadY - 1, this.color);
                }

            },
            move: function (event) {
                this.currX = event.clientX;
                this.currY = event.clientY;

                if (this.drag) {
                    if(this.zoomChild != null) {
                        this.zoomChild.changePan(this.currX - this.prevX, this.currY - this.prevY);
                        this.prevX = this.currX;
                        this.prevY = this.currY;
                        this.drawNewGrid();
                    }
                } else {

                    let rect = canvas.getBoundingClientRect();

                    this.beadX = (this.currX - (this.leftOffset * this.scaleFactor) - rect.left - ((this.currX - (this.leftOffset * this.scaleFactor) - rect.left) % (this.beadWidth * this.scaleFactor))) / (this.beadWidth * this.scaleFactor) + 1;
                    this.beadY = (this.currY - (this.topOffset * this.scaleFactor) - rect.top - ((this.currY - (this.topOffset * this.scaleFactor) - rect.top) % (this.beadHeight * this.scaleFactor))) / (this.beadHeight * this.scaleFactor) + 1;

                    if (this.beadX <= 0 || this.beadX > this.gridWidth || this.beadY <= 0 || this.beadY > this.gridHeight){
                        this.beadX = '';
                        this.beadY = '';
                        return;
                    }

                    if (this.drawing) {
                        this.drawBead(this.beadX - 1, this.beadY - 1, this.color);
                    }
                }
            },
            finishMove: function (event) {
                this.drawing = false;
                this.drag = false;
            },
            drawBead: function (beadX, beadY, color) {
                this.ctx.fillStyle = color;
                if(beadX === '' || beadY === '')
                    return;
                if (beadX < 0 || beadX >= this.gridWidth || beadY < 0 || beadY >= this.gridHeight)
                    return;

                let boxX = (this.leftOffset) + ((beadX) * this.beadWidth) + 1;
                let boxY = (this.topOffset) + ((beadY) * this.beadHeight) + 1;
                this.ctx.fillRect(boxX, boxY, this.beadWidth - 2, this.beadHeight - 2);
                this.beadMatrix[beadX][beadY] = color;
            },
            handleScroll: function(event){
                this.zoomChild.handleScroll(event);
            },
            clear: function () {
                this.beadMatrix = null;
                this.zoomChild.resetZoom();
                this.drawNewGrid();
            },
            drawNewGrid: function () {
                this.ctx.setTransform(1, 0, 0, 1, 0, 0);
                this.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);
                this.ctx.scale(this.scaleFactor, this.scaleFactor);
                this.ctx.beginPath();
                this.ctx.strokeStyle = 'black';

                //calculate bead size
                let widthOffset;
                let heightOffset;
                if ((this.gridWidth * this.beadAspect) < this.gridHeight) {
                    //height is larger
                    heightOffset = ((this.canvasHeight / this.scaleFactor) % (this.gridHeight)) / 2;
                    this.beadHeight = (this.canvasHeight - heightOffset) / this.gridHeight;
                    this.beadWidth = this.beadHeight * this.beadAspect;
                } else {
                    widthOffset = ((this.canvasWidth / this.scaleFactor) % (this.gridWidth * this.beadAspect)) / 2;
                    this.beadWidth = (this.canvasWidth - widthOffset) / (this.gridWidth * this.beadAspect);
                    this.beadHeight = this.beadWidth / this.beadAspect;
                }
                widthOffset = (this.canvasWidth / this.scaleFactor) - (this.gridWidth * this.beadWidth);
                heightOffset = (this.canvasHeight / this.scaleFactor) - (this.gridHeight * this.beadHeight);
                this.leftOffset = widthOffset / 2 + this.panHorizontal;
                this.topOffset = heightOffset / 2 + this.panVertical;
                let rightOffset = widthOffset - this.leftOffset;
                let bottomOffset = heightOffset - this.topOffset;

                //draw horizontal lines
                let division = this.topOffset;
                for (let beadCount = 0; beadCount <= (this.gridHeight); beadCount++) {
                    this.ctx.moveTo(this.leftOffset, division);
                    this.ctx.lineTo(this.canvasWidth / this.scaleFactor - rightOffset, division);
                    division += this.beadHeight;
                }
                //draw vertical
                division = this.leftOffset;
                for (let beadCount = 0; beadCount <= (this.gridWidth); beadCount++) {
                    this.ctx.moveTo(division, this.topOffset);
                    this.ctx.lineTo(division, this.canvasHeight / this.scaleFactor - bottomOffset);
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
        },
        watch: {
            gridWidth: function () {
                this.drawNewGrid();
            },
            gridHeight: function () {
                this.drawNewGrid();
            },
            panHorizontal: function() {
                this.drawNewGrid();
            },
            panVertical: function() {
                this.drawNewGrid();
            },
            scaleFactor: function() {
                this.drawNewGrid();
            },
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
