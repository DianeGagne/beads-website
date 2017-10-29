<template>
    <div id="pattern-name">
        <label>Pattern Name</label>
        <input id="new-name" type="text" class="form-control"
               v-model="patternName">
    </div>
</template>
<script>
    export default {
        props: {
            patternName: {
                type: String,
            },
        },
        data: function () {
            return {
                name: this.patternName,
            }
        },
        mounted() {
        },
        methods: {},
        watch: {
            patternName: {
                handler () {
                    this.$emit('update:patternName', this.name)
                },
            }
        }
    }
</script>
