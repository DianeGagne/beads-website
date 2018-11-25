<template>
</template>
<script>
    import * as _ from "lodash";

    export default {
        props: {
            left: {
                type: Number,
            },
            top: {
                type: Number,
            },
            height: {
                type: Number,
            },
            width: {
                type: Number,
            },
            bead: {
                type: Object,
            },
            canvasProps: {
                type: Object,
            },
        },
        methods: {
            drawBead: function () {
                //todo: throttle or debounce this or something so we arn't triggering a full redraw 6 times when the pattern is zoomed
                if(this.bead.bead && this.bead.bead.color) {
                    let self = this;
                    _.debounce(function(self) {
                        this.canvasProps.ctx.fillStyle = self.bead.bead.color;
                        this.canvasProps.ctx.fillRect(self.left, self.top, self.width, self.height);
                    });
                    this.canvasProps.ctx.stroke();
                }
            },

        },
        watch: {
            left: function() {
                this.drawBead();
            },
            top: function() {
                this.drawBead();
            },
            width: function() {
                this.drawBead();
            },
            height: function() {
                this.drawBead();
            },
            bead: {
                handler: function () {
                    console.log('bead changed');
                    this.drawBead();
                },
                deep: true,
            }
        }
    }

</script>