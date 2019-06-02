<template>
  <div class="swiper">
    <swiper :options="swiperOption" ref="mySwiper" v-if="results.length>0">
      <!-- slides -->
      <swiper-slide v-for="(item,index) in results" :key="index" v-if="item.swiper_img_url">
          <div class="wrap">
              <img :src="item.swiper_img_url" alt="">
          </div>
      </swiper-slide>
      <!-- Optional controls -->
      <div class="swiper-pagination" slot="pagination"></div>
    </swiper>
  </div>
</template>

<script>
//-if="swiperimg.length>0" 让轮播图loop
import { swiper, swiperSlide } from "vue-awesome-swiper";
import "swiper/dist/css/swiper.css";
import axios from 'axios';
export default {
  name:'swiperComponent',
  props:{
    result:{
      type:Array,
      default:function (params) {
        return []
      }
    }
  },
  data() {
    return {
      swiperOption: {
        // pagination: ".swiper-pagination",
        autoplay:{
            delay: 3000,
            stopOnLastSlide: false,
            disableOnInteraction: false, // 解决手动滑动之后不会自动轮播现象
        },
        observer:true,//修改swiper自己或子元素时，自动初始化swiper
        observeParents:true,//修改swiper的父元素时，自动初始化swiper
        loop:true,
      },
      swiperimg:[],
      results:[],

      a:this.Global.a,
      b: this.Global.b
    };

  },
  components: {
    swiper,
    swiperSlide
  },
  computed: {
   
  },
  created() {
    this.results = this.result;
    console.log(this.a);
  },
  watch:{
    result(){
      this.results = this.result;
    },
  },
  //加上keep-alive 路由守卫不起作用
  beforeRouteLeave (to, from, next) {
  },
  //进入执行
   activated(){
      this.results = this.result;
   }, 
   //离开执行
    deactivated(){
      this.results = [];
    }  
};
</script>
<style scoped lang="stylus">
.swiper 
  margin-top 2.9rem
  .wrap
      width 100%
      height 10rem
    img
      width 100%
      height 10rem
</style>
