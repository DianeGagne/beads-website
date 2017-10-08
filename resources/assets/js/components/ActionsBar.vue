<template>
    <div id="actions_bar" v-bind:style="{width: this.menuWidth + 'px'}">
        <div id="resize-action" class="move-bar vertical"
             @mousedown="dragStart">
        </div>
        <div>
            <button @click="close" class="closeButton"><i class="glyphicon glyphicon-arrow-right"></i></button>
            <color-section :bead.sync="bead" :beadMatrix="beadMatrix"></color-section>

            <div class="currentBead" style="height:5%; margin-left:15px; margin-top:5px; margin-bottom:5px; display:flex;">
                <div class="beadDisplay color-image" style="background-color: rgb(38, 37, 42);
                                                    background-image: url(/assets/delica11/db0454.jpg);
                                                    width:40%; padding:3px;">
                <div class="hotKey" style="bottom:3px; right:3px;">
                    A
                </div>
                ></div>
                <div class="beadDescriptions">
                    Delica 0454
                    <br>Metallic, Solid, Lustre
                    <br>R100 - G234 - B234
                    <br>19 (1g)

                </div>
            </div>
        </div>
        <button id="undo" @click="undo"><span
                class="glyphicon glyphicon-share-alt gly-flip-horizontal"></span></button>


        <pan ref="panControl"
             :panHorizontal.sync="panHorizontal"
             :panVertical.sync="panVertical">
        </pan>
        <zoom ref="zoomControl"
              :scaleFactor.sync="scaleFactor">
        </zoom>
    </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                bead: null,
                gridWidth: 20,
                gridHeight: 20,
                beadType: 'delica',
                scaleFactor: 1,
                panHorizontal: 0,
                panVertical: 0,
                beadMatrix: null,
                resize: false,
                menuWidth: 500,
                prevLocation: null,
            }
        },
        mounted() {
        },
        methods: {
            dragStart (event){
                //unless event.defaultPrevented
                //event.preventDefault()
                //let startSize = this.menuWidth;
                //   let startPos = event.clientX
                //if document.body.style.cursor?
                //    @oldCursor = document.body.style.cursor
                //else
                //@oldCursor = null
                //document.body.style.cursor = @style.cursor


                this.resize = true;
                document.addEventListener('mousemove', this.resizeMenu);
                document.addEventListener('mouseup', this.finishResize);
                this.prevLocation = event.clientX;
                //@removeMoveListener = @onDocument("mousemove",@drag)
                //@removeEndListener = @onceDocument("mouseup",@dragEnd)

                //@$emit "resize-start", @size, @
            },
            resizeMenu (event) {

                if (this.resize = true) {
                    let change = this.prevLocation - event.clientX;
                    console.log(change);
                    this.menuWidth = this.menuWidth + change;
                    console.log(this.menuWidth);
                }
                //this.menuWidth = window.innerWidth - event.clientX + 50;
                this.prevLocation = event.clientX;
            },
            finishResize(event){
                document.removeEventListener('mousemove', this.resizeMenu);
                document.removeEventListener('mouseup', this.finishResize);
                //   window.removeMoveListener();
                //   window.removeEndListener();
                this.resize = false;
            },
            close: function () {
                this.menuWidth = 30;
            },
            rotateRight: function () {
                console.log('rotate right');
                //send singnal to rotate? or do the rotate here
            },
            rotateLeft: function () {
                console.log('rotate left');
                //send singnal to rotate? or do the rotate here
            },
            undo: function () {
                console.log('undo');
            },
        },
        watch: {
            bead: function () {
                this.$emit('update:bead', this.bead)
            },
            gridWidth: function () {
                this.$emit('update:gridWidth', this.gridWidth)
            },
            gridHeight: function () {
                this.$emit('update:gridHeight', this.gridHeight)
            },
            beadType: function () {
                this.$emit('update:beadType', this.beadType)
            },
            scaleFactor: function () {
                this.$emit('update:scaleFactor', this.scaleFactor)
            },
            panHorizontal: function () {
                this.$emit('update:panHorizontal', this.panHorizontal)
            },
            panVertical: function () {
                this.$emit('update:panVertical', this.panVertical)
            },
        }
    }
</script>
