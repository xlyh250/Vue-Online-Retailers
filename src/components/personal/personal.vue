<template>
  <div>
    <header>
      <div class="personal_img">
        <img src="https://img3.doubanio.com/view/photo/l/public/p2239638854.webp" alt v-if="false">
        <img
          src="https://gss3.bdstatic.com/-Po3dSag_xI4khGkpoWK1HF6hhy/baike/w%3D268%3Bg%3D0/sign=b5d2f80370d98d1076d40b371904df33/8326cffc1e178a82220e115ffa03738da977e81b.jpg"
          alt
          v-else
        >
      </div>
      <div class="login_register">
        <div class="text">
          <main @click="login">{{user_info.id>0?'已登录':'登录/注册'}}</main>
          <main class="iconfont icon-tel" v-if="!user_info.id>0">登陆后享受更多特权</main>
          <main class="iconfont icon-tel" v-if="user_info.id>0">用户名:{{user_info.username}}</main>
        </div>
        <div class="next">
          <i class="iconfont icon-next"></i>
        </div>
      </div>
    </header>

    <div>
      <nav v-if="user_info.id>0">
        <div class="order">
          <div class="my_order">我的订单</div>
          <div class="all_order">全部订单</div>
        </div>
        <div class="order_detail">
          <span>
            <i class="iconfont icon-weibiaoti2fuzhi04"></i>
            <span>待付款</span>
          </span>
          <span>
            <i class="iconfont icon-gouwuchekong"></i>
            <span>待配送</span>
          </span>
          <span>
            <i class="iconfont icon-distribution"></i>
            <span>配送中</span>
          </span>
          <span>
            <i class="iconfont icon-daipingjia01"></i>
            <span>待评价</span>
          </span>
        </div>
      </nav>
      <main class="main">
        <div v-if="user_info.id>0">
          <div class="img">
            <i class="iconfont icon-xiugaimima"></i>
          </div>

          <!-- <router-link :to="'/setpass/'+'...'" tag="div" class="description"> -->
          <div class="description" @click="jumpSetpass">
            <span>修改密码</span>
            <i class="iconfont icon-next"></i>
          </div>

          <!-- </router-link> -->
        </div>
        <div>
          <div class="img">
            <i class="iconfont icon-dizhiguanli"></i>
          </div>
          <div class="description">
            <span>地址管理</span>
            <i class="iconfont icon-next"></i>
          </div>
        </div>
        <div>
          <div class="img">
            <i class="iconfont icon-youhuijuan"></i>
          </div>
          <div class="description">
            <span>优惠卷</span>
            <i class="iconfont icon-next"></i>
          </div>
        </div>
      </main>

      <main class="main02">
        <div>
          <div class="img">
            <i class="iconfont icon-ask"></i>
          </div>
          <div class="description">
            <span>客服中心</span>
            <i class="iconfont icon-next"></i>
          </div>
        </div>
        <div v-if="user_info.id>0">
          <div class="img">
            <i class="iconfont icon-tuichu"></i>
          </div>
          <div class="description" @click="loginOut">
            <span>退出登录</span>
            <i class="iconfont icon-next"></i>
          </div>
        </div>
        <div>
          <div class="img">
            <i class="iconfont icon-guanyu"></i>
          </div>
          <div class="description">
            <span>关于作者</span>
            <i class="iconfont icon-next"></i>
          </div>
        </div>
      </main>
      <footer></footer>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { islogin } from "@/api";
import axios from "axios";
import { Toast } from "vant";
import cookie from "@/cookie";
import storage from "@/localStorage";
export default {
  data() {
    return {
      user_info: {
        id: 0
      },
      usertoken: 0
    };
  },
  components: {},
  created() {
    this.usertoken = cookie.getCookie("usertoken") || '';
  },
  mounted() {
    this.getUserInfo();
  },
  computed: {
    ...mapState(["userInfo"])
  },
  watch: {
    userInfo() {
      this.user_info = this.userInfo.data;
      this.usertoken = this.user_info.token;
    }
  },
  beforeRouteEnter(to, from, next) {
    next(vm => {
      let usertoken = cookie.getCookie("usertoken");
      if(from.fullPath.slice(0,8)=='/setpass'&&!usertoken){

          vm.getUserInfo();
      }
    });
  },
  methods: {
    getUserInfo() {
      axios({
        method: "put",
        url: "http://www.tp5.com/api/v1/islogin",
        headers: {
          token: this.usertoken
        }
      })
        .then(response => {
          this.user_info = response.data.data;
        })
        .catch(function(error) {
          
        });
    },
    jumpSetpass() {
      this.$router.push("/setpass");
    },
    login() {
        if (this.usertoken) {
          return false;
        }
      this.$router.replace("/login");
    },

    loginOut() {
      // this.setCookie("usertoken", "", -1);
      cookie.setCookie("usertoken", "", -1);
      localStorage.removeItem("username");
      // this.$router.replace('/personal');
      Toast({
        duration: 2000,
        message: "退出成功"
      });
      //重新刷新页面
      location.reload();
    }
  }
};
</script>
<style scoped lang="stylus">
@import '../../stylus/Mixin.styl';

header {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 1rem 0;
  background-image: linear-gradient(90deg, #0af, #0085ff);
  color: #fff;

  .personal_img {
    flex: 0.8;
    display: flex;
    align-items: center;
    justify-content: center;

    img {
      width: 4rem;
      height: 4rem;
      border-radius: 50%;
    }
  }

  .login_register {
    flex: 2;
    display: flex;
    flex-direction: row;
    justify-content: space-between;

    .text {
      display: flex;
      flex-direction: column;
      justify-content: space-around;
      line-height: 2rem;

      >main:nth-of-type(1) {
        max-width: 6rem;
        font-size: 1.2rem;
        font-weight: bold;
      }
    }

    .next {
      padding-right: 0.8rem;
      display: flex;
      flex-direction: column;
      justify-content: center;

      i {
        font-size: 1rem;
        font-weight: bold;
      }
    }
  }
}

nav {
  .order {
    height: 3rem;
    line-height: 3rem;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    color: #746f6f;
    letter-spacing: 2px;
    padding: 0 0.5rem;
    bottom-border-1px($bc);

    .all_order {
      opacity: 0.5;
      font-weight: bold;
    }
  }

  .order_detail {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    line-height: 4rem;
    height: 4rem;
    border-bottom: 10px solid $bc;

    >span {
      display: flex;
      flex-direction: column;
      justify-content: center;
      line-height: 1.5rem;
      align-items: center;
      color: #333;
      font-size: 0.8rem;

      .iconfont {
        font-size: 1.2rem;
      }
    }
  }
}

.main {
  display: flex;
  flex-direction: column;
  border-bottom: 10px solid $bc;
  padding-bottom: 0.3rem;

  >div {
    display: flex;
    flex-direction: row;
    line-height: 3rem;
    height: 3rem;
    color: #333;

    .img {
      flex: 1;
      text-align: center;

      i {
        font-size: 1rem;
        font-weight: bolder;
        padding: 0.5rem;
        border-radius: 50%;
      }

      .icon-xiugaimima {
        background: rgba(205, 220, 57, 0.49);
        color: #3F51B5;
      }

      .icon-dizhiguanli {
        background: rgba(158, 158, 158, 0.169);
        color: #03A9F4;
      }

      .icon-youhuijuan {
        background: rgba(255, 235, 59, 0.42);
        color: hsl(0, 100%, 51%);
      }
    }

    .description {
      flex: 3;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      bottom-border-1px($bc);

      .iconfont {
        padding-right: 0.4rem;
      }
    }
  }
}

.main02 {
  display: flex;
  flex-direction: column;
  border-bottom: 10px solid $bc;
  padding-bottom: 0.3rem;

  >div {
    display: flex;
    flex-direction: row;
    line-height: 3rem;
    height: 3rem;
    color: #333;

    .img {
      flex: 1;
      text-align: center;

      i {
        font-weight: bolder;
        font-size: 1rem;
        padding: 0.5rem;
        border-radius: 50%;
      }

      .icon-ask {
        background: rgba(158, 158, 158, 0.502);
        color: #07c30e;
      }

      .icon-tuichu {
        background: rgba(244, 67, 54, 0.49);
        color: rgb(33, 146, 243);
      }

      .icon-guanyu {
        background: rgba(96, 125, 139, 0.2);
        color: #2196F3;
      }
    }

    .description {
      flex: 3;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      bottom-border-1px($bc);

      .iconfont {
        padding-right: 0.4rem;
      }
    }
  }
}

footer {
  margin-top: -2px;
  height: 27rem;
  background: #e4e4e4;
}
</style>
