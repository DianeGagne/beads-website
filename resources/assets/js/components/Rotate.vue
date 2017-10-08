<template>
    <div id="rotate-picker">
        <div style="display: flex;">
            <div class="rotate-section" id="rotate">
                <div class="buttons">
                    <button id="rotate-left" @click="rotateLeft"><span
                            class="glyphicon glyphicon-repeat gly-flip-horizontal"></span></button>
                    <button id="rotate-right" @click="rotateRight"><span class="glyphicon glyphicon-repeat"></span>
                    </button>
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
