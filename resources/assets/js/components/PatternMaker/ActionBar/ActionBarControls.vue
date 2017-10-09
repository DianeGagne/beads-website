<template>
    <div id="action-bar-controls">

        <div id="resize-action" class="move-bar vertical"
             @mousedown="dragStart">
        </div>

        <button @click="close" class="closeButton"><i class="glyphicon glyphicon-arrow-right"></i></button>
        <div class="beadDisplay color-image" style="background-color: rgb(38, 37, 42);
                                                    background-image: url(/assets/delica11/db0454.jpg);
                                                    width:45px; height:45px; left:-45px; z-index:100;">
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                //internal variables for controlling the action bar size
                bead: null,
                menuWidth: 500,
                prevLocation: null,
            }
        },
        mounted() {
        },
        methods: {
            dragStart (event){
                this.resize = true;
                document.addEventListener('mousemove', this.resizeMenu);
                document.addEventListener('mouseup', this.finishResize);
                this.prevLocation = event.clientX;
            },
            resizeMenu (event) {

                if (this.resize = true) {
                    let change = this.prevLocation - event.clientX;
                    this.menuWidth = this.menuWidth + change;
                }
                this.prevLocation = event.clientX;
            },
            finishResize(event){
                document.removeEventListener('mousemove', this.resizeMenu);
                document.removeEventListener('mouseup', this.finishResize);
                this.resize = false;
            },
            close: function () {
                this.menuWidth = 30;
            },
        },
        watch: {
            menuWidth: {
                handler (menuWidth) {
                    this.$emit('update:menuWidth', this.menuWidth)
                }
            }
        }
    }
</script>
