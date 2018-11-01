<template>
    <div id="rotate">
        <div style="display: flex;">
            <div class="rotate-section">
                <div class="buttons">
                    <button id="undo" @click="undo" class="btn btn-default btn-sm"><span
                            class="glyphicon glyphicon-share-alt"></span></button>
                    <button id="redo" @click="redo" class="btn btn-default btn-sm"><span
                            class="glyphicon glyphicon-share-alt glyphicon-flip-horizontal"></span></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        methods: {
            undo: function() {
                Event.fire('undo');
            },
            redo: function() {
                Event.fire('redo');
            }

        }
    }
</script>
