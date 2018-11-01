<template>
    <div id="pattern-size">
        <label>Size</label>
        <div style="display: flex;">
            <div style="width: 100px">
                <input type="number" id="beadsWidth" class="form-control" v-model="patternSize.width">
            </div>
            <div style="width: 100px">
                <input type="number" id="beadsHeight" class="form-control" v-model="patternSize.height">
            </div>
        </div>
        <div class="size-descriptions">
            <div class="counts">
            {{this.totalHeight}}x{{this.totalWidth}} cm
            </div>
            <div class="totals">
            {{this.totalBeads}} beads ({{this.totalWeight}}g)
            </div>
        </div>
    </div>
</template>
<script>
    import SavedPattern from '../../../StoredData/PatternValues.js';
    export default {
        data: function () {
            return {
                patternSize: SavedPattern.patternValues.patternSize,
                beadType: SavedPattern.patternValues.beadType,
                totalHeight: 0,
                totalWidth: 0,
                totalBeads: 0,
                totalWeight: 0,
            }
        },
        created: function () {
            this.updateCalcValues();
        },
        methods: {
            updateCalcValues: function () {
                this.totalHeight = Math.round(this.patternSize.height * this.beadType.beadHeight)/10;
                this.totalWidth = Math.round(this.patternSize.width * this.beadType.beadWidth)/10;
                this.totalBeads = this.patternSize.height * this.patternSize.width;
                this.totalWeight = Math.ceil(this.totalBeads * this.beadType.beadWeight);
            }
        },
        watch: {
            patternSize: {
                handler () {
                    this.updateCalcValues();
                    this.$emit('update:patternSize', this.patternSize)
                },
                deep: true,
            },
            beadType: {
                handler () {
                    this.updateCalcValues();
                },
                deep: true,
            }

        }
    }

</script>
