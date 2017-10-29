<template>
    <div id="rotate">
        <div style="display: flex;">
            <div class="rotate-section">
                <div class="buttons">
                    <button id="rotateLeft" @click="triggerRotation.rotateLeft=true" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-repeat glyphicon-flip-horizontal"></span></button>
                    <button id="rotateRight" @click="triggerRotation.rotateRight=true" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-repeat" ></span></button>
                    <button id="flipX" @click="triggerRotation.flipX=true" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-resize-horizontal"></span></button>
                    <button id="flipY" @click="triggerRotation.flipY=true" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-resize-vertical"></span></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            rotations: {
                type: Object,
            },
        },
        data: function () {
            return {
                triggerRotation: this.rotations,
            }
        },
        watch: {
            triggerRotation: {
                handler (rotations) {
                    this.$emit('update:rotations', this.triggerRotation)
                },
                deep: true,
            }
        }
    }
</script>
