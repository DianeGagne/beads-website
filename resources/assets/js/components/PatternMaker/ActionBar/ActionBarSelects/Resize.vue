<template>
    <div id="resize">
        <div style="display: flex;">
            <div class="resize-section">
                <input :value="columns" @input="updateWidth" type="number" min="1">
                <input :value="rows" @input="updateHeight" type="number" min="1">
            </div>
        </div>
    </div>
</template>
<script>
    import {mapState} from 'vuex';

    export default {

        computed: {
            ...mapState({
                rows: state => state.pattern.rows,
                columns: state => state.pattern.columns,
            })
        },
        methods: {
            updateWidth(event) {
                let value = event.target.value;

                //ensure we are entering a value
                if (isNaN(value))
                    return;

                let intValue = parseInt(value, 10);

                if(intValue < 1 || intValue > 1000)
                    return;

                this.$store.commit('pattern/setWidth', intValue);
            },
            updateHeight(event) {
                let value = event.target.value;

                //ensure we are entering a value
                if (isNaN(value))
                    return;

                let intValue = parseInt(value, 10);

                if(intValue < 1 || intValue > 1000)
                    return;

                this.$store.commit('pattern/setHeight', intValue);
            },
        },
    }
</script>
