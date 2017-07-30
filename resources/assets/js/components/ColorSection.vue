<template>
    <div id="color-section">
        <vue-tabs>
            <v-tab title="All"></v-tab>
            <v-tab title="Finishes">
                <v-select multiple :on-change=findFinishes :value.sync="selected" :options="finishOptions"></v-select>
            </v-tab>
            <v-tab title="Colors">
                <slider-picker v-model="colors"/>
            </v-tab>
            <v-tab title="Palette"></v-tab>
            <div class="colorpicker" style="height:100%; overflow-x:scroll">
                <color-picker v-for="child in childrenColors" :color.sync="color" key="colorInfo.key"
                              v-bind:info="child"></color-picker>
            </div>
        </vue-tabs>
    </div>
</template>
<script>
    import vSelect from "vue-select"
    import {Slider} from 'vue-color'
    var defaultProps = {
        hex: '#194d33',
    };
    export default {
        components: {
            vSelect,
            'slider-picker': Slider
        },
        props: {},
        data: function () {
            return {
                colors: defaultProps,
                color: null,
                childrenColors: [],
                selected: null,
                finishOptions: [],
            }
        },
        mounted() {
            this.replace();
            console.log(this.color);
            console.log(this.colors);
        },
        methods: {
            replace: function () {
                let self = this;
                axios.get('/beads/all')
                    .then(function (response) {
                        console.log(response);
                        self.childrenColors = response.data;
                    });

                axios.get('/finishes/all')
                    .then(function (response) {
                        self.finishOptions = response.data;
                    })
            },
            findFinishes: function (val) {
                let self = this;
                let data = [];
                for (let finish in val) {
                    console.log(finish);
                    data.push(val[finish].value)
                }
                axios.get('/beads/finish', {params: {finishes: data}})
                    .then(function (response) {
                        console.log(response);
                        self.childrenColors = response.data;
                    });
            },
            findColors: function(val) {
                let self = this;
                let data = this.colors.rgba;
                axios.get('/beads/color', {params: {color: data}})
                    .then(function (response){
                        console.log(response);
                        self.childrenColors = response.data;
                    });
            }
        },
        watch: {
            color: function () {
                this.$emit('update:color', this.color)
            },
            colors: function () {
                this.findColors();
            }
        }
    }
</script>
