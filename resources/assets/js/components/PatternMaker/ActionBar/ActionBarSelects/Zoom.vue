<template>
    <div id="zoom-picker">
        <div style="display: flex;">
            <div class="zoom-section" id="zoom">
                <div class="buttons">
                    <button id="zoom-in" class="btn btn-sm btn-default" @click="zoomIn"><span class="glyphicon glyphicon-zoom-in"></span></button>
                    <button id="zoom-out" class="btn btn-sm btn-default" @click="zoomOut"><span class="glyphicon glyphicon-zoom-out"></span></button>
                    <button id="resetZoom" class="btn btn-sm btn-default" @click="resetZoom"><span class="glyphicon glyphicon-fullscreen"></span></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                scaleFactor: 1,
            }
        },
        created: function () {
            var vm = this;
            window.addEventListener('keydown', function (event) {
                if (event.keyCode === 32) {
                    vm.resetZoom();
                }
                if (event.keyCode === 187) {
                    vm.zoomIn();
                }
                if (event.keyCode === 189) {
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
                if (!this.scaleFactor == 0) {
                    this.scaleFactor -= .25;
                    this.$emit('update:scaleFactor', this.scaleFactor);
                }
            },
            resetZoom: function () {
                this.scaleFactor = 1;
                this.$emit('update:scaleFactor', this.scaleFactor);
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
