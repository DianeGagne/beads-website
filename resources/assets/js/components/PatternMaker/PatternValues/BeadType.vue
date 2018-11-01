<template>
    <div id="bead-type">
        <label>Bead type</label>
        <div v-for="type in types">
            <input type="radio"
                   :value=type.name
                   v-model="selected">
            {{type.displayName}}
        </div>
    </div>
</template>
<script>
    import SavedPattern from '../../../StoredData/PatternValues.js';
    export default {
        data: function () {
            return {
                selected: SavedPattern.patternValues.beadType.name,
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
                SavedPattern.patternValues.beadType = this.types[this.selected];
            }
        }
    }
</script>
