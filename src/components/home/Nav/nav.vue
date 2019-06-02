<template>
  <div class="nav">
    <swiper :options="swiperOption" ref="mySwiper" v-if="result.length>0">
  
      <swiper-slide v-for="(item,index) in imgArr" :key="index" class="pagewrap">
        <div class="wrap" v-for="(item,index) in item" :key="index">
          <img :src="item.nav_img_url" alt>
          <span>{{item.nav_title}}</span>
        </div>
      </swiper-slide>
      <div class="swiper-pagination" slot="pagination"></div>
    </swiper>
  </div>
</template>

<script>
export default {
  props:{
    result:{
      type:Array,
      default:function () {
        return [];
      }
    },
    test:Number
  },
  data() {
    return {
      swiperOption: {
        pagination: {
          el: ".swiper-pagination"
        }
      },
      navImg: []
    };
  },
  components: {

  },
  computed: {
    imgArr() {
      let resarr = [];
      this.result.forEach((value, index) => {
        let page = Math.floor(index / 8);
        if (!resarr[page]) {
          resarr[page] = [];
        }
        
        resarr[page].push(value);
      });
      return resarr;
    }
  },
  async mounted() {
    
  },
  methods: {}
};
</script>
<style scoped lang="stylus">
@import '../../../stylus/Mixin.styl';
.nav {
  margin-top: 1rem;
  bottom-border-1px($bc);
  padding-bottom 1rem
}
.pagewrap {
  width: 100%;
  // display: flex;
  // flex-direction row
  // flex-wrap wrap

  div {
    display: inline-block;
    width: 25%;
    text-align: center;

    img {
      width: 60%;
      height: 3rem;
      margin: auto 20%;
    }
  }
}
</style>
