<template>
    <div id="selected-bead">
        <div class="currentBead">
            <div class="beadDisplay"
                 :style="{backgroundColor: color, backgroundImage: bg}">
                <div class="hotKey" style="bottom:3px; right:3px;">
                    A
                </div>
            </div>
            <div class="beadDescriptions">
                <br> add the bead finishes here
                <br>R100 - G234 - B234
                <br>19 (1g)

                <br>{{style}}
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        data: function () {
            return {}
        },
        computed: {
            color() {
                return this.$store.getters['currentBead/beadColor'];
            },
            bg() {
                return this.$store.getters['currentBead/beadImageUrl'];
            }
        },
        mounted() {
        },
        methods: {},
    }
</script>

