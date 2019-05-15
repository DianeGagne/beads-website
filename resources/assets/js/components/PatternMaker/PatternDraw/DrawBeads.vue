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
                pattern: "pattern/fullPattern",
                bead: "pattern/colorAtLocation",
                beadHeight: "brickPattern/beadHeight",
                beadWidth: "brickPattern/beadWidth",
                beadTop: "brickPattern/beadTop",
                beadLeft: "brickPattern/beadLeft"

            }),
            ...mapState({
                rows: state => state.pattern.rows,
                columns: state => state.pattern.columns
            }),
            color: function(location) {
                console.log(location);
                return this.bead(location);
            },
        },
        render() {
            let column;
            let row;
            let pattern = this.pattern;
            for(column = 0; column < this.columns; column++) {
                for (row = 0; row < this.rows; row++) {

                    let left = this.beadLeft(location);
                    let top = this.beadTop(location);
                    let height = this.beadHeight;
                    let width = this.beadWidth;

                    if (this.canvasProps.ctx) {
                        this.canvasProps.ctx.fillStyle = pattern[column][row].color;
                         // this.canvasProps.ctx.fillStyle = '#999999';
                        // this.canvasProps.ctx.strokeStyle = '#333333';
                        // this.canvasProps.ctx.lineWidth = 1;
                        // this.canvasProps.ctx.strokeRect()
                        // this.canvasProps.ctx.rect(left, top, width, height);
                        this.canvasProps.ctx.fillRect(left, top, width, height);

                    }
                    if(this.canvasProps.ctx)
                    this.canvasProps.ctx.stroke();
                }
            }
        },
    }

</script>