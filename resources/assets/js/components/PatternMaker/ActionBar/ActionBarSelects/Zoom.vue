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
        mounted() {
            let vm = this;
            window.addEventListener('keydown', function (event) {
                if (event.keyCode === 32) {
                    vm.resetZoom();
                }
                if (event.keyCode === 187 || event.keyCode === 107) {
                    vm.zoomIn();
                }
                if (event.keyCode === 189 || event.keyCode === 109) {
                    vm.zoomOut();
                }
            });
            window.addEventListener('mousewheel', function(event){
                if (event.deltaY > 0)
                    vm.zoomOut();
                else
                    vm.zoomIn();

                return false;
            });
        },
        methods: {
            zoomIn: function () {
                this.$store.commit('brickPattern/zoomIn');
            },
            zoomOut: function () {
                this.$store.commit('brickPattern/zoomOut');
            },
            resetZoom: function () {
                this.$store.commit('brickPattern/zoomDefault');
            },

        }
    }
</script>
