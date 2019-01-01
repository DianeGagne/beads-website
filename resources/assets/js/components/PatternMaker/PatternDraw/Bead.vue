<template>
</template>
<script>
    import CanvasLocations from '../../../StoredData/CanvasLocations.js';

    export default {
        props: {
            column: {
                type: Number,
            },
            row: {
                type: Number,
            },
            bead: {
                type: Object,
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
            canvasSize: function() {
                return CanvasLocations.rowHeight * CanvasLocations.rowStarts * CanvasLocations.columnWidth * CanvasLocations.columnStarts;
            }
        },
        methods: {
            drawBead: function () {
                let left = CanvasLocations.columnStarts[this.column];
                let top = CanvasLocations.rowStarts[this.row];
                let height = CanvasLocations.rowHeight;
                let width = CanvasLocations.columnWidth;

                if (this.bead.bead && this.bead.bead.color) {
                    let self = this;
                    this.canvasProps.ctx.fillStyle = self.bead.bead.color;
                    this.canvasProps.ctx.fillRect(left, top, width, height);
                    this.canvasProps.ctx.stroke();
                }
            },

        },
        watch: {
            canvasSize: {
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