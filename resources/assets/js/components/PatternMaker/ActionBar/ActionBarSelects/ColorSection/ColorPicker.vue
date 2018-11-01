<template>
    <div id="color-picker" class="color-picker" v-bind:class="{selected: isSelected}">
        <div class="color-image" :id=this.info.image
             v-bind:style="{backgroundColor: this.info.color,  backgroundImage:this.imageUrl}"
             @click="returnColor">
        </div>
    </div>
</template>
<script>
    import SavedPattern from '../../../../../StoredData/PatternValues.js';
    export default {
        props: {
            info: {
                default: {
                    color: 'black',
                    image: 'newName',
                }
            },
        },
        data: function () {
            return {
                currentBead: SavedPattern.actionBarValues.bead,
                color: null,
                imageUrl: 'url(/assets/delica11/'+this.info.image+'.jpg)',
            }
        },
        computed: {
            isSelected: function() {
                return this.info.key === SavedPattern.actionBarValues.bead.key;
            }
        },
        mounted() {
        },
        methods: {
            returnColor: function () {
                SavedPattern.actionBarValues.bead.color = this.info.color;
                SavedPattern.actionBarValues.bead.image = this.info.image;
                SavedPattern.actionBarValues.bead.key = this.info.key;
                SavedPattern.actionBarValues.bead.otherValue = this.info.otherValue;
            }
        }
    }
</script>
