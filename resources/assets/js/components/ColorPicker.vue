<template>
    <div class="container">
        <div id="color-picker">
            <div style="display: flex;">
                <div style="width: 100px; height: 30px;" v-bind:style="{backgroundColor: this.color}" @click="returnColor"></div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            color: {default: 'black'}
        },
        data: function () {
            return {
                color: null
            }
        },
        mounted() {
        },
        methods: {
            returnColor: function () {
                this.$emit('update:color', this.color)
            }
        }
    }
</script>
