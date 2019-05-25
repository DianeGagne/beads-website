<script>
    import {mapGetters, mapState} from 'vuex';

    export default {
        props: {
            canvasProps: {
                type: Object,
            },
        },

        computed: {
            ...mapGetters({
                beadHeight: "brickPattern/beadHeight",
                beadWidth: "brickPattern/beadWidth",
                beadTop: "brickPattern/beadTop",
                beadLeft: "brickPattern/beadLeft",
            }),
            ...mapState({
                rows: state => state.pattern.rows,
                columns: state => state.pattern.columns,
                pattern: state => state.pattern.beadMatrix,
                updatedBeads: state => state.pattern.updatedLocations,
                canvasWidth: state => state.brickPattern.canvasWidth,
                canvasHeight: state => state.brickPattern.canvasHeight,
            }),
            color: function (location) {
                return this.bead(location);
            },
        },
        render() {
            //ensure the canvas is clear first
            if (this.canvasProps.ctx) {
                this.canvasProps.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);

                let column;
                let row;
                let pattern = this.pattern;
                for (column = 0; column < this.columns; column++) {
                    for (row = 0; row < this.rows; row++) {

                        let location = {'x': column, 'y': row};
                        let left = this.beadLeft(location);
                        let top = this.beadTop(location);
                        let height = this.beadHeight;
                        let width = this.beadWidth;

                        this.canvasProps.ctx.fillStyle = pattern[column][row].color;
                        // this.canvasProps.ctx.fillStyle = '#999999';
                        // this.canvasProps.ctx.strokeStyle = '#333333';
                        // this.canvasProps.ctx.lineWidth = 1;
                        // this.canvasProps.ctx.strokeRect()
                        // this.canvasProps.ctx.rect(left, top, width, height);
                        this.canvasProps.ctx.fillRect(left, top, width, height);
                    }
                }
                this.canvasProps.ctx.stroke();
            }
        },
        watch: {
            updatedBeads: function () {
                let allUpdates = this.updatedBeads;
                for (let nextUpdateIndex in allUpdates) {
                    if (!allUpdates.hasOwnProperty(nextUpdateIndex))
                        continue;
                    let nextUpdate = allUpdates[nextUpdateIndex];
                    if (nextUpdate.handled === true)
                        continue;

                    if (nextUpdate.action === 'drawBead') {
                        this.canvasProps.ctx.fillStyle = nextUpdate.bead.color;
                        let left = this.beadLeft(nextUpdate.location[0]);
                        let top = this.beadTop(nextUpdate.location[0]);
                        let height = this.beadHeight;
                        let width = this.beadWidth;

                        this.canvasProps.ctx.fillRect(left, top, width, height);
                    }
                    if (nextUpdate.action === 'flipX'
                        || nextUpdate.action === 'flipY'
                        || nextUpdate.action === 'rotateLeft'
                        || nextUpdate.action === 'rotateRight'
                        || nextUpdate.action === 'resize') {
                        this.$forceUpdate();
                    }
                    //must use this method instead of mapMutations because we have a path and a parameter
                    this.$store.commit('pattern/handleUpdate', nextUpdateIndex);
                }
            }
        }
    }

</script>