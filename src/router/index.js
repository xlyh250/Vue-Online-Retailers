import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/home/home'
import List from '@/components/list/list';
import Personal from '@/components/personal/personal';
import Shopcart from '@/components/shopcart/shopcart';
import Shengxian from '@/components/list/shengxian/shengxian'
import Meishi from '@/components/list/meishi/meishi'
import Lingshi from '@/components/list/lingshi/lingshi'
import Login from '@/components/login/login'
import Search from '@/components/search/search'
import Goods from '@/components/goods/goods';
import Setpass from '@/components/setpass/setpass';
import Forgetpass from '@/components/forgetpass/forgetpass';

Vue.use(Router)

export default new Router({
  linkActiveClass: 'on',
  mode: 'history',
  scrollBehavior(to, from, savedPosition) {
    
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  },
  
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
      meta: {
        keepAlive: true
      }
    },
    {
      path: '/',
      redirect: '/'
    },
    {
      path:'/list',
      // name:'List',
      component:List,
      children: [
        {
          path: '/list/shengxian',
          component: Shengxian
        },
        {
          path: '/list/meishi',
          component: Meishi
        },
        {
          path: '/list/lingshi',
          component: Lingshi
        },
        {
          path: '',
          redirect: '/list/meishi'
        },
      ],
      meta: {
        keepAlive: true
      }
    },
    {
      path: '/shopcart',
      name: 'Shopcart',
      component: Shopcart,
      meta: {
        keepAlive: true
      }
    },
    {
      path: '/personal',
      name: 'Personal',
      component: Personal,
      meta: {
        keepAlive: true
      }
    },
    {
      path:'/login',
      name:'Login',
      component:Login,
      meta: {
        keepAlive: true
      }
    },
    {
      path:'/search/:name',
      name:'Search',
      component:Search,
      meta:{
        keepAlive:false
      }
    },
    {
      path:'/goods',
      name:'Goods',
      component:Goods,
      meta: {
        keepAlive: true
      }
    },
    {
      path:'/setpass',
      name:'Setpass',
      component:Setpass,
      meta: {
        keepAlive: false
      }
    },
    {
      path:'/forgetpass',
      name:'Forgetpass',
      // component: () => import('@/components/forgetpass/forgetpass'),
      component:Forgetpass,
      meta:{
        keepAlive:false
      }
    },
  ]
})
