<template>

 <div>
    <transition name="move">
        <div class="alerttip" style="z-index: 2002;" v-if="isShowTip">
            <slot></slot>
        </div>
    </transition>
 </div>

 
</template>  
<script>
    export default {
        props:{
            isShowTip:false
        },
        data () {
            return {
                condition:true
            }
        },
        mounted() {
            console.log(this.isShowTip)
        },
        methods: {
          
        }
    }
</script>
<style scoped lang="stylus">

    .alerttip{
        min-width: 100px;
        position: fixed;
        top: 8%;
        left: 50%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        color: #fff;
        max-width: 70%;
        font-size: 14px;
        line-height: 25px;
        border-radius: 4px;
        padding: 5px 5px;
        word-break: break-all;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-sizing: content-box;
        box-sizing: content-box;
        -webkit-transform: translate3d(-50%, -50%, 0);
        transform: translate3d(-50%, -50%, 0);
        background-color: rgba(50, 50, 51, 0.88);
        width: -webkit-fit-content;
        width: -moz-fit-content;
        width: fit-content;
        white-space: pre-wrap;
        text-align:canter;
        // display:none;
    }
.move-enter-active, .move-leave-active {
    transition: all 1s;
}

.move-enter, .move-leave-to {
    opacity: 0;
}

</style>

