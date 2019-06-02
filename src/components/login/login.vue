<template>
   <div class="login">
       <div class="back">
       <span class="iconfont icon-fanhui" @click="$router.push('/personal')"></span>
     </div>
       <div class="top_img">
           <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1549639342389&di=e43272432655e48e371e57e27701b541&imgtype=0&src=http%3A%2F%2Fimg.71lady.com%2Fuploads%2Fallimg%2F140310%2F2-140310123I9.jpg" alt="">
       </div>
       <div class="login_input">
        <form @submit.prevent="phonelogin" class="phone" v-show="isShow==1" type="post">
           <input type="text" placeholder="手机号" @keyup="phoneValidate" v-model="phone">
           <!-- <span class="code" @click="sendCode" ref="downtime" >发送验证码</span> -->
           <get-code :username="phone" :codeStyle="style"></get-code>
           <input type="passwrod" placeholder="验证码" v-model="code">
           <p>新用户自动注册</p>
           <button>登录</button>
           <div @click="isShow=2">密码方式登录</div>
            <div @click="forgetPassword">忘记密码</div>
            <span>关于</span>
        </form>

         <form @submit.prevent="passlogin" class="password" v-show="isShow==2" type="post" >
           <input type="text" placeholder="用户名"  v-model="username" @blur="usernameValidate">
           <input type="passwrod" placeholder="密码登录" v-model="password" @blur="passwordValidate">
            <p></p>
           <button>登录</button>
            <div @click="isShow=1">手机方式登录</div>
            <div @click="isShow=3">未注册请先注册</div>
            <span>关于</span>
            <div style="display:none">
            </div>
        </form>

         <form @submit.prevent="register" class="password" v-show="isShow==3" type="post" style="height:17rem">
           <input type="email" placeholder="邮箱" v-model="email" @blur="emailValidate">
           <input type="text" placeholder="用户名"  v-model="username" @blur="usernameValidate">
           <input type="passwrod" placeholder="密码" v-model="password" @blur="passwordValidate">
           <input type="passwrod" placeholder="确认密码" v-model="confirmPass" @blur="confirmPasswordValidate">
           <p></p>
           <button>注册</button>
           <div @click="isShow=2">密码登录</div>
            <span>关于</span>
            <div style="display:none">
            </div>
        </form>
       </div>
        <!-- <alert-tip :model="model"></alert-tip> -->
    </div>
</template>

<script>
import {mapState} from 'vuex';
// import alertTip from '@/components/common/alertTip'
// import Button from 'vant/lib/button';
import { Dialog ,Toast} from 'vant';
import Vue from 'vue'
import 'vant/lib/button/style';
import {sendCode,register} from '@/api';
import cookie from '@/cookie'
import getCode from '@/components/common/getCode'
export default {
  data () {
    return {
      phone:'',
      code:'',
      isShow:1,
      username:'',
      password:'',
      user:{},
      email:'',
      confirmPass:'',
      userMessage:'',
      passMessage:'',
      phoneMessage:'',
      style:'position: absolute;left: 7rem;top:0.65rem'
    };
  },

  components: {
    getCode
  },
  computed: {
     ...mapState(['userInfo']),
     //密码确认
     conPass() {
      const {password,confirmPass} = this;
    
        if(password!=confirmPass){
            return {
              message:'密码不一致',
              code:0
            }
        }
        return {
          code:1
        }
     }
  },
  mounted() {
   
  },
  created() {
    this.timer;
  },
  methods: {
    //忘记密码
    forgetPassword(){
       this.$router.push({
         path:'/forgetpass',
         query:{

         }
       })
    },
    //手机号验证
    phoneValidate(){
      const phone = this.phone;
      var reg=/^[1][3,4,5,7,8][0-9]{9}$/;
      
          if(!phone){
                Toast({
                  duration:2000,
                  message:'手机号不得为空'
                })
              // this.phoneMessage = '手机号不得为空';
              return false;
          }
     
          if(!reg.test(phone)){
             this.phoneMessage = '手机号不正确';
                      Toast.fail({
                        duration: 1000000,
                        message: this.phoneMessage, 
                      });
          }else{
             Toast.success({
                duration: 1000,
                message: '手机号正确', 
            });
          }
          // this.phoneMessage = '';
    },
    // //验证码验证
    // codeValidate(){
    //     const {code,phone} = this;
    //     if(!code&&!phone){
    //           Toast({
    //             duration:2000,
    //             message:'验证码或者手机号不得为空'
    //           })
    //           return false;
    //     }
     
    // },

    //用户名验证
    usernameValidate(){
      const {username,password,phone} = this;
      let user = username.trim();
      let pass = password.trim();
      if(user.length>20||user.length<5){
          Toast({
              duration: 2000,
              message: '用户名长度要在5-20位之间', 
          });
            this.userMessage = '用户名长度要在5-20位之间';
            return false;
       }
            this.userMessage = '';
    },
    //密码验证
    passwordValidate(){
      
      const {username,password,phone} = this;
      let pass = password.trim();

      let reg = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]+$/g;

       if(pass.length>20||pass.length<5){
          Toast({
              duration: 2000,
              message: '密码长度要在5-20位之间', 
          });
          if(!this.passMessage){
              this.passMessage = '密码长度要在5-20位之间';
          }
          return false;
       }

      if(!reg.test(this.password)){
       
         Toast({
            duration: 2000,
            message: '密码由英文和数字组合', 
         })
        this.passMessage = '密码由英文和数字组合';
         return false;
      }
       this.passMessage = '';
    },
    //确认密码验证
    confirmPasswordValidate() {
        if(this.conPass.code==0){
          Toast({
            message:this.conPass.message
          })
          return false
      }
    },

    //邮箱验证
    emailValidate() {
       const email = this.email;
       let mailReg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;

       if(!mailReg.test(email)){
            Toast({
             duration:2000,
             message:'邮箱不合法'
           })
           return false;
       }
    },
   
    //用户注册
    async register() {
        const {email,username,password,confirmPass} = this;
        
        if(!email||!username||!password||!confirmPass){
          Toast({
            message:'不得为空'
          })
          return false;
        }

        let prompt = this.userMessage || this.passMessage;
        if(prompt!=''){
          Toast({
            duration:2000,
            message:prompt
          })
          return false;
        }

        if(this.conPass.code==0){
            Toast({
              message:this.conPass.message
            })
            return false
        }
        let confirmpass = confirmPass;

        const data = await register(email,username,password,confirmpass);
        Toast({
          message:data.message
        })
            
      },

      // 手机号登录
      phonelogin(){   
        const {phone,code} = this;
        if(!phone.length||!code.length) {
              Toast({
                duration:2000,
                message:'用户名或者密码不得为空'
              })
              return false;
        }
        this.$store.dispatch('phonelogin',{username:phone,code:code});
      },
      //密码登录
      passlogin(){
      
        const {username,password} = this;
        let message = false;

        message = (!username.length||!password.length) && '用户名或者密码不得为空'
      
      let prompt = this.userMessage || this.passMessage;

      let msg = message || prompt;
        
        if(msg!=''){
          Toast({
            duration:2000,
            message:msg
          })
          return false;
        }
      
        this.$store.dispatch('passlogin',{username,password});
          Toast.loading({
                // duration: 1000,
                message: '登录中'
           })
      },
    
    },
  watch: {
    userInfo() {
      this.$nextTick(() => {

          this.user = this.userInfo;
          
          if(this.user.data.id){
            cookie.setCookie("usertoken", this.user.data.token, 365);
          }
        
            if(this.user.code!=1){
              Toast.fail({
                duration: 2000,
                message: this.user.message
            })
            
          }else{
                if(this.user.data.id){
                  this.$router.replace('/personal');
                  Toast.success({
                    message:this.user.message
                  })
                }
          }
      })
    },
    isShow(){
      this.username = '';
      this.password = '';
      this.userMessage = '';
      this.passMessage = '';
      this.confirmPass = '';
      this.email = '';
      this.phoneMessage = '';
      Toast.clear();

    }
   
  },
}

</script>
<style scoped lang="stylus">

.van-dialog
  position absolute
  top 20px
  left 20px
#app
  height 100%
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
  .login
    display flex
    flex-direction column
    align-items center
    height 100%
    width 100%
   .top_img
     display flex
     justify-content center
     align-items center
     padding-top 2rem
     img
      height 5rem
      width 5rem
      border-radius 10px
   .login_input
      // height auto
      width 70%
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
        .code
          position absolute
          left 7rem
          top .65rem
          display inline-block
          width 7rem
          max-width 8rem
          height 1.5rem
          line-height 1.5rem
          background #eee
          border-radius 5px
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
