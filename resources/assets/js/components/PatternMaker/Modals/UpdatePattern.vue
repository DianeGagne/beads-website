<template>
    <div class="modal fade" id="updatePattern" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Pattern</h4>
                </div>
                <div class="modal-body">
                    <label>Pattern Name</label>
                    <input id="new-name" type="text" style="min-width:500px; max-width:100%;"
                           placeholder="Pattern Name">
                    <hr>

                    <pattern-values :patternValues.sync="patternValues"></pattern-values>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </div>
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
