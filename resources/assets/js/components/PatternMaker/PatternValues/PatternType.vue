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
    import SavedPattern from '../../../StoredData/PatternValues.js';
    export default {
        data: function () {
            return {
                selectedStitchType: SavedPattern.patternValues.stitchType,
                selected: this.selectedStitchType.name,
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
                Event.fire('stitchType', this.types[this.selectedStitchType]);
            }
        },
    }
</script>
