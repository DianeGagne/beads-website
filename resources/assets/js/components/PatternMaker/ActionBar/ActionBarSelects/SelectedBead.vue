<template>
    <div id="selected-bead">
        <div class="currentBead">
            <div class="beadDisplay"
                 v-bind:style="{backgroundColor: this.currentBead.color,
                backgroundImage:'url(/assets/delica11/' + this.currentBead.image + '.jpg)',}">
                <div class="hotKey" style="bottom:3px; right:3px;">
                    A
                </div>
            </div>
            <div class="beadDescriptions">
                <br>{{this.beadFinishes}}
                <br>R100 - G234 - B234
                <br>19 (1g)

            </div>
        </div>
    </div>
</template>
<script>
    import SavedPattern from '../../../../StoredData/PatternValues.js';

    export default {
        data: function () {
            return {
                currentBead: SavedPattern.actionBarValues.bead,

                beadName: '',
                beadFinishes: [],
                beadColors: '',
            }
        },
        mounted() {
        },
        methods: {},
    }
</script>

