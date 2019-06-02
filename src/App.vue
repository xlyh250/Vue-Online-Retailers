<template>
  <div id="app">

        <keep-alive>
          <router-view v-if="$route.meta.keepAlive">
            <!-- 这里是会被缓存的视图组件 -->
          </router-view>
        </keep-alive>

        <router-view v-if="!$route.meta.keepAlive">
          <!-- 这里是不被缓存的视图组件 -->
        </router-view>
      

   <Footer v-if="isShow"></Footer> 
   
  </div>
</template>

<script>
import Home from '@/components/home/home'
import Search from '@/components/search/search'

import axios from "axios";
import Footer from "./components/common/footer";
import { test } from "@/api";
export default {
  name: "App",
  data() {
    return {
      app: "app",
      image: [],
      result: [],
    };
  },
  components: {
    Footer,
    Home,
    Search,
  },
 
  methods: {
  },
  async mounted() {
    var result = await test();
    this.result = result.data;
    // console.log(typeof this.result.data);
  },
  computed: {
    isShow() {
      let reg = /^(\/login|\/search|\/Goods|\/setpass|\/Forgetpass)/gi;
      if (reg.test(this.$route.path) == true) {
        return false;
      }
      return true;
    }
  },
 
  
};
</script>

<style>

.img{
   width: 100%;
   height: 10rem;
}
img{
  width: 50%;
  height: 3rem;
}

  
</style>
