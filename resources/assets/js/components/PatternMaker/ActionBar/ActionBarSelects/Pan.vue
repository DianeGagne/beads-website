<template>
    <div id="pan-picker">
            <div class="pan-section" id="pan">
                <div class="buttons">
                    <div id="up">
                        <button id="pan-up" class="btn btn-sm btn-default" @click="panUp"><span class="glyphicon glyphicon-arrow-up"></span></button>
                    </div>
                    <div id="across">
                        <button id="pan-left" class="btn btn-sm btn-default" @click="panLeft"><span class="glyphicon glyphicon-arrow-left"></span></button>
                        <button id="pan-center" class="btn btn-sm btn-default" @click="panCenter"><span class="glyphicon glyphicon-record"></span></button>
                        <button id="pan-right" class="btn btn-sm btn-default" @click="panRight"><span class="glyphicon glyphicon-arrow-right"></span></button>
                    </div>
                    <div id="down">
                        <button id="pan-down" class="btn btn-sm btn-default" @click="panDown"><span class="glyphicon glyphicon-arrow-down"></span></button>
                    </div>
                </div>
            </div>
    </div>
</template>
<script>
    export default {
        props: {
            pan: {
                type: Object,
            },
        },
        data: function () {
            return {
                pan: this.pan,
            }
        },
        created: function () {
            var vm = this;
            window.addEventListener('keydown', function (event) {
                if (event.keyCode === 40) {
                    vm.panDown();
                }
                if (event.keyCode === 38) {
                    vm.panUp();
                }
                if (event.keyCode === 37) {
                    vm.panLeft();
                }
                if (event.keyCode === 39) {
                    vm.panRight(); 
                }
            });
        },
        mounted() {
        },
        methods: {
            panLeft: function () {
                this.pan.horizontal -= 25;
                this.$emit('update:pan', this.pan);
            },
            panRight: function () {
                this.pan.horizontal += 25;
                this.$emit('update:pan', this.pan);
            },
            panUp: function () {
                this.pan.vertical -= 25;
                this.$emit('update:pan', this.pan);
            },
            panDown: function () {
                this.pan.vertical += 25;
                this.$emit('update:pan', this.pan);
            },
            panCenter: function () {
                this.pan.vertical = 0;
                this.pan.horizontal = 0;
                this.$emit('update:pan', this.pan);
            },
        },
    }
</script>
