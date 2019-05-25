<template>
    <div id="rotate">
        <div style="display: flex;">
            <div class="rotate-section">
                <div class="buttons">
                    <button id="rotateLeft" @click="rotateLeft" class="btn btn-default btn-sm"><span
                            class="glyphicon glyphicon-repeat glyphicon-flip-horizontal"></span></button>
                    <button id="rotateRight" @click="rotateRight" class="btn btn-default btn-sm"><span
                            class="glyphicon glyphicon-repeat"></span></button>
                    <button id="flipX" @click="flipX" class="btn btn-default btn-sm"><span
                            class="glyphicon glyphicon-resize-horizontal"></span></button>
                    <button id="flipY" @click="flipY" class="btn btn-default btn-sm"><span
                            class="glyphicon glyphicon-resize-vertical"></span></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        methods: {
            rotateLeft: function () {
                this.$store.commit('pattern/rotateLeft');
            },
            rotateRight: function () {
                this.$store.commit('pattern/rotateRight');
            },
            flipX: function () {
                this.$store.commit('pattern/flipX');
            },
            flipY: function () {
                this.$store.commit('pattern/flipY');
            },
        },
    }
</script>
