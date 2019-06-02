<template>
  <!-- <main> -->
  <span class="code" @click="sendcode" ref="downtime" :style="codeStyle">
    <slot>发送验证码</slot>
  </span>
  <!-- </main> -->
</template>

<script>
import { sendCode, getEmailcode } from "@/api";
import { Toast } from "vant";
export default {
  props: ["username", "codeStyle", "email"],
  data() {
    return {
      // style:'position: absolute;left: 9rem;top:0.65rem'
    };
  },

  components: {},
  computed: {},
  methods: {
    //发送验证码
    async sendcode() {
      if (this.time) {
        Toast({
          message: "短信发送频繁"
        });
        return false;
      }

      const { username, email } = this;

      if (username) {
        var reg = /^[1][3,4,5,7,8][0-9]{9}$/;
        if (!reg.test(username)) {
          Toast({
            duration: 2000,
            message: "手机号不正确"
          });
          return false;
        }

        code = await sendCode(username);
      } else {
        let mailReg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
        if (!mailReg.test(email)) {
          Toast({
            duration: 2000,
            message: "邮箱不合法"
          });
          return false;
        }

        var code = await getEmailcode(email);
      }

      Toast({
        duration: 2000,
        message: code.message
      });

      if (code.code == 0) {
        this.$refs.downtime.innerText = `重新发送验证码`;
        return;
      }
      if (!this.time) {
        this.time = email ? 200 : 60;
        document.querySelector(".code").style.color = "#777";

        clearInterval(this.timer);
        this.timer = setInterval(() => {
          this.time--;
          try {
            this.$refs.downtime.innerText = `还有${this.time}s`;
          } catch (error) {
            
          }
          if (this.time <= 0) {
            try {
              this.$refs.downtime.innerText = `重新发送验证码`;
            } catch (error) {

            }
            document.querySelector(".code").style.color = "#000";
            clearInterval(this.timer);
          }
        }, 1000);
      }
    }
  }
};
</script>
<style scoped lang="stylus">
.code {
  position: absolute;
  left: 10rem;
  top: 2.5rem;
  display: inline-block;
  width: 7rem;
  max-width: 8rem;
  height: 1.5rem;
  line-height: 1.5rem;
  background: #eee;
  border-radius: 5;
  text-align: center;
}
</style>
