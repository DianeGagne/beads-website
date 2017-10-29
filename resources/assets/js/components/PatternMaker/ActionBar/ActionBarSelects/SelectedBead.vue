<template>
    <div id="selected-bead">
        <div class="currentBead">
            <div class="beadDisplay"
                 v-bind:style="{backgroundColor: this.currentBead.color,
                backgroundImage:'url(/assets/delica11/' + this.currentBead.image + '.jpg)',}">
                <div class="hotKey" style="bottom:3px; right:3px;">
                    A
                </div>
            </div>
            <div class="beadDescriptions">
                <br>{{this.beadFinishes}}
                <br>R100 - G234 - B234
                <br>19 (1g)

            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            bead: {
                type: Object,
            },
            palette: {
                type: Object,
            },
        },
        data: function () {
            return {
                currentBead: this.bead,

                beadName: '',
                beadFinishes: [],
                beadColors: '',
            }
        },
        mounted() {
        },
        methods: {},
        watch: {
          bead: {
              handler (bead) {
                  /*
                  axios.get('/beads/get', {params: {key: bead.key}})
                      .then(function (response) {
                          console.log(response);
                      });*/
              },
              deep: true,
          },
        },
    }
</script>
