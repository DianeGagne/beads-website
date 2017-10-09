<template>
    <div id="selected-bead">
        <div class="currentBead" style="height:5%; margin-left:15px; margin-top:5px; margin-bottom:5px; display:flex;">
            <div class="beadDisplay color-image" style="background-color: rgb(38, 37, 42);
                                                    background-image: url(/assets/delica11/db0454.jpg);
                                                    width:40%; padding:3px;">
                <div class="hotKey" style="bottom:3px; right:3px;">
                    A
                </div>
                >
            </div>
            <div class="beadDescriptions">
                Delica 0454
                <br>Metallic, Solid, Lustre
                <br>R100 - G234 - B234
                <br>19 (1g)

            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                bead: null,
            }
        },
        mounted() {
        },
        methods: {
        },
    }
</script>
