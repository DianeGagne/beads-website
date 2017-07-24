<template>
        <div id="zoom-picker">
            <div style="display: flex;">
                <button id="zoom-in" @click="zoomIn"><span class="glyphicon glyphicon-zoom-in"></span></button>
                <button id="zoom-out" @click="zoomOut"><span class="glyphicon glyphicon-zoom-out"></span></button>
                {{scaleFactor}}
                <br>
                <button id="pan-left" @click="panLeft"><span class="glyphicon glyphicon-arrow-left"></span></button>
                <button id="pan-right" @click="panRight"><span class="glyphicon glyphicon-arrow-right"></span></button>
                {{panHorizontal}}
                <br>
                <button id="pan-up" @click="panUp"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button id="pan-down" @click="panDown"><span class="glyphicon glyphicon-arrow-down"></span></button>
                {{panVertical}}
                <br>
                <button id="resetZoom" @click="resetZoom">Reset Zoom</button>
            </div>
        </div>
</template>
<script>
    export default {
        data: function () {
            return {
                scaleFactor: 1,
                panHorizontal: 0,
                panVertical: 0,
            }
        },
        created: function () {
            var vm = this;
            window.addEventListener('keydown', function(event){
                if(event.keyCode === 40){
                    vm.panDown();
                }
                if(event.keyCode === 38){
                    vm.panUp();
                }
                if(event.keyCode === 37){
                    vm.panLeft();
                }
                if(event.keyCode === 39){
                    vm.panRight();
                }
                if(event.keyCode === 32){
                    vm.resetZoom();
                }
                if(event.keyCode === 187){
                    vm.zoomIn();
                }
                if(event.keyCode === 189){
                    vm.zoomOut();
                }
            });
        },
        mounted() {
        },
        methods: {
            zoomIn: function () {
                this.scaleFactor += .25;
                this.$emit('update:scaleFactor', this.scaleFactor);
            },
            zoomOut: function () {
                if(!this.scaleFactor == 0) {
                    this.scaleFactor -= .25;
                    this.$emit('update:scaleFactor', this.scaleFactor);
                }
            },
            panLeft: function () {
                this.panHorizontal -= 25;
                this.$emit('update:panHorizontal', this.panHorizontal);
            },
            panRight: function () {
                this.panHorizontal += 25;
                this.$emit('update:panHorizontal', this.panHorizontal);
            },
            panUp: function () {
                this.panVertical -= 25;
                this.$emit('update:panVertical', this.panVertical);
            },
            panDown: function () {
                this.panVertical += 25;
                this.$emit('update:panVertical', this.panVertical);
            },
            changePan: function (horizontalChange, verticalChange) {
                this.panHorizontal += horizontalChange;
                this.panVertical += verticalChange;
                this.$emit('update:panHorizontal', this.panHorizontal);
                this.$emit('update:panVertical', this.panVertical);
            },
            resetZoom: function () {
                this.scaleFactor = 1;
                this.panHorizontal = 0;
                this.panVertical = 0;
                this.$emit('update:scaleFactor', this.scaleFactor);
                this.$emit('update:panHorizontal', this.panHorizontal);
                this.$emit('update:panVertical', this.panVertical);
            },
            handleScroll: function (event) {
                if (event.deltaY > 0)
                    this.zoomOut();
                else
                    this.zoomIn();
            },
        }
    }
</script>
