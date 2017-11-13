<template>
</template>
<script>
    /**
     * When a brick stitch is selected, using the mouse position and the grid calculated offsets & bead size
     * Calculate the bead index given a set of coordinates
     */
    export default {
        props: {
            displayProps: {
                type: Object,
            },
            beadProps: {
                type: Object,
            },
            canvasProps: {
                type: Object,
            },
            patternSize: {
                type: Object,
            },
            mouseProps: {
                type: Object,
            },
            panZoom: {
                type: Object,
            }
        },
        data: function () {
            return {
                calculated: this.beadProps,
            }
        },
        methods: {
            calculateIndex: function(pixelCount, scaleFactor, canvasEdge, offset, beadSize, maxCount) {
                let pixelsFromPatternEdge = pixelCount - offset - canvasEdge;
                let pixelsFromBeadStart = pixelsFromPatternEdge % beadSize;
                let previousBeadStart = pixelsFromPatternEdge - pixelsFromBeadStart;
                let beadIndex = previousBeadStart / beadSize;

                //Ensure this index is really in the pattern
                if(beadIndex < 0)
                    return null;
                if(beadIndex >= maxCount)
                    return null;

                return Math.round(beadIndex);
            },


            calculateCurrentProps: function() {
                let rect = this.canvasProps.canvas.getBoundingClientRect();
                let scaleFactor = this.panZoom.scaleFactor;
                let display = this.displayProps;
                //given the mouse props calculate the indexes

                this.calculated.xIndex = this.calculateIndex(this.mouseProps.currX, scaleFactor, rect.left, display.leftOffset, display.beadWidth, this.patternSize.width);
                this.calculated.yIndex = this.calculateIndex(this.mouseProps.currY, scaleFactor, rect.top, display.topOffset, display.beadHeight, this.patternSize.height);

                this.$emit('update:beadProps', this.calculated);
            },
        },
        watch: {
            'mouseProps' : {
                handler: function () {
                    this.calculateCurrentProps();
                },
                deep: true,
            },
        },
    }
</script>