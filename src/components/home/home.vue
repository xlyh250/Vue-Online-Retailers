<template>
   <div>
       <Top ></Top>
       <Swiper :result="result"/>
       <Nav :result="result"/>
       <Recommend/>
       <div class="category">
         <div v-for="(cate, index) in goods" :key="index" class="div">
              <header>{{cate.catename}}</header>
              <main>
                <nav v-for="(item, index) in cate.goods" :key="index" @click="jumpGoods(item.id)">
                  <!-- <router-link to="/goods" tag="div"> -->
                <p>{{item.name}}</p>
                <p>{{item.desc}}</p>
                <img :src="item.img" alt="">
                <!-- </router-link> -->
                </nav>
              </main>
              </div>
         </div> 
     <van-loading color="white" v-if="loading"/>
    </div>
</template>

<script>
import {recommend,test,goods} from '@/api'
import Top from './Top/top'
import Swiper from './swiper/swiper'
import Nav from './Nav/nav'
import Recommend from './Recommend/recommend'
import {mapState} from 'vuex'
import {Loading} from 'vant';
import vue from 'vue';
export default {
  data () {
    return {
        home:'home',
        result:[],
        catedata:[],
        arr:[],
        array:[],
        loading:true
    };
  },

  components:{
    Top,
    Swiper,
    Nav,
    Recommend,
    vanLoading:Loading

  },
  async mounted() {
   
    var result = await test();
    this.result = result.data;
    this.$store.dispatch('getGoods');
   
  },
  computed: {
    ...mapState(['goods'])
  },
  methods: {
    jumpGoods(id) {
      
      this.$router.push({
        path:'/Goods',
        query:{
          goodsId:id
        }
      })
    }
  },
  watch:{
     goods(){
        this.loading = false;
     }
  },
  beforeRouteEnter (to, from, next) {
      if(from.name=='Search'){
      }
      next();
  }
}

</script>
 <style scoped lang="stylus">
 @import '../../stylus/Mixin.styl'
  .category
    width 100%
    margin-bottom 3.5rem
   .div
    padding-bottom .6rem
    header
      background #eee
      height 2rem
      line-height 2rem
      text-align center
      color #333
    main
      display flex
      flex-wrap wrap
      flex-direction row
      justify-content flex-start
      nav
        text-align center
        width 50%
        padding-top .3rem
        p
         font-weight bold
         line-height 1.6rem
         height 1.6rem
         font-size .8rem
         color #999
        p:nth-of-type(1)
         font-size .9rem
         font-weight bold
         color #000
        img 
         width 88%
         height 8rem
         border-radius 10px
         boxShadow()
.van-loading
  background #666
  color #fff
  width 50px
  height 50px
  position absolute
  left 50%
  top 30%
  margin-left -25px
</style>

