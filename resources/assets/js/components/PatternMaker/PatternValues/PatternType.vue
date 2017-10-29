<template>
    <div id="pattern-type">
        <label>Stitch Type</label>
        <div v-for="type in types">
            <input type="radio"
                   :value=type.name
                   v-model="selected"
                   v-on:change="changedType()">
            {{type.displayName}}
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            stitchType: {
                type: Object,
            },
        },
        data: function () {
            return {
                selected: this.stitchType.name,
                types: {
                    brick: {
                        name: 'brick',
                        displayName: 'Loom/Brick',
                    },
                    peyote: {
                        name: 'peyote',
                        displayName : 'Peyote',
                    },
                },
            }
        },
        methods: {
            changedType: function () {
                this.$emit('update:stitchType', this.types[this.selected])
            }
        },
    }
</script>
