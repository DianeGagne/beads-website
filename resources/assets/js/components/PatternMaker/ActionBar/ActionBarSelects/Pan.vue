<template>
    <div id="pan-picker">
        <div class="pan-section" id="pan">
            <div class="buttons">
                <div id="up">
                    <button id="pan-up" class="btn btn-sm btn-default" @click="panUp"><span
                            class="glyphicon glyphicon-arrow-up"></span></button>
                </div>
                <div id="across">
                    <button id="pan-left" class="btn btn-sm btn-default" @click="panLeft"><span
                            class="glyphicon glyphicon-arrow-left"></span></button>
                    <button id="pan-center" class="btn btn-sm btn-default" @click="panCenter"><span
                            class="glyphicon glyphicon-record"></span></button>
                    <button id="pan-right" class="btn btn-sm btn-default" @click="panRight"><span
                            class="glyphicon glyphicon-arrow-right"></span></button>
                </div>
                <div id="down">
                    <button id="pan-down" class="btn btn-sm btn-default" @click="panDown"><span
                            class="glyphicon glyphicon-arrow-down"></span></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import SavedPattern from '../../../../StoredData/PatternValues.js';
    export default {
        data: function () {
            return {
                panTotals: SavedPattern.actionBarValues.panZoom.pan,
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
                this.panTotals.horizontal -= 25;
                SavedPattern.actionBarValues.panZoom.pan = this.panTotals;
            },
            panRight: function () {
                this.panTotals.horizontal += 25;
                SavedPattern.actionBarValues.panZoom.pan = this.panTotals;
            },
            panUp: function () {
                this.panTotals.vertical -= 25;
                SavedPattern.actionBarValues.panZoom.pan = this.panTotals;
            },
            panDown: function () {
                this.panTotals.vertical += 25;
                SavedPattern.actionBarValues.panZoom.pan = this.panTotals;
            },
            panCenter: function () {
                this.panTotals.vertical = 0;
                this.panTotals.horizontal = 0;
                SavedPattern.actionBarValues.panZoom.pan = this.panTotals;
            },
        },
    }
</script>
