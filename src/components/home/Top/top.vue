<template>
   <div>
       <header>
           <input type="text" placeholder="搜索" v-model="data">
           <router-link :to="isNone?'/search/'+data:'/'">
           <span class="iconfont icon-sousuo" @click="search"></span>
           </router-link>
           <alert-tip :isShowTip="isShowTip">
             <div>不准输入空值或者不超过20字数</div>
           </alert-tip>
       </header>
    </div>
</template>

<script>
import {Toast} from 'vant';
import { Notify } from 'vant';
import alertTip from './../../common/alertTip'
export default {
  props:{
    trst:''
  },
  data () {
    return {
      data:'',
      isShow:false,
      isShowTip:false
    };
  },

  components: {
    alertTip
  },
  computed: {
     isNone(){
       if(this.data.length<=0||this.data.length>20){
        //  console.log(this.data.length);
          return false
       }else{
          return true
       }
     }
    
  },
  methods: {
    search() {
    //   if(this.isNone){
    //     //  this.$router.push('/search');
    //   }else{
    //     Toast({
    //       message:'不准输入空值或者不超过20字数',
    //       duration:1500
    //     })
    //   }
    //   return
    // }
      this.isShowTip = this.isNone?false:true;

      setTimeout(() => {
        this.isShowTip = false;
      }, 2000);
    }
  }
}

</script>
<style scoped lang="stylus">

    header
      position fixed
      top 0
      left 0
      z-index 99
      width 100%
      border 1px solid #eee
      padding .5rem 20%
      background #0890ff
      input 
        border 1px solid #DEDEDE
        border-radius 5px
        height 1.6rem
        text-indent 5px
        outline none
        font-size 1rem
       span
        display inline-block
        color #eee
        vertical-align middle
        font-size 1.6rem
</style>
