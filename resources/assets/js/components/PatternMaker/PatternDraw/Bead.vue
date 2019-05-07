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
                canvasWidth: "brickPattern/canvasWidth"
            }),
            canvasSize: function() {
                return CanvasLocations.rowHeight * CanvasLocations.rowStarts * CanvasLocations.columnWidth * CanvasLocations.columnStarts;
            },
            location: function() {
                return {'x': this.column, 'y': this.row};
            }
        },
        methods: {
            drawBead: function () {
                let left = CanvasLocations.columnStarts[this.column -1];
                let top = CanvasLocations.rowStarts[this.row -1];
                let height = CanvasLocations.rowHeight;
                let width = CanvasLocations.columnWidth;

                this.canvasProps.ctx.fillStyle = this.bead(location);
                this.canvasProps.ctx.strokeStyle = '#990000';
                this.canvasProps.ctx.fillRect(left, top, width, height);
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