<template>
    <div id="pan-picker">
            <div class="pan-section" id="pan">
                <div class="buttons">
                    <div id="up">
                        <button id="pan-up" class="btn btn-sm btn-default" @click="panUp"><span class="glyphicon glyphicon-arrow-up"></span></button>
                    </div>
                    <div id="accross">
                        <button id="pan-left" class="btn btn-sm btn-default" @click="panLeft"><span class="glyphicon glyphicon-arrow-left"></span>
                        </button>
                        <button id="pan-center" class="btn btn-sm btn-default" @click="panCenter"><span class="glyphicon glyphicon-record"></span>
                        </button>
                        <button id="pan-right" class="btn btn-sm btn-default" @click="panRight"><span class="glyphicon glyphicon-arrow-right"></span>
                        </button>
                    </div>
                    <div id="down">
                        <button id="pan-down" class="btn btn-sm btn-default" @click="panDown"><span class="glyphicon glyphicon-arrow-down"></span>
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
                panHorizontal: 0,
                panVertical: 0,
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
            panCenter: function () {
                this.panVertical = 0;
                this.panHorizontal = 0;
                this.$emit('update:panVertical', this.panVertical);
                this.$emit('update:panHorizontal', this.panHorizontal);
            },
            changePan: function (horizontalChange, verticalChange) {
                this.panHorizontal += horizontalChange;
                this.panVertical += verticalChange;
                this.$emit('update:panHorizontal', this.panHorizontal);
                this.$emit('update:panVertical', this.panVertical);
            },
    }
</script>
