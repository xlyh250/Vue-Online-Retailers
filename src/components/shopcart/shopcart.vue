<template>
  <div class="shopcart">
    <header>
      <div>
        <i class="iconfont icon-fanhui"></i>
        <span @click="$router.go(-1)">返回</span>
      </div>
      <p>购物车</p>
    </header>

    <main v-for="(item, index) in goodslist" :key="index">
      <!-- <In-put :check="check"></In-put> -->
      <input type="checkbox" value="66" v-model="item.isShow" @change="change(item.id)">
      <label for="color-input-red"></label>
      <article>
        <img :src="item.img" alt>
      </article>
      <nav>
        <div class="title">{{item.name}}</div>
        <div>
          <span>价格:￥{{item.price}}</span>
          <span class="add">
            <transition name="move">
              <span
                class="iconfont icon-jianhao"
                v-if="item.isShow"
                @click.self="updateGoods(item.id,false)"
                ref="reduce"
              ></span>
            </transition>
            <span class="two" v-if="item.count>=1&&item.isShow==true">{{item.count}}</span>
            <span class="iconfont icon-jiahao" @click.self="updateGoods(item.id,true)"></span>
          </span>
        </div>

        <div></div>
      </nav>
    </main>

    <div class="total">
      <div class="total_top">
        <div class="left">
          <span>
            <input type="checkbox" value="66" v-model="checkAll">
            <label for="color-input-red"></label>
          </span>
          <span class="span">全选</span>
        </div>
        <div class="right">
          <span>合计：￥{{totalPrice}}</span>
          <span>配送费:10元(满100免配送费)</span>
        </div>
      </div>
      <div class="total_bottom">
        <span @click="clearShopcart" v-if="isShowShopCart">清空购物车</span>
        <span v-if="timer" style="background:#e91e1e;color:#fff;font-family: Microsoft YaHei;">已打烊</span>
      </div>
    </div>
    <div class="recommend">
      <header>为你推荐</header>
      <div class="shoplist">
        <div>
          <img
            src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1550216063&di=325181034b012148c4f2175edde7fc73&imgtype=jpg&er=1&src=http%3A%2F%2Fc3.haibao.cn%2Fimg%2F600_0_100_0%2F1524634104.7662%2F67eb5d9cfa446471eddcbaf4952236fb.jpg"
            alt
          >
          <p>6666</p>
          <p>66666666666</p>
        </div>
        <div>
          <img
            src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1550216063&di=325181034b012148c4f2175edde7fc73&imgtype=jpg&er=1&src=http%3A%2F%2Fc3.haibao.cn%2Fimg%2F600_0_100_0%2F1524634104.7662%2F67eb5d9cfa446471eddcbaf4952236fb.jpg"
            alt
          >
          <p>6666</p>
          <p>6666666666666666666666</p>
        </div>
        <div>
          <img
            src="https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=3987640518,1612659510&fm=26&gp=0.jpg"
            alt
          >
          <p>66666666666666666</p>
          <p>666666666666666666666666666</p>
        </div>
        <div>
          <img
            src="https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=3694023095,1804150732&fm=26&gp=0.jpg"
            alt
          >
          <p>6666</p>
          <p>666666666666666666666666666</p>
        </div>
      </div>
    </div>
    <van-loading color="white" v-if="isLoaing"/>
  </div>
</template>

<script>
import InPut from "../common/input";
import { mapState } from "vuex";
import storage from "@/localStorage";
import { Toast, Loading } from "vant";
import axios from "axios";
import cookie from "@/cookie";
export default {
  data() {
    return {
      userData: {},
      user: {},
      goodslist: [],
      timer: false,
      user_info: {},
      usertoken: "",
      isLoaing: true
    };
  },

  created() {
    this.isLOaing = true;
    this.checkAll;
    this.time();
    this.usertoken = cookie.getCookie("usertoken");
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
      .catch(function(error) {});
  },
  mounted() {
    this.user = storage.getStorage("username");
    this.init();
  },
  components: {
    InPut,
    vanLoading: Loading
  },
  computed: {
    //是否显示清空购物车
    isShowShopCart() {
      return this.goodslist.some(element => element) && this.goodslist.length;
    },
    //计算总价格
    totalPrice() {
      let goods = this.goodslist.filter(value => value.isShow);

      let total = goods.reduce((prev, value) => {
        return prev + value.count * value.price;
      }, 0);
      total = total > 100 ? total - 10 : total;
      return total;
    },
    checkAll: {
      get() {
        return (
          this.goodslist.every(element => element.isShow) &&
          this.goodslist.length
        );
      },
      set(val) {
        this.time();
        this.goodslist.forEach(element => {
          element.isShow = val;
        });

        this.goodslist.find(value => value.count <= 0 && (value.count += 1));

        // storage.setStorage(
        //   `${this.user.userInfo.data.username}`,
        //   this.goodslist
        // );
        this.setLocalStorage();
      }
    }
  },
  methods: {
    setLocalStorage() {
      storage.setStorage(`${this.user.userInfo.data.username}`, this.goodslist);
    },
    //是否到点打烊
    time() {
      var newDate = new Date();

      // if (newDate.getHours() > 22 || newDate.getHours() < 8) {
      //   return this.timer = true;
      // }
      // if (newDate.getHours() == 22 && newDate.getMinutes() >= 30) {
      //    this.timer = true;
      //    return;
      // }
      //   this.timer = false;

      this.timer =
        newDate.getHours() > 22 ||
        newDate.getHours() < 8 ||
        (newDate.getHours() == 22 && newDate.getMinutes() >= 30);
    },
    //改变选中
    change(id) {
      this.time();
      this.init();
      // let index = goodslist.findIndex(element => element.id == id);
      // goodslist[index].isShow = !goodslist[index].isShow;

      //不用item直接改变状态，而是通过再次查询获取item,因为直接改变不了isShow
      let value = this.goodslist.find(element => element.id == id);
      value.isShow = !value.isShow;
      //刷新数据不刷新页面
      this.$forceUpdate();

      if (value.isShow) {
        if (!value.count) {
          value.count = 1;
        }
      }
      this.setLocalStorage();
    },

    //清空购物车
    clearShopcart() {
      this.goodslist = [];
      localStorage.removeItem(`${this.user.userInfo.data.username}`);
      Toast({
        message: "清空成功"
      });
    },
    //添加或减少
    updateGoods(id, boolean) {
      this.time();
      let value = this.goodslist.find(element => element.id == id);

      if (boolean) {
        value.count++;
        if (value.count >= 1) {
          value.isShow = true;
        }

        this.setLocalStorage();
      } else {
        value.count--;

        if (value.count == 0) {
          value.isShow = false;
        }
        this.setLocalStorage();
      }
    },
    init() {
      try {
        this.userData = this.user.userInfo.data;
      } catch (error) {}

      this.user_info.id &&
        (this.goodslist = storage.getStorage(`${this.userData.username}`));
    }
  },
  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.goodslist = vm.goodslist.filter(value => {
        return value.isShow;
      });
      vm.time();

      //从别的页面跳转到这里触发这个事件
      vm.init();
    });
  },
  
  //离开时清空不选的商品
  beforeRouteLeave(to, from, next) {
    
    this.goodslist = this.goodslist.filter(value => value.isShow);

    if (this.goodslist.length > 0) {
      this.setLocalStorage();
    } else {
      try {
        this.setLocalStorage();
      } catch (error) {

      }
    }
    next();
  },
  watch: {
    $route() {},
    user_info() {
      this.$nextTick(() => {
        if (this.user_info.id) {
          this.init();
        }
        this.isLoaing = false;
      });
    }
  }
};
</script>
<style scoped lang="stylus">
@import '../../stylus/Mixin.styl';

.shopcart {
  header {
    height: 3rem;
    line-height: 3rem;
    bottom-border-1px($bc);

    div {
      display: inline-block;
      width: 40%;
      text-indent: 5px;

      i {
        margin-right: 10px;
      }
    }

    p {
      display: inline-block;
      width: 60%;
      text-align: center;
      margin-left: -20%;
    }
  }

  main {
    margin-top: 1rem;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    bottom-border-1px($bc);
    padding-bottom: 8px;

    article {
      flex: 1;
      width: 8rem;
      height: 6rem;
      margin-left: 0.6rem;

      img {
        width: 100%;
        height: 100%;
      }
    }

    nav {
      flex: 2;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: flex-start;
      margin-left: 0.3rem;

      div {
        line-height: 0.7rem;
      }

      div:nth-of-type(2) {
        color: red;
        display: flex;
        justify-content: space-between;
        width: 100%;

        >span {
          flex: 3;
        }

        .add {
          flex: 3;
          text-align: right;

          span {
            display: inline-block;
            min-width: 0.6rem;
            text-align: center;
            border-radius: 50%;
            font-weight: bold;
            color: #008000;
            margin: 0 0.3rem;
          }

          .icon-jianhao {
            color: green;
            font-weight: bold;
          }
        }

        >span:nth-of-type(2) {
          padding-right: 0.4rem;
        }
      }
    }
  }

  .total {
    padding-top: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: space-around;

    .total_top {
      display: flex;
      flex-direction: row;
      justify-content: space-around;

      .left {
        position: relative;

        span {
          display: inline-block;
          padding-right: 0.5rem;
          text-align: center;
          vertical-align: top;
        }

        .span {
          line-height: 1rem;
        }
      }

      .right {
        display: flex;
        flex-direction: column;
        align-items: center;

        span:nth-of-type(1) {
          color: #0890ff;
        }

        span {
          margin-bottom: 1rem;
        }
      }
    }

    .total_bottom {
      display: flex;
      flex-direction: row;
      justify-content: flex-end;
      padding-right: 0.3rem;
      padding-bottom: 0.8rem;

      span {
        display: inline-block;
        width: 5rem;
        height: 2rem;
        font-size: 0.9rem;
        font-weight: bold;
        text-align: center;
        line-height: 2rem;
        border: 1px solid #eee;
        color: #000;
        background: #eee;
        margin: 0 0.3rem;
        letter-spacing: 1px;
        border-radius: 8px;
        boxShadow();
      }
    }
  }

  .recommend {
    background: #eee;
    margin-bottom: 3.5rem;

    header {
      text-align: center;
      padding: 0.2rem 0;
    }

    .shoplist {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      justify-content: space-around;
      padding: 0.5rem;
      box-sizing: border-box;

      div {
        width: 50%;
        border: 3px solid #eee;
        box-sizing: border-box;
        text-align: center;
        background-color: #fff;
        padding-top: 0.4rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;

        img {
          width: 7rem;
          height: 7rem;
        }

        p {
          max-width: 6rem;
          // 换行
          // word-break break-all
          textOverhidden();
        }
      }
    }
  }
}

.move-enter-active, .move-leave-active {
  transition: all 0.3s;
}

.move-enter, .move-leave-to {
  opacity: 0;
  transform: translateX(30px) rotate(180deg);
}

input[type=checkbox] {
  position: absolute;
  top: 0;
  left: 0.3rem;
  z-index: 9999;
  opacity: 0;
}

input[type=checkbox] + label {
  display: block;
  width: 1rem;
  height: 1rem;
  border-radius: 50%;
  cursor: pointer;
  position: relative;
  top: 0;
  left: 0.3rem;
  background: rgba(240, 84, 77, 1);
}

input[type=checkbox]:checked + label::before {
  display: block;
  content: '\2714';
  text-align: center;
  font-size: 16px;
  color: white;
}

.van-loading {
  background: #666;
  color: #fff;
  width: 50px;
  height: 50px;
  position: absolute;
  left: 50%;
  top: 20%;
  margin-left: -25px;
}
</style>
