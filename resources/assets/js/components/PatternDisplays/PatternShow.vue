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
            patternInfo: {
                default: {
                    width: 7,
                    height: 7,
                    beadMatrix: null,
                }
            },
            canvasName: {default: 'canvas'},
            canvasWidth: {default: "100%"},
            canvasHeight: {default: "100%"},
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
                color: 'black',
                beadType: 'delica',
            }
        },

        mounted() {
            this.canvas = document.getElementById(this.canvasName);
            this.ctx = this.canvas.getContext('2d');
            this.patternInfo.beadMatrix = JSON.parse(this.patternInfo.beadMatrix);


            this.drawNewGrid();
        },
        methods: {
            drawBead: function (beadX, beadY, color) {
                this.ctx.fillStyle = color;
                if (beadX === '' || beadY === '')
                    return;
                if (beadX < 0 || beadX >= this.patternInfo.width || beadY < 0 || beadY >= this.patternInfo.height)
                    return;

                let boxX = (this.leftOffset) + ((beadX) * this.beadWidth) + 1;
                let boxY = (this.topOffset) + ((beadY) * this.beadHeight) + 1;
                this.ctx.fillRect(boxX, boxY, this.beadWidth - 2, this.beadHeight - 2);
            },

            drawNewGrid: function () {
                this.ctx.setTransform(1, 0, 0, 1, 0, 0);
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                this.ctx.scale(this.scaleFactor, this.scaleFactor);
                this.ctx.beginPath();
                this.ctx.strokeStyle = 'black';
                console.log('begin drawing grid');

                //calculate bead size
                let widthOffset;
                let heightOffset;
                if ((this.patternInfo.width * this.beadAspect) < this.patternInfo.height) {
                    //height is larger
                    heightOffset = ((this.canvas.height / this.scaleFactor) % (this.patternInfo.height)) / 2;
                    this.beadHeight = (this.canvas.height - heightOffset) / this.patternInfo.height;
                    this.beadWidth = this.beadHeight * this.beadAspect;
                } else {
                    widthOffset = ((this.canvas.width / this.scaleFactor) % (this.patternInfo.width * this.beadAspect)) / 2;
                    this.beadWidth = (this.canvas.width - widthOffset) / (this.patternInfo.width * this.beadAspect);
                    this.beadHeight = this.beadWidth / this.beadAspect;
                }
                widthOffset = (this.canvas.width / this.scaleFactor) - (this.patternInfo.width * this.beadWidth);
                heightOffset = (this.canvas.height / this.scaleFactor) - (this.patternInfo.height * this.beadHeight);
                this.leftOffset = widthOffset / 2 + this.panHorizontal;
                this.topOffset = heightOffset / 2 + this.panVertical;
                let rightOffset = widthOffset - this.leftOffset;
                let bottomOffset = heightOffset - this.topOffset;

                //draw horizontal lines
                let division = this.topOffset;
                for (let beadCount = 0; beadCount <= (this.patternInfo.height); beadCount++) {
                    this.ctx.moveTo(this.leftOffset, division);
                    this.ctx.lineTo(this.canvas.width / this.scaleFactor - rightOffset, division);
                    division += this.beadHeight;
                }
                //draw vertical
                division = this.leftOffset;
                for (let beadCount = 0; beadCount <= (this.patternInfo.width); beadCount++) {
                    this.ctx.moveTo(division, this.topOffset);
                    this.ctx.lineTo(division, this.canvas.height / this.scaleFactor - bottomOffset);
                    division += this.beadWidth;
                }

                if (this.patternInfo.beadMatrix) {
                    //go through our previous bead matrix, and draw out the beads stored there
                    for (let width = 0; width < this.patternInfo.width; width++) {
                        for (let height = 0; height < this.patternInfo.height; height++) {
                            if (this.patternInfo.beadMatrix[width]) {
                                let setColor = this.patternInfo.beadMatrix[width][height];
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
            "patternInfo.height": function () {
                // this.drawNewGrid();
            },
            canvasHeight: function () {
                let self = this;
                //use a callback because this is called before the DOM redraws the canvas with the new width/height
                setTimeout(
                    function () {
                        self.drawNewGrid()
                    }, 30);
            }

        }
    }
</script>
