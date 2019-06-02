<template>
  <div>
    <header>
      <ul v-if="listgoods.length>0">
        <li>
        <router-link to="/list/meishi">{{listgoods[0].catename}}</router-link>
        </li>
        <li>
          <router-link to="/list/shengxian">{{listgoods[1].catename}}</router-link>
        </li>
        <li>
          <router-link to="/list/lingshi">{{listgoods[2].catename}}</router-link>
        </li>
      </ul>
    </header>
     <keep-alive>
        <router-view></router-view>
        </keep-alive>
        <list-common :listgoods="listgoods"/>
  </div>

</template>

<script>
import {cates,listpagegoods} from '@/api';
import {mapState} from 'vuex';
import listCommon from "@/components/common/listcommon";
export default {
  data () {
    return {
      iSshow:0,
      list:[]
    };
  },

  components: {
    listCommon
  },
  computed: {
    ...mapState(['listgoods'])
  },
  watch: {
  '$route'(){
  }
  },
   mounted() {
    this.$store.dispatch('listpagegoods');
    // let data = await listpagegoods();
  },
  methods: {
   
  }
}

</script>
<style scoped lang="stylus">
@import '../../stylus/Mixin.styl'
@import '../../static/reset.css'

 header
  height 3rem
  line-height 3rem
  bottom-border-1px($bc)
  font-size .9rem
  ul
    display flex
    flex-direction row
    text-align center
    li
      flex 1
      display flex
      flex-direction row
      justify-content center
      a
       color #333
       display block
       width 2rem
       box-sizing border-box
       height 90%
    .on
      border-bottom 2px solid #000
</style>
