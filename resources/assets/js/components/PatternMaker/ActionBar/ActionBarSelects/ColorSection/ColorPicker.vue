<template>
    <div id="color-picker" class="color-picker">
        <div class="color-image" :id=this.info.image
             v-bind:style="{backgroundColor: this.info.color,  backgroundImage:this.imageUrl}"
             @click="returnColor">
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
        mounted() {
        },
        methods: {
            returnColor: function () {
                this.$emit('update:bead', this.info)
            }
        }
    }
</script>
