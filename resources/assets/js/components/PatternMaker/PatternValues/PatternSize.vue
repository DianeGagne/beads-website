<template>
        <div id="grid-size">
            <div style="display: flex;">
                <div style="width: 100px">
                <input title="Width" type="number" value=20 id="beadsWidth" v-modal="size.width">
                </div>
                <div style="width: 100px">
                <input title="Height" type="number" value=20 id="beadsHeight" v-modal="size.height">
                </div>
            </div>
            <div class="size-descriptions">
                2x25 cm
                196 beads (8g)
            </div>
        </div>
</template>
<script>
    export default {
        data: function () {
            return {
                patternValues: {
                    beadType: 'delica',
                    patternType: 'brick',
                    size: {
                        height: 20,
                        width: 20,
                    }
                },
            }
        },
        mounted() {
        },
        methods: {
        },
        watch: {
            size: {
                handler (size) {
                    this.$emit('update:size', this.size)
                },
                deep: true,
            }
        }
    }
</script>
