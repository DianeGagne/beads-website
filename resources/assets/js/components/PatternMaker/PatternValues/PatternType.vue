<template>
    <div id="pattern-type">
        <label>Stitch Type</label>
        <select v-model="patternType">
            <option v-for="type in types" v-bind:value="type.name">
                {{type.displayName}}
            </option>
        </select>
    </div>
</template>
<script>
    export default {
        computed: {
            patternType: {
                get() {
                    return this.$store.state.brickPattern.patternType;
                },
                set(value){
                    this.$store.commit('brickPattern/setPatternType', value);
                }
            }
        },
        data: function () {
            return {
                types: {
                    brick: {
                        name: 'brick',
                        displayName: 'Loom/Brick',
                    },
                    peyote: {
                        name: 'peyote',
                        displayName: 'Peyote',
                    },
                },
            }
        },
    }
</script>
