<template>
    <div class="canvasBlock" id="canvasContainer"
         style="border: 1px solid black; height: 100%"
         @notify="onResize">

        <div v-for="column in columns">
            <div v-for="row in rows">
                <bead
                        :column="column"
                        :row="row"
                        :canvasProps="canvasProps">
                </bead>
            </div>
        </div>

        <canvas
                id="canvas" style="width:100%; height:100%;"
                @mousedown="start"
                @mousemove="move"
                @mouseup="finishMove"
                @mouseout="finishMove"
                @keyup.ctrl="finishMove"
        ></canvas>
    </div>
</template>
<script>

    import ResizeObserver from "../../../../../node_modules/vue-resize/src/components/ResizeObserver.vue";
    import {getInternetExplorerVersion} from '../../../../../node_modules/vue-resize/src/utils/compatibility'

    import {mapState, mapGetters} from 'vuex';

    let isIE;

    function initCompat() {
        if (!initCompat.init) {
            initCompat.init = true;
            isIE = getInternetExplorerVersion() !== -1
        }
    }

    export default {
        components: {ResizeObserver},
        data: function () {
            return {
                //Read only from the pattern
                history: null,
                canvasProps: {
                    canvas: null,
                    ctx: null,
                    canvasReady: false,
                },
                //Keep track of the current & previous mouse position
                mouseProps: {
                    currX: null,
                    currY: null,
                    drawing: false,
                },
            }
        },

        mounted() {
            initCompat();
            this.$nextTick(() => {
                this._w = this.$el.offsetWidth;
                this._h = this.$el.offsetHeight;
            });
            const object = document.createElement('object');
            this._resizeObject = object;
            object.setAttribute('style', 'display: block; top: 0; left: 0; height: 0%; width: 100%; overflow: hidden; pointer-events: none; z-index: -1;');
            object.setAttribute('aria-hidden', 'true');
            object.setAttribute('tabindex', -1);
            object.onload = this.addResizeHandlers;
            object.type = 'text/html';
            if (isIE) {
                this.$el.appendChild(object)
            }
            object.data = 'about:blank';
            if (!isIE) {
                this.$el.appendChild(object)
            }

            this.canvasProps.canvas = document.getElementById('canvas');
            this.canvasProps.ctx = this.canvasProps.canvas.getContext('2d');

            this.$store.commit('pattern/createInitialPattern');

            this.onResize();
        },
        beforeDestroy: function () {
            this.removeResizeHandlers();
            window.removeEventListener('resize', this.onResize());
        },
        computed: {
            ...mapState({
                rows: state => state.pattern.rows,
                columns: state => state.pattern.columns
            }),
            ...mapGetters({
                bead: "pattern/colorAtLocation",
                getFromPixels: "brickPattern/getBeadFromPixels",
                isInPattern: "brickPattern/isLocationInPattern",
                beadToDraw: "currentBead/value",
            }),
            mouseX: function () {
                let offsetLeft = 0;
                if (this.canvasProps.canvas) {
                    offsetLeft = this.canvasProps.canvas.offsetLeft;
                }
                return this.mouseProps.currX - offsetLeft;
            },
            mouseY: function () {
                let offsetTop = 0;
                if (this.canvasProps.canvas) {
                    offsetTop = this.canvasProps.canvas.offsetTop;
                }
                return this.mouseProps.currY - offsetTop;
            }
        },
        methods: {
            /**
             * Changing the size of the canvas
             */
            addResizeHandlers() {
                this._resizeObject.contentDocument.defaultView.addEventListener('resize', this.onResize);
                if (this._w !== this.$el.offsetWidth || this._h !== this.$el.offsetHeight) {
                    this.onResize()
                }
            },
            removeResizeHandlers() {
                if (this._resizeObject && this._resizeObject.onload) {
                    if (!isIE && this._resizeObject.contentDocument) {
                        this._resizeObject.contentDocument.defaultView.removeEventListener('resize', this.onResize);
                    }
                    delete this._resizeObject.onload
                }
            },
            onResize: function () {
                this.canvasProps.canvas.width = this.canvasProps.canvas.clientWidth;
                this.canvasProps.canvas.height = this.canvasProps.canvas.clientHeight;

                    this.$store.commit('brickPattern/setCanvasWidth', this.canvasProps.canvas.clientWidth);
                    this.$store.commit('brickPattern/setCanvasHeight', this.canvasProps.canvas.clientHeight);
            },


            start: function (event) {
                this.canvasProps.ctx.beginPath();

                this.mouseProps.prevX = this.mouseProps.currX;
                this.mouseProps.prevY = this.mouseProps.currY;

                if (event.ctrlKey) {
                    this.drag = true;
                }
                if (!this.drag) {
                    this.lastState = JSON.stringify(this.updatableMatrix);
                    this.mouseProps.drawing = true;
                    // this.mouseProps.currX = event.clientX;
                    // this.mouseProps.currY = event.clientY;
                    this.drawBead();
                }
            },
            move: function (event) {
                if (this.mouseProps.drawing) {
                    this.mouseProps.currX = event.clientX;
                    this.mouseProps.currY = event.clientY;
                    this.drawBead();
                }

                if (this.drag) {
                    if (this.zoomChild != null) {
                        this.zoomChild.changePan(this.currX - this.prevX, this.currY - this.prevY);
                        this.prevX = this.currX;
                        this.prevY = this.currY;
                    }
                }
            },
            finishMove: function (event) {
                this.mouseProps.drawing = false;
                this.mouseProps.drag = false;
            },
            drawBead: function () {
                let location = {'x': this.mouseX, 'y': this.mouseY};
                if (!this.isInPattern(location) || !this.mouseProps.drawing) {
                    return;
                }

                let beadPosition = this.getFromPixels(location);
                let patternUpdateObject = {};
                patternUpdateObject.bead = this.beadToDraw;

                patternUpdateObject.locations = [{x: beadPosition.column, y: beadPosition.row}];

                this.$store.commit('pattern/setBeads', patternUpdateObject);
            },
            // save: function () {
            //     axios.post('/pattern/save', {
            //         'actionBarValues': this.actionBarValues,
            //         'palette': this.beadPalette,
            //         'beadMatrix': this.updatableMatrix,
            //         'patternValues': this.patternValues,
            //     })
            //         .then(function (response) {
            //             console.log(response)
            //         }).catch(function (response) {
            //         console.log('catch');
            //     });
            // },
            // undo: function () {
            //     this.updatableMatrix = JSON.parse(this.lastState);
            //     this.drawNewGrid();
            // },
        },
        watch: {
            // 'mouseRow': {
            //     handler: function () {
            //         this.drawBead();
            //     }
            // },
            // 'mouseColumn': {
            //     handler: function () {
            //         this.drawBead();
            //     }
            // },
//            'beadProps': {
//                handler: function () {
//                    this.drawBead();
//                },
//                deep: true,
//            },
//             'updatableMatrix': {
//                 handler: function () {
//                     this.$emit('update:beadMatrix', this.updatableMatrix);
// //                    this.updatableMatrix = this.beadMatrix;
//                 },
//                 deep: true,
//             },
//
//             'SavedPattern.updateCanvas': {
//                 handler: function () {
//                     //  console.log('on resize called');
//                     // this.onResize();
//                 }
//             }
        }
    }
</script>
