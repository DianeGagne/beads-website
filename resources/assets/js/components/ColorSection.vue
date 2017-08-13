<template>
    <div id="color-section">
        <vue-tabs>
            <v-tab title="All">
                <div class="colorpicker" style="height:100%; overflow-x:scroll">
                    <color-picker v-for="child in childrenColors" :bead.sync="bead" key="colorInfo.key"
                                  v-bind:info="child"></color-picker>
                </div>
            </v-tab>
            <v-tab title="Finishes">
                <v-select multiple :on-change=findFinishes :value.sync="selected" :options="finishOptions"></v-select>
                <div class="colorpicker" style="height:100%; overflow-x:scroll">
                    <color-picker v-for="child in finishColors" :bead.sync="bead" key="colorInfo.key"
                                  v-bind:info="child"></color-picker>
                </div>
            </v-tab>
            <v-tab title="Colors">
                <slider-picker v-model="colors" style="width:auto;"/>
                <div class="colorpicker" style="height:100%; overflow-x:scroll">
                    <color-picker v-for="child in colorColors" :bead.sync="bead" key="colorInfo.key"
                                  v-bind:info="child"></color-picker>
                </div>
            </v-tab>
            <v-tab title="Palette">
                <div class="colorpicker" style="height:100%; overflow-x:scroll">
                    <color-picker v-for="child in paletteColors" :bead.sync="bead" key="colorInfo.key"
                                  v-bind:info="child"></color-picker>
                </div>
            </v-tab>
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
        props: {
            beadMatrix: {default: null},
        },
        data: function () {
            return {
                colors: defaultProps,
                bead: null,
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
                        console.log(response);
                        self.colorColors = response.data;
                    });
            }
        },
        watch: {
            bead: function () {
                this.$emit('update:bead', this.bead);
            },
            colors: function () {
                this.findColors();
            },
            beadMatrix: function () {
                //create the palette
                let newPalette = [];

                //search each row for beads
                for (let row in this.beadMatrix) {
                    //search each column for beads
                    for (let column in this.beadMatrix[row]) {
                        //search the existing palette to make sure the bead is not yet in it
                        let draw = true;
                        for (let paletteBead in newPalette) {
                            if (this.beadMatrix[row][column].key == newPalette[paletteBead].key) {
                                //if it is in the palette skip adding this bead and go back to the next bead
                                draw = false;
                                break;
                            }
                        }
                        //if we have not yet seen this bead, add it to the palette
                        if (draw) {
                            newPalette.push(this.beadMatrix[row][column]);
                        }
                    }
                }
                this.paletteColors = newPalette;
            }
        }
    }
</script>
