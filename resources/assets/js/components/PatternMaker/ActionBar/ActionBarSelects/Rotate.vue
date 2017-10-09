<template>
    <div id="rotate">
        <div style="display: flex;">
            <div class="rotate-section">
                <div class="buttons">
                    <button id="rotateLeft" @click="rotateLeft=true" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-repeat glyphicon-flip-horizontal"></span></button>
                    <button id="rotateRight" @click="rotateRight=true" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-repeat" ></span></button>
                    <button id="flipX" @click="flipX=true" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-resize-horizontal"></span></button>
                    <button id="flipY" @click="flipY=true" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-resize-vertical"></span></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                rotations: {
                    rotateLeft: false,
                    rotateRight: false,
                    flipX: false,
                    flipY: false,
                },
            }
        },
        watch: {
            rotations: {
                handler (rotations) {
                    this.$emit('update:rotations', this.rotations)
                },
                deep: true,
            }
        }
    }
</script>
