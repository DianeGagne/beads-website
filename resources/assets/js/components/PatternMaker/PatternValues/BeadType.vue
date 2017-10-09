<template>
    <div class="bead-type">
        <div class="radio">
            <label><input type="radio" id="delica" value="delica" v-model="beadType">Delica</label>
        </div>
        <div class="radio">
            <label><input type="radio" id="round" value="round" v-model="beadType">Round (Czech)</label>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                beadType: 'Delica',
            }
        },
        mounted() {
        },
        methods: {
        },
        watch: {
            beadType: {
                handler (size) {
                    this.$emit('update:beadType', this.beadType)
                },
            }
        }
    }
</script>
