<template>
   <div>
       <nav class="footer">
        <div><router-link to="/" exact><span class="iconfont icon-home"><i ></i></span><span>首页</span></router-link></div>
        <div><router-link to="/list"><span class="iconfont icon-list"><i ></i></span><span>列表</span></router-link></div>
        <div><router-link to="/shopcart"><span class="iconfont icon-chezi"><i></i></span><span>购物车</span></router-link></div> 
        <div><router-link to="/personal"><span class="iconfont icon-personal"><i></i></span><span>个人中心</span></router-link>
        </div> 
       </nav>
    </div>
</template>

<script>
export default {
  data () {
    return {
    };
  },

  components: {
  },
  computed: {
  },
  methods: {
  }
}

</script>
<style scoped lang="stylus">
@import '../../stylus/Mixin.styl'
   nav
     top-border-1px(#e1dada)
     position fixed
     left 0
     bottom  0
     z-index 9999
     height 3.5rem
     width 100%
     background #EEE
     display flex
     flex-direction row
     justify-content space-around
     div
       width 100%
       a
        height 100%
        display block
        display flex
        flex-direction column
        justify-content center
        align-items center
        &.on
          color red
        .iconfont
          font-size 1.1rem
          line-height 1.5rem
</style>
 