<template>
</template>
<script>
    import CanvasLocations from '../../../StoredData/CanvasLocations.js';
    import {mapGetters, mapState} from 'vuex';

    export default {
        props: {
            column: {
                type: Number,
            },
            row: {
                type: Number,
            },
            canvasProps: {
                type: Object,
            },
        },
        data: function() {
            return {
            }
        },
        computed: {
            ...mapGetters({
//                bead: state => state.pattern.colorAtLocation({'x': this.column, 'y': this.row})
                bead: "pattern/colorAtLocation",
                canvasWidth: "brickPattern/canvasWidth",
                beadHeight: "brickPattern/beadHeight",
                beadWidth: "brickPattern/beadWidth",
                beadTop: "brickPattern/beadTop",
                beadLeft: "brickPattern/beadLeft"
            }),
            // canvasSize: function() {
            //     return CanvasLocations.rowHeight * CanvasLocations.rowStarts * CanvasLocations.columnWidth * CanvasLocations.columnStarts;
            // },
            location: function() {
                return {'x': this.row, 'y': this.column};
            }
        },
        methods: {
            drawBead: function () {
                let left = this.beadLeft(this.location);
                let top = this.beadTop(this.location);
                let height = this.beadHeight;
                let width = this.beadWidth;

                this.canvasProps.ctx.fillStyle = this.bead(this.location);
                this.canvasProps.ctx.strokeStyle = '#990000';
                this.canvasProps.ctx.lineWidth = 1;
                // this.canvasProps.ctx.strokeRect()
                this.canvasProps.ctx.rect(left, top, width, height);
                this.canvasProps.ctx.stroke();
            },
        },
        watch: {
            canvasWidth: {
                handler: function () {
                    this.drawBead();
                },
            },
            bead: {
                handler: function () {
                    this.drawBead();
                },
                deep: true,
            }
        }
    }

</script>