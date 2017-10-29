<template>
    <div id="bead-type">
        <label>Bead type</label>
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
            beadType: {
                type: Object,
            },
        },
        data: function () {
            return {
                selected: this.beadType.name,
                selectedType: this.beadType,
                types: {
                    delica: {
                        beadAspect: 1, // The number to multiple the width to get the height
                        name: 'delica',
                        displayName: 'Delica',
                        beadWidth: 1.96,
                        beadHeight: 1.96,
                        beadWeight: .030,
                    },
                    round: {
                        beadAspect: .6,
                        name: 'round',
                        displayName : 'Czech Round',
                        beadWidth: 1.54,
                        beadHeight: 2.03,
                        beadWeight: .032,
                    },
                },
            }
        },
        methods: {
            changedType: function () {
                this.$emit('update:beadType', this.types[this.selectedType])
            }
        }
    }
</script>
