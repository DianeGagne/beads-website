<template>
        <div id="color-picker" style="flex:auto; display:inline-block; padding:1px; width:75px; height:30px;">
                <div :id=this.info.image style="width: 100%; height: 100%;" v-bind:style="{backgroundColor: this.info.color,  backgroundImage:'url(/assets/delica11/'+this.info.image+'.jpg)'}"
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
                imageUrl: '',
            }
        },
        mounted() {
        },
        methods: {
            returnColor: function () {
                this.$emit('update:color', this.info.color)
            }
        }
    }
</script>
