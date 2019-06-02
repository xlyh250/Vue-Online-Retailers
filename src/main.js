// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import VueAwesomeSwiper from 'vue-awesome-swiper'
// import fastClick from 'fastclick'
import store from './store'

// require styles
import 'swiper/dist/css/swiper.css'
//要在main.js引入reset.css，放在index.html中,有时候有些页面刷新之后会加载不到这个css
import '../static/reset.css'


window.onresize = () => {
  let clientWidth = document.documentElement.clientWidth || document.body.clientWidth;
  let html = document.querySelector('html');
  html.style.fontSize = clientWidth / 20 + 'px';
}

Vue.config.productionTip = false
// fastClick.attach(document.body)

Vue.use(VueAwesomeSwiper,{
  
})

//设置不缓存
router.beforeEach((to, from, next) => {
  const toDepth = to.path.split('/').length
  const fromDepth = from.path.split('/').length

    if (toDepth < fromDepth) {
      from.meta.keepAlive = false
      to.meta.keepAlive = true
    }
    // if(to.from.fullPath=='/')
    next()
})

//设置全局属性
Vue.prototype.Global = { a: 6, b: 7 }

document.addEventListener("touchstart", function () { }, true)

/* eslint-disable no-new */
let vm = new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>',
})
