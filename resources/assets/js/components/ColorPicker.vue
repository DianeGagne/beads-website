<template>
        <div id="color-picker" style="flex:auto; display:inline-block; padding:1px; width:80px; height:30px;">
                <div style="width: 100%; height: 100%;" v-bind:style="{backgroundColor: this.info.color}"
                     @click="returnColor"></div>
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
                color: null
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
