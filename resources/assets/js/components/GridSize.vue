<template>
    <div class="container">
        <div id="color-picker">
            <div style="display: flex;">
                <div style="width: 100px">
                <input title="Width" type="number" value=20 id="beadsWidth" @change="returnWidth">
                </div>
                <div style="width: 100px">
                <input title="Height" type="number" value=20 id="beadsHeight" @change="returnHeight">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                gridWidth: 20,
                gridHeight: 20
            }
        },
        mounted() {
        },
        methods: {
            returnWidth: function (event) {
                this.gridWidth = event.target.value;
                this.$emit('update:gridWidth', this.gridWidth)
            },
            returnHeight: function (event) {
                this.gridHeight = event.target.value;
                this.$emit('update:gridHeight', this.gridHeight)
            }
        }
    }
</script>
