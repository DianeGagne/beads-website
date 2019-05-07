<template>
    <div id="color-section">
        <vue-tabs>
            <v-tab title="All">
                <div class="colorpicker">
                    <color-picker v-for="child in childrenColors" key="colorInfo.key"
                                  v-bind:info="child"></color-picker>
                </div>
            </v-tab>
            <v-tab title="Finishes">
                <select multiple :on-change=findFinishes :value.sync="selected" :options="finishOptions"></select>
                <div class="colorpicker">
                    <color-picker v-for="child in finishColors" key="colorInfo.key"
                                  v-bind:info="child"></color-picker>
                </div>
            </v-tab>
            <v-tab title="Colors">
                <slider-picker v-model="colors" style="width:auto;"/>
                <div class="colorpicker">
                    <color-picker v-for="child in colorColors" key="colorInfo.key"
                                  v-bind:info="child"></color-picker>
                </div>
            </v-tab>
            <v-tab title="Palette">
                <div class="colorpicker">
                    <color-picker v-for="child in paletteColors" key="colorInfo.key"
                                  v-bind:info="child"></color-picker>
                </div>
            </v-tab>
        </vue-tabs>
    </div>
</template>
<script>
    import {Slider} from 'vue-color'


    var defaultProps = {
        hex: '#194d33',
    };
    export default {
        components: {
            'slider-picker': Slider
        },
        data: function () {
            return {
                colors: defaultProps,
                childrenColors: [],
                finishColors: [],
                colorColors: [],
                selected: null,
                finishOptions: [],
                paletteColors: [],
            }
        },
        mounted() {
            this.replace();
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
                        self.finishColors = response.data;
                    });
            },
            findColors: function (val) {
                let self = this;
                let data = this.colors.rgba;
                axios.get('/beads/color', {params: {color: data}})
                    .then(function (response) {
                        self.colorColors = response.data;
                    });
            }
        },
        watch: {
            colors: function () {
                this.findColors();
            },
        }
    }
</script>
