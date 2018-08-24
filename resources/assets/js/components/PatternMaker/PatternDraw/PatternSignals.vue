<!--suppress JSSuspiciousNameCombination -->
<template>
</template>
<script>
    /**
     * When a brick stitch is selected, and a rotation is chosen, calculate the new beadMatrix and trigger a re-draw
     */
    export default {
        props: {
            updatableMatrix: {
                type: Array,
            },
            patternSize: {
                type: Object,
            },
            signals: {
                type: Object,
            }
        },
        data: function () {
            return {
//                transformedMatrix: this.updatableMatrix,
                oldSize: this.patternSize,
                newSize: this.patternSize,
            }
        },
        methods: {
            rotateLeft: function() {
                console.log('rotate left');
                this.newSize.width = this.oldSize.height;
                this.newSize.height = this.oldSize.width;

                this.transformedMatrix = [];
                for(let i = 0; i<this.newSize.width; i++){
                    this.transformedMatrix[i] = [];
                    for(let j = 0; j < this.newSize.height; j++){
                        this.transformedMatrix[i][j] = this.updatableMatrix[i][j];
                        this.transformedMatrix[i][j].bead = this.updatableMatrix[j][i].bead;
                    }
                }

                this.signals.rotations.rotateLeft = false;
            },

            rotateRight: function() {
                this.createdBeadMatrix = [];
                for(let i = 0; i<this.patternValues.patternSize.width; i++){
                    this.createdBeadMatrix[i] = [];
                    for(let j = 0; j < this.patternValues.patternSize.height; j++){
                        this.createdBeadMatrix[i][j] = {};
                    }
                }
            },
            flipX: function() {
                this.transformedMatrix = [];
                console.log(this.oldSize);
                console.log(this.updatableMatrix);
                for(let i = 0; i<this.oldSize.width; i++){
                    this.transformedMatrix[i] = [];
                    for(let j = 0; j < this.oldSize.height; j++){
                        this.transformedMatrix[i][j] = {};
                        this.transformedMatrix[i][j].topBound = this.updatableMatrix[i][j].topBound;
                        this.transformedMatrix[i][j].bottomBound = this.updatableMatrix[i][j].bottomBound;
                        this.transformedMatrix[i][j].leftBound = this.updatableMatrix[i][j].leftBound;
                        this.transformedMatrix[i][j].rightBound = this.updatableMatrix[i][j].rightBound;
                        this.transformedMatrix[i][j].bead = this.updatableMatrix[this.oldSize.width -  1 - i][j].bead;
                    }
                }
                this.signals.rotations.flipX = false;
            },
            flipY: function() {
                this.transformedMatrix = [];
                for(let i = 0; i<this.oldSize.width; i++){
                    this.transformedMatrix[i] = [];
                    for(let j = 0; j < this.oldSize.height; j++){
                        this.transformedMatrix[i][j] = {};
                        this.transformedMatrix[i][j].topBound = this.updatableMatrix[i][j].topBound;
                        this.transformedMatrix[i][j].bottomBound = this.updatableMatrix[i][j].bottomBound;
                        this.transformedMatrix[i][j].leftBound = this.updatableMatrix[i][j].leftBound;
                        this.transformedMatrix[i][j].rightBound = this.updatableMatrix[i][j].rightBound;
                        this.transformedMatrix[i][j].bead = this.updatableMatrix[i][this.oldSize.height - 1 - j].bead;
                    }
                }
                this.signals.rotations.flipY = false;
            },
        },
        watch: {
            'signals.rotations' : {
                handler: function () {
                    console.log('saw signals rotations update');
                    console.log(this.signals);
                    if(this.signals.rotations.rotateLeft){
                        console.log('calling rotate left');
                        this.rotateLeft()
                        this.signals.redraw = true;
                        this.$emit('update:updatableMatrix', this.transformedMatrix);
                        this.$emit('update:patternSize', this.newSize);
                        this.$emit('update:signals', this.signals);
                    }
                    if(this.signals.rotations.rotateRight){
                        this.rotateRight();
                        this.signals.redraw = true;
                        this.$emit('update:updatableMatrix', this.transformedMatrix);
                        this.$emit('update:patternSize', this.newSize);
                        this.$emit('update:signals', this.signals);
                    }
                    if(this.signals.rotations.flipX){
                        this.flipX();
                        console.log('flipX');
                        this.signals.redraw = true;
                        this.$emit('update:updatableMatrix', this.transformedMatrix);
                        this.$emit('update:patternSize', this.newSize);
                        this.$emit('update:signals', this.signals);
                    }
                    if(this.signals.rotations.flipY){
                        this.flipY();
                        console.log('flipY');
                        this.signals.redraw = true;
                        this.$emit('update:updatableMatrix', this.transformedMatrix);
                        this.$emit('update:patternSize', this.newSize);
                        this.$emit('update:signals', this.signals);
                    }

                    console.log('after rotate - returning');


                },
                deep: true,
            },
        },
    }
</script>