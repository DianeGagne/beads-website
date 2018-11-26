<template>
    <div id="action-bar-controls">

        <div id="resize-action" class="move-bar vertical"
             @mousedown="dragStart">
        </div>

        <button @click="close" class="closeButton" v-bind:class="{hide: hideBead}"><i
                class="glyphicon glyphicon-arrow-right"></i></button>

        <button @click="open" class="beadDisplayButton" v-bind:class="{hide: !hideBead}"
                v-bind:style="{backgroundColor: this.currentBead.color,
                backgroundImage:'url(/assets/delica11/' + this.currentBead.image + '.jpg)'}">
        </button>
    </div>
</template>
<script>
    import SavedPattern from '../../../StoredData/PatternValues.js';

    export default {
        data: function () {
            return {
                //internal variables for controlling the action bar size
                currentBead: SavedPattern.actionBarValues.bead,
                menuWidth: 0,
                prevLocation: null,
                hideBead: false,
            }
        },
        mounted() {
            SavedPattern.updateCanvas = true;
            this.open();
        },
        methods: {
            dragStart(event) {
                this.resize = true;
                document.addEventListener('mousemove', this.resizeMenu);
                document.addEventListener('mouseup', this.finishResize);
                this.prevLocation = event.clientX;
            },
            resizeMenu(event) {
                if (this.resize = true) {
                    let change = this.prevLocation - event.clientX;
                    this.menuWidth = this.menuWidth + change;
                }

                //toggle between showing the bead image or the smaller close button
                if (this.menuWidth < 50 && this.prevLocation > 50) {
                    this.hideBead = true;
                } else if (this.menuWidth > 50 && this.prevLocation < 50) {
                    this.hideBead = false;
                }
                this.prevLocation = event.clientX;
            },
            finishResize(event) {
                document.removeEventListener('mousemove', this.resizeMenu);
                document.removeEventListener('mouseup', this.finishResize);
                this.resize = false;
            },
            close: function () {
                this.menuWidth = 0;
                this.hideBead = true;
            },
            open: function () {
                this.menuWidth = 500;
                this.hideBead = false;
            },

        },
        watch: {
            menuWidth: {
                handler(menuWidth) {
                    this.$emit('update:menuWidth', this.menuWidth)
                }
            }
        }
    }
</script>
