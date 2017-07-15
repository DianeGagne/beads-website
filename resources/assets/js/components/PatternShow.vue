<template>
    <div class="container">
        <div id="patternShow">
            <div style="display: flex;">
                <canvas
                        :id=canvasName
                        :height=canvasHeight :width=canvasWidth style="border: 1px solid black;"
                ></canvas>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            canvasName: {default: 'canvas'},
            gridWidth: {default: '8'},
            gridHeight: {default: '8'},
            beadMatrix: {default: null}
        },
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
                leftOffset: 0,
                topOffset: 0,
                beadWidth: 20,
                beadHeight: 20,
                beadAspect: 1,
                zoomChild: null,
                scaleFactor: 1,
                panHorizontal: 0,
                panVertical: 0,
                canvasWidth: 300,
                canvasHeight: 300,
                color: 'black',
                beadType: 'delica',
            }
        },

        mounted() {
            this.canvas = document.getElementById(this.canvasName);
            this.ctx = this.canvas.getContext('2d');
            this.beadMatrix = JSON.parse(this.beadMatrix);

            this.drawNewGrid();
        },
        methods: {
            drawBead: function (beadX, beadY, color) {
                this.ctx.fillStyle = color;
                if (beadX === '' || beadY === '')
                    return;
                if (beadX < 0 || beadX >= this.gridWidth || beadY < 0 || beadY >= this.gridHeight)
                    return;

                let boxX = (this.leftOffset) + ((beadX) * this.beadWidth) + 1;
                let boxY = (this.topOffset) + ((beadY) * this.beadHeight) + 1;
                this.ctx.fillRect(boxX, boxY, this.beadWidth - 2, this.beadHeight - 2);
            },

            drawNewGrid: function () {
                console.log('draw new grid');
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

                console.log('lines drawn');
                if (this.beadMatrix) {
                    //go through our previous bead matrix, and draw out the beads stored there
                    for (let width = 0; width < this.gridWidth; width++) {
                        for (let height = 0; height < this.gridHeight; height++) {
                            if (this.beadMatrix[width]) {
                                let setColor = this.beadMatrix[width][height];
                                if (setColor) {
                                    this.drawBead(width, height, setColor);
                                }
                            }
                        }
                    }
                }
                console.log('stroke');
                this.ctx.stroke();
            },
        },
        watch: {
            beadMatrix: function () {
                this.drawNewGrid();
            }

        }
    }
</script>
