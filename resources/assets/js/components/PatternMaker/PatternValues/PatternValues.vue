<template>
    <div id="pattern-values">
                <bead-type :patternValues.beadType.sync="beadType"></bead-type>
                <pattern-type :patternValues.patternType.sync="patternType"></pattern-type>
                <pattern-values :patternValues.sync="patternValues"></pattern-values>

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
        methods: {},
        watch: {
            patternValues: {
                handler (patternValues) {
                    this.$emit('update:patternValues', this.patternValues)
                },
                deep: true,
            }
        }
    }
</script>
