<template>
        <div class="modal fade" id="newPattern" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Pattern</h4>
                    </div>
                    <div class="modal-body">
                        <label>Pattern Name</label>
                        <input id="new-name" type="text" style="min-width:500px; max-width:100%;"
                               placeholder="Pattern Name">
                        <hr>
                        <div class="bead-type">
                            <div class="radio">
                                <label><input type="radio" id="delica" value="delica" v-model="beadType">Delica</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" id="round" value="round" v-model="beadType">Round (Czech)</label>
                            </div>
                        </div>
                        <div class="stitch-type">
                            <div class="radio">
                                <label><input type="radio" id="brick" value="brick">Loom/Brick</label>
                                <label><input type="radio" id="peyote" value="peyote">Peyote</label>
                            </div>
                        </div>
                        <grid-size :gridWidth.sync="gridWidth" :gridHeight.sync="gridHeight"></grid-size>

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
                scaleFactor: 1,
            }
        },
        created: function () {
        },
        mounted() {
        },
        methods: {
        }
    }
</script>
