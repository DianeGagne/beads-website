<template>
    <div id="pattern-name">
        <label>Pattern Name</label>
        <input id="new-name" type="text" class="form-control"
               v-model="patternName">
    </div>
</template>
<script>
    import SavedPattern from '../../../StoredData/PatternValues.js';
    export default {
        data: function () {
            return {
                name: SavedPattern.patternValues.patternName,
            }
        },
        mounted() {
        },
        methods: {},
        watch: {
            patternName: {
                handler () {
                    SavedPattern.patternValues.patternName = this.name;
                },
            }
        }
    }
</script>
