<template>
    <div id="new-pattern">
        <button @click="createNew" class="btn-default">New Pattern</button>
        <modal name="new-pattern"
               :resizable="true"
               :scrollable="true"
               :draggable="true"
               :adaptive="true"
               :reset="true"
               :height="auto"
               class="settingsModal">
            <div class="modal-header">
                <h4 class="modal-title">Create New Pattern</h4>
            </div>
            <div class="modal-body">

                <pattern-name :patternName.sync="patternValues.patternName"></pattern-name>

                <hr>
                <div class="selectFunctions">
                    <bead-type :beadType.sync="patternValues.beadType"></bead-type>
                    <pattern-type :stitchType.sync="patternValues.stitchType"></pattern-type>
                </div>

                <hr>
                <pattern-size :patternSize.sync="patternValues.patternSize"
                              :beadType="patternValues.beadType"></pattern-size>

                <hr>

                <input id="upload_file" class="form-control" type="file">
                <label>Max Colors</label>
                <input id="max_colors" class="form_control" type="number">
                <br>

                <div class="previewImage"
                     v-bind:style="{backgroundColor: black,
                backgroundImage:'url(/assets/delica11/db0374.jpg)',}">

                <button class="btn btn-default" @click="preview">Preview</button>

                <div class="modal-footer">
                    <button class="btn btn-primary" @click="createPattern">Create</button>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
    export default {
        props: {
            patternValues: {
                type: Object,
            },
            beadMatrix: {
                type: Array,
            },
            palette: {
                type: Object,
            },
        },
        data: function () {
            return {
                updatedPatternValues: this.patternValues,
                createdBeadMatrix: this.beadMatrix,
                createdPalette: this.palette,
                fileUploadFormData: new FormData(),
            }
        },
        created: function () {
        },
        mounted() {
        },
        methods: {
            preview: function() {

            },
            createNew: function () {
                this.$modal.show('new-pattern');
            },
            createPattern: function () {
                this.createdBeadMatrix = [];
                for (let i = 0; i < this.patternValues.patternSize.width; i++) {
                    this.createdBeadMatrix[i] = [];
                    for (let j = 0; j < this.patternValues.patternSize.height; j++) {
                        this.createdBeadMatrix[i][j] = {};
                    }
                }

                this.$emit('update:patternValues', this.updatedPatternValues);
                this.$emit('update:beadMatrix', this.createdBeadMatrix);
                this.$modal.hide('new-pattern');
            },
        },

    }
</script>
