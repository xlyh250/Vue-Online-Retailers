<template>
   <div>
       <header>
           <span><i class="iconfont icon-fanhui" @click="$router.replace('/')">返回</i></span>
           <span>搜索结果</span>
            </header>
            <main v-if="Array.isArray(result)">
            <div v-for="(item, index) in result" :key="index" @click="jumpGoods(item.id)">
            <img :src="item.img" alt="">
            <p>{{item.name}}</p> 
            </div>
        </main>
        <main v-else>{{result}}</main>
        <van-loading color="white" v-if="loading"/>
</div>
</template>

<script>
import {search} from '@/api';
import axios from 'axios';
import {Loading} from 'vant';
export default {
  data () {
    return {
      result:[],
      loading: true,
      res:[]
    };
  },

  components: {
    vanLoading:Loading
  },
  computed: {
  },
  created() {
     this.fetchData();
  },
  mounted() {
     console.log(Object.prototype.toString.call(this.result));
  },
  watch:{
     result(){
       this.loading = false;
     },
  },
  methods: {
      async fetchData() {
        let searchData = this.$route.params.name;
        this.res = await search(searchData);
        
        this.result = this.res.data;
     },
     jumpGoods(id){
        let goods = this.result.find(value => value.id==id);
        
        this.$router.push({
          path:'/goods',
          query:{
            goods:JSON.stringify(goods)
          }
        })
     }
  },
  // beforeRouteEnter (to, from, next) {
  //   next(vm => {
  //     if(from.path.slice(0,6)=='/goods'){
  //         vm.loading = false;
  //     }
  //   })
  // },
}

</script>
<style scoped lang="stylus">
  
    header
      line-height 3rem
      height 3rem
      display flex
      flex-direction row
      span
        display inline-block
      span:nth-of-type(1)
        width 30%
        i
         letter-spacing 2px
      span:nth-of-type(2)
        width 70%
        text-align center
        margin-left -15%
        color red
    main
      border-top 10px solid #eee
      display flex
      flex-direction row
      flex-wrap wrap
      div
         padding .3rem
         width 50%
         box-sizing border-box
         border 2px solid #eee
         display flex
         flex-direction column
         justify-content space-around
         align-items center
         img 
           width 5rem
           height 5rem
         p
          margin-top .2rem
          text-align center
          word-break break-all

.van-loading
  background #666
  color #fff
  width 50px
  height 50px
  position absolute
  left 50%
  top 20%
  margin-left -25px
         
</style>
