<template>
    <div id="new-pattern">
        <button @click="createNew" class="btn-default">New Pattern</button>
        <modal name="new-pattern"
               :resizable="true"
               :scrollable="true"
               :draggable="true"
               :adaptive="true"
               :reset="true"
               :height="600"
               :clickToClose="false"
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
                <pattern-size :patternSize.sync="patternValues.patternSize" :beadType="patternValues.beadType"></pattern-size>

                <hr>
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li><a href="#background-image" data-toggle="tab">From Image</a></li>
                        <li><a href="#background-bead" data-toggle="tab">Background Bead</a></li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane login-tab" id="background-image">
                        <input type="file">
                    </div>
                    <div class="tab-pane login-tab" id="background-bead">
                        <color-section></color-section>
                    </div>
                </div>


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
                type: Object,
            },
            palette: {
                type: Object,
            },
        },
        data: function () {
            return {
                patternValues: this.patternValues,
                beadMatrix: this.beadMatrix,
                palette: this.palette,
            }
        },
        created: function () {
        },
        mounted() {
        },
        methods: {
            createNew: function () {
                this.$modal.show('new-pattern');
            },
            createPattern: function () {
                this.$emit('update:patternValues');
               // this.$emit('update:beadMatrix');
               // this.$emit('update:palette');
                this.$modal.hide('new-pattern');
            }
        },

    }
</script>
