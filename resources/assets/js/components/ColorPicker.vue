<template>
    <div id="color-picker" class="color-picker">
        <div class="color-image" :id=this.info.image
             v-bind:style="{backgroundColor: this.info.color,  backgroundImage:'url(/assets/delica11/'+this.info.image+'.jpg)'}"
             @click="returnColor">
        </div>
        <div class="color-details">
            {{info.image}}
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
                imageUrl: '',
            }
        },
        mounted() {
        },
        methods: {
            returnColor: function () {
                //this.$emit('update:color', this.info.color)
                this.$emit('update:bead', this.info)
            }
        }
    }
</script>
