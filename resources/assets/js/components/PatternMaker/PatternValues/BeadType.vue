<template>
    <div id="bead-type">
        <label>Bead type</label>
        <select v-model="beadType">
        <option v-for="type in types" v-bind:value="type.name">
            {{type.displayName}}
        </option>
        </select>
    </div>
</template>
<script>
    export default {
        computed: {
            beadType: {
                get() {
                    return this.$store.state.brickPattern.beadType;
                },
                set(value) {
                    this.$store.commit('brickPattern/setBeadType', value);
                    // this.$store.commit('brickPattern.setBeadType', value);
                }
            }
        },
        data: function () {
            return {
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
    }
</script>
