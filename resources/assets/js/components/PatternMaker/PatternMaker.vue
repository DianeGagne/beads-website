<template>
    <div id="patternMaker" style="height:87vh;">
        <div style="height:30px; display:flex; width:100%;">
            <new-pattern
            ></new-pattern>
        </div>
        <div style="display: flex; height:100%;">

            <pattern-canvas
                    style="height:100%; width:100%;"
            ></pattern-canvas>
            <action-bar
            ></action-bar>
        </div>

    </div>
</template>
<script>
    export default {
        data: function () {
        },
        mounted: function () {
        },

        methods: {},
        watch: {}
    }
</script>

