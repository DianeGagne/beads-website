<script>
    import {mapGetters} from 'vuex';

    export default {
        props: {
            column: {
                type: Number,
            },
            row: {
                type: Number,
            },
            canvasProps: {
                type: Object,
            },
        },

        computed: {
            ...mapGetters({
                bead: "pattern/colorAtLocation",
                beadHeight: "brickPattern/beadHeight",
                beadWidth: "brickPattern/beadWidth",
                beadTop: "brickPattern/beadTop",
                beadLeft: "brickPattern/beadLeft"
            }),
            location: function() {
                return {'x': this.row, 'y': this.column};
            }
        },
        render() {
            let left = this.beadLeft(this.location);
            let top = this.beadTop(this.location);
            let height = this.beadHeight;
            let width = this.beadWidth;

            this.canvasProps.ctx.fillStyle = this.bead(this.location);
            this.canvasProps.ctx.strokeStyle = '#990000';
            this.canvasProps.ctx.lineWidth = 1;
            // this.canvasProps.ctx.strokeRect()
            this.canvasProps.ctx.rect(left, top, width, height);
            this.canvasProps.ctx.fillRect(left,top,width,height);
            this.canvasProps.ctx.stroke();

        },
    }

</script>