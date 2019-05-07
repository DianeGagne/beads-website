<template>
    <div class="color-picker" v-bind:class="{selected: isSelected}">
        <div class="color-image" :id=this.info.image
             v-bind:style="{backgroundColor: this.info.color,  backgroundImage:this.imageUrl}"
             @click="setBead">
        </div>
    </div>
</template>
<script>
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
                color: null,
                imageUrl: 'url(/assets/delica11/'+this.info.image+'.jpg)',
            }
        },
        computed: {
            isSelected: function() {
                return this.info.key === this.$store.getters['currentBead/beadKey'];
            }
        },
        mounted() {
        },
        methods: {
            setBead: function () {
                this.$store.commit('currentBead/changeBead', this.info);
            }
        }
    }
</script>
