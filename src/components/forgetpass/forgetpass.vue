<template>

   <div class="forgetpass">
      <div class="back">
       <span class="iconfont icon-fanhui" @click="$router.go(-1)"></span>
     </div>
      <form @submit.prevent="forgetPassword" class="phone" type="post">
          <input type="text" placeholder="邮箱" v-model="email">
          <!-- <span class="code" @click="sendEmailCode" ref="emailcode">发送验证码</span> -->
          <get-code :email="email" :codeStyle="style">
            邮箱验证码
          </get-code>
          <input type="passwrod" placeholder="邮箱验证码" v-model="emailCode">
          <input type="text" placeholder="用户名"  v-model="username" @blur="usernameValidate">
          <input type="passwrod" placeholder="新密码" v-model="password" @blur="passwordValidate">
          <input type="passwrod" placeholder="确认密码" v-model="confirmPassword" @blur="confirmPasswordValidate">
          <button>确认修改</button>
        </form>
    </div>
</template>

<script>
import {getEmailcode,forgetPass} from '@/api';
import {Toast} from 'vant';
import getCode from '@/components/common/getCode'
export default {
  data () {
    return {
      email:'',
      emailCode:'',
      username:'',
      password:'',
      confirmPassword:'',
      time:'',
      count:0,
      response:[],
      style:'position: absolute;left: 9rem;top:0.65rem'
    };
  },
  created() {
  },
  components: {
    getCode
  },
  computed: {
  },
  methods: {
   
    usernameValidate(){

    },
    passwordValidate(){

    },
    confirmPasswordValidate(){

    },
    //表单提交事件
    async forgetPassword(){
        let data = await forgetPass(this.email,this.emailCode,this.username,this.password,this.confirmPass)
        Toast({
            message:data.message
          })
    }
  },
  //masami126@126.com
  watch:{
  }
}

</script>
<style scoped lang="stylus">

    .forgetpass
      margin 3rem auto
      width 80%
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
        min-height 16rem
        text-align center
        position relative
        input
          border 1px solid #eee
          height 2rem
          line-height 2rem
          font-size .8rem
          text-indent 6px
          border-radius 5px
        // main
        //   position absolute
        //   left 10rem
        //   top .65rem
        //   display inline-block
        //   width 7rem
        //   max-width 6rem
        //   height 1.5rem
        //   line-height 1.5rem
        //   background #eee
        //   border-radius 5px
        p
         line-height 0
         text-align center
        button
         width 100%
         height 2rem
         background #4cd96f
         line-height 2rem
         color #ffffff
         cursor pointer
         border-radius 5px
         font-size .9rem
         opacity .8
        div
         width 100%
         height 2rem
         background #4cd96f
         line-height 2rem
         color #ffffff
         cursor pointer
         border-radius 5px
         font-size .9rem
         opacity .8

</style>
