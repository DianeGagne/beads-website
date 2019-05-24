<template>
    <div id="pan-picker">
        <div class="pan-section" id="pan">
            <div class="buttons">
                <div id="up">
                    <button id="pan-up" class="btn btn-sm btn-default" @click="up"><span
                            class="glyphicon glyphicon-arrow-up"></span></button>
                </div>
                <div id="across">
                    <button id="pan-left" class="btn btn-sm btn-default" @click="left"><span
                            class="glyphicon glyphicon-arrow-left"></span></button>
                    <button id="pan-center" class="btn btn-sm btn-default" @click="center"><span
                            class="glyphicon glyphicon-record"></span></button>
                    <button id="pan-right" class="btn btn-sm btn-default" @click="right"><span
                            class="glyphicon glyphicon-arrow-right"></span></button>
                </div>
                <div id="down">
                    <button id="pan-down" class="btn btn-sm btn-default" @click="down"><span
                            class="glyphicon glyphicon-arrow-down"></span></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        created: function () {
            let vm = this;
            window.addEventListener('keydown', function (event) {
                if (event.keyCode === 40) {
                    vm.down();
                }
                if (event.keyCode === 38) {
                    vm.up();
                }
                if (event.keyCode === 37) {
                    vm.left();
                }
                if (event.keyCode === 39) {
                    vm.right();
                }
            });
        },
        methods: {
            left: function () {
                this.$store.commit('brickPattern/panLeft');
            },
            right: function () {
                this.$store.commit('brickPattern/panRight');
            },
            up: function () {
                this.$store.commit('brickPattern/panUp');
            },
            down: function () {
                this.$store.commit('brickPattern/panDown');
            },
            center: function () {
                this.$store.commit('brickPattern/panCenter');
            },
        },
    }
</script>
