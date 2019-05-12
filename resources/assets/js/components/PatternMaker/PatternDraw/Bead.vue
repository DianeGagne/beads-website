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
                return {'x': this.column, 'y': this.row};
            },
            color: function() {
              return this.bead(this.location);
            },
        },
        render() {
            let left = this.beadLeft(this.location);
            let top = this.beadTop(this.location);
            let height = this.beadHeight;
            let width = this.beadWidth;

            if(this.canvasProps.ctx) {
                this.canvasProps.ctx.fillStyle = this.color;
                this.canvasProps.ctx.strokeStyle = '#333333';
                this.canvasProps.ctx.lineWidth = 1;
                // this.canvasProps.ctx.strokeRect()
                this.canvasProps.ctx.rect(left, top, width, height);
                this.canvasProps.ctx.fillRect(left, top, width, height);
                this.canvasProps.ctx.stroke();
            }
        },
        watch: {
          color: function(){
              // this.$forceUpdate();
            }
        },
    }

</script>