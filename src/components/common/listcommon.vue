<template>
  <div class="list">
       <div class="left">
         <ul>
           <li :class="{on:num===''}" @click="all">全部</li>
           <li v-for="(item, index) in cates.son" :key="index" 
           @click="change(index)" ref="reference" 
           :class="{on:index===num}"
           >{{item.catename}}</li>
         </ul>
       </div>
       <div class="right">
            <div v-if="condition" class="right" style="padding:0">
                <main v-for="(item, index) in response" :key="index" @click="goodsDetail(item.id)">
                    <img :src="item.img" alt="">
                  <p>{{item.name}}</p>
                  <p>{{item.desc}}</p>
                </main>
            </div>
            <main v-for="(item, index) in catesGoods.son" :key="index"  v-else @click="goodsDetail(item.id)">
                <img :src="item.img" alt="">
              <p>{{item.name}}</p>
              <p>{{item.desc}}</p> 
            </main>
       </div> 
  </div>
</template>

<script>
import {getGoods} from '@/api';
import axios from 'axios';
import {mapState} from 'vuex';
import storage from "@/localStorage";
export default {
  props:{
    // listgoods:{
    //   typeof:Array,
    //   default () {
    //     return []
    //   }
    // }
  },
  data () {
    return {
      condition:true,
      num:'',
      array:[],
      cates:[],
      response:[],
      catesGoods:[]
    };
  },
  watch:{
    '$route'(to,from){
       this.initData(to.path);
    },
  },

  created() {
     this.listgoods = storage.getStorage('listgoods').listgoods;
     this.initData(this.$route.path);
  },
  mounted() {

  },
  computed: {
  },
  
  methods: {
    initData(path){
      
      let url = path.slice(5);
      let arr  = ['/meishi','/shengxian','/lingshi']; 
      this.cates = this.listgoods.find((value,index) => index == arr.findIndex(val => val==url));

      let array = []
        this.cates.son.forEach(value =>{
             value.son.forEach(val => {
               array.push(val)
             })
        })
        this.response = array;
        this.num = '';
        this.condition = true;
       
    },
    all(){
      this.num = '';
      this.condition = true;
    },
    change(index) {
        this.condition = false;
        this.num = index;
        this.catesGoods = this.cates.son[this.num]
    },
    goodsDetail(id){
      let goods = []
      goods = this.response.find(value =>value.id==id);
      
      this.$router.push({
          path:'/Goods',
          query:{
          goods:JSON.stringify(goods)
            }
        })
      }
  },
 
}

</script>
<style scoped lang="stylus">
@import '../../stylus/Mixin.styl'

 .list
   display flex
   flex-direction row
  .left
     flex 1
     text-align center
     background #f5f5f5
     height 40rem
     ul
       li
        width 100%
        height 3rem
        line-height 3rem
        color #333
        border 1px solid #eee
        &.on
          background #fff
        &:hover
          background #fff
  .right
     flex 3
     display flex
     flex-direction row
     align-content flex-start
     flex-wrap wrap
     background #eee
     height auto
     padding 2%
     main
       display flex
       flex-direction column
       justify-content space-between
       align-items center
       height 10rem
       width 50%
       background #fff
       border 3px solid #eee
       box-sizing border-box
       padding-top 3px
       img
          width 6rem
          height 6rem
          padding-bottom .2rem
          border-bottom 1px solid #eee
       p
         align-self baseline
         line-height 1.3rem
         font-size .8rem
         text-indent 5px
         word-break break-all
</style>
