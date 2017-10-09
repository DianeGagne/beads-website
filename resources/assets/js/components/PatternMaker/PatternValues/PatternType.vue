<template>
    <div class="pattern-type">
        <div class="radio">
            <label><input type="radio" id="brick" value="brick"  v-model="patternType">Loom/Brick</label>
            <label><input type="radio" id="peyote" value="peyote"  v-model="patternType">Peyote</label>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                patternType: 'brick',
            }
        },
        mounted() {
        },
        methods: {
        },
        watch: {
            size: {
                handler (patternType) {
                    this.$emit('update:patternType', this.patternType)
                }
            }
        }
    }
</script>
