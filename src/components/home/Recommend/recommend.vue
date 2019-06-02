<template>
  <div class="recommend">
    <header>商品推荐</header>
     <main class="img_wrap">
               <ul ref="imgul">
                   <li v-for="(item, index) in result" :key="index">
                      <img :src="item.img" alt="" srcset="">
                    </li>
               </ul>
     </main>
  </div>
</template>

<script>
import { recommend } from "@/api";
import BScroll from "better-scroll";
// import {mapState} from 'vuex'
export default {
  data() {
    return {
      result: []
    };
  },

  components: {
    
  },
  computed: {
    // ...mapState(['recommend'])
  },
  async mounted() {
     this.$store.dispatch('getGoods');
     let res = await recommend();
     
     if(res.code===1){
        this.result = res.data;
     }
  },
  methods: {
    _initScroll () {
        // 动态计算ul的宽度
        const ul = this.$refs.imgul
        const liWidth = 5
        const space = 0.2
        const count = this.result.length;
        ul.style.width = (liWidth + space) * count -space + 'rem';
        ul.children[ul.children.length-1].style.borderRight = 'none'; 
        new BScroll('.img_wrap', {
          scrollX: true // 水平滑动
        })
      }
  },
  watch: {
   result () {
        this.$nextTick(() => {
          this._initScroll()
        })
      }
  }
};
</script>
<style scoped lang="stylus">
header {
  padding: 0 0 15px 0;
  text-indent: 3px;
}
main
    width 100%
    margin-bottom 0.1rem
    ul
     display flex
     flex-direction row
     li
        padding-top .2rem
        padding 0 .2rem
        width 5rem
        margin-right .1rem
        border-right 2px solid #00000024  
        img
            height 5rem
            width 5rem

</style>
