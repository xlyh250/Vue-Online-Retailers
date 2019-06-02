<template>
   <div>
     <div class="back">
       <span class="iconfont icon-fanhui" @click="$router.go(-1)"></span>
     </div>
       <form @submit.prevent="setpass" action="" method="post">
           <input type="text" placeholder="用户名" v-model="username">
             <!-- <span class="code" @click="sendCode" ref="downtime" >发送验证码</span> -->
             <get-code :username="username"></get-code>
           <input type="text" placeholder="旧密码(手机注册使用验证码)" v-model="oldpassword">
           <input type="text" placeholder="新密码" v-model="newpassword">
           <button>修改密码</button>
       </form>
   </div>
</template>

<script>
import {setpass,sendCode} from '@/api';
import {Toast} from 'vant';
import cookie from '@/cookie';
import axios from 'axios';
import storage from '@/localStorage'
import getCode from '@/components/common/getCode'
export default{
  data () {
    return {
        username:storage.getStorage('username').userInfo.data.username,
        oldpassword:'',
        newpassword:''
    };
  },
  components: {
    getCode,
  },
  computed: {
  },
  created() {
  },
  mounted() {
  },
  beforeRouteLeave (to, from, next) {
     console.log(to);
     next()
},
  methods: {
   
    async setpass() {
        let {username,oldpassword,newpassword} = this;
         username = username.trim();
         oldpassword = oldpassword.trim();
         newpassword = newpassword.trim();
        let usertoken = cookie.getCookie('usertoken');
         
        await setTimeout(() => {
          if(!username.length||!oldpassword.length||!newpassword.length){
            Toast({
              message:'用户名或者新旧密码不得为空'
            })
          }
         }, 100);
       
        const message = await setpass(username,oldpassword,newpassword,usertoken);
        
         Toast({
              duration:2000,
              message:message.message,
          })
        if(message.code==1){
            cookie.setCookie("usertoken","",-1);
            //重新刷新页面
            // location.reload();
        }
      },
  }
}

</script>
<style scoped lang="stylus">
  .back
    span
      position: absolute;
      left: .7rem;
      top: .7rem;
      background: rgba(0,0,0,0.4);
      color: #fff;
      padding: 0.2rem 0.3rem;
      border-radius: 50%;
      font-size: 1.2rem;
      font-weight: bolder;
  form
    display flex
    flex-direction column
    justify-content space-around
    height 10rem
    width 70%
    margin 2rem auto
    input
      border 1px solid #eee
      height 2rem
      line-height 2rem
      font-size .8rem
      text-indent 6px
      border-radius 5px
    // .code
    //   position absolute
    //   left 10rem
    //   top 2.5rem
    //   display inline-block
    //   width 7rem
    //   max-width 8rem
    //   height 1.5rem
    //   line-height 1.5rem
    //   background #eee
    //   border-radius 5
    //   text-align center
    button
      width 80%
      margin 0 auto
      height 2rem
      background #4cd96f
      line-height 2rem
      color #ffffff
      cursor pointer
      border-radius 5px
      font-size .9rem
      opacity .8

</style>
