<template>
  <div>
    <header>
      <i class="iconfont icon-fanhui" @click="$router.go(-1)"></i>
      <img :src="result.img" alt>
    </header>
    <main>
      <p>价格￥{{result.price}}</p>
      <p>名称：{{result.name}}</p>
      <p>{{result.description}}</p>
      <div>
        <span>快递￥9</span>
        <span>月售：100件</span>
        <span>地址：天安门</span>
      </div>
    </main>
    <footer>
      <div>
        <div>
          <strong class="iconfont icon-ask"></strong>
          <span>客服</span>
        </div>
        <div>
          <span class="iconfont icon-dizhiguanli"></span>
          <span>送货地址</span>
        </div>
      </div>
      <nav>
        <!-- <router-link to="/shopcart" tag="div" > -->
        <span @click="addgoods">加入购物车</span>
        <!-- </router-link> -->
      </nav>
    </footer>
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";
import { Toast } from "vant";
import storage from "@/localStorage";
import cookie from "@/cookie";

export default {
  data() {
    return {
      result: [],
      id: 0,
      data: {},
      goodss: {}
    };
  },

  components: {},
  computed: {
    ...mapState(["goods"])
  },

  created() {
    this.id = this.$route.query.goodsId ? this.$route.query.goodsId : this.$route.params.goodsId;
    //  localStorage.getItem("data") && this.$store.replaceState(JSON.parse(localStorage.getItem("data")));
    this.listGoods();
  },
  mounted() {
    // this.$store.dispatch("getGoods");
    this.initData(this.id);
  },
  methods: {
    listGoods() {
      this.goodss = this.$route.query.goods ? this.$route.query.goods : this.$route.params.goods;
      try {
        this.result = JSON.parse(this.goodss);
      } catch (error) {}
    },

    initData(id) {
      this.goodslist = JSON.parse(localStorage.getItem("data")).goods || this.goods;

      this.goodslist.forEach(element => {
          element.goods.filter(value => value.id==id && (this.result=value))
      })

       
    },
    addgoods() {
      let info = storage.getStorage("username");
      let token = cookie.getCookie("usertoken");
      if (!token) {
        Toast.fail({
          message: "请先登录",
          duration: 2000
        });
        return false;
      }

      let cartinfo = storage.getStorage(`${info.userInfo.data.username}`);
      //根据cateid查找商品
      let id = this.result.id;
      
      let isHaveGoods = cartinfo.find(cart => cart.id == id);

      if (!isHaveGoods) {
        cartinfo.push(Object.assign({},{
              id: this.result.id,
              name: this.result.name,
              price: this.result.price,
              count: 1,
              isShow: true,
              img: this.result.img
            }
          )
        );
        // localStorage.setItem('cartinfo',JSON.stringify(cartinfo))
        storage.setStorage(`${info.userInfo.data.username}`, cartinfo);
        Toast.success("添加成功");
        this.$router.push("/shopcart");
      } else {
        let index = cartinfo.findIndex(value => {
          return value.id == id;
        });
        
        cartinfo[index].count += 1;
        storage.setStorage(`${info.userInfo.data.username}`, cartinfo);
        // localStorage.setItem('cartinfo',JSON.stringify(cartinfo))
        Toast.success("已有此商品");
        this.$router.push("/shopcart");
      }
    }
  },

  watch: {
    $route(to, from) {
      if (from.name === "Home") {
        this.id = to.query.goodsId;
        this.initData(this.id);
      } else if (from.path.slice(0, 5) == "/list" || from.path.slice(0, 7) == "/search") {
        this.listGoods();
      }
    }
  }
};
</script>

d
<style scoped lang="stylus">
@import '../../stylus/Mixin.styl';

header {
  width: 100%;
  height: 13rem;
  bottom-border-1px($bc);

  .iconfont {
    position: absolute;
    left: 1rem;
    top: 1rem;
    background: rgba(0, 0, 0, 0.4);
    color: #fff;
    padding: 0.2rem 0.3rem;
    border-radius: 50%;
    font-size: 1.2rem;
    font-weight: bolder;
  }

  img {
    width: 100%;
    height: 13rem;
  }
}

main {
  text-align: left;
  padding: 0.5rem 0.8rem 0 0.8rem;
  border-bottom: 10px solid #eee;
  background: #fff;
  color: #999;
  font-size: 0.8rem;

  p {
    line-height: 2rem;
    line-height: 2rem;
    padding-left: 0.3rem;
    bottom-border-1px($bc2);
  }

  p:nth-of-type(2) {
    color: #000;
    font-weight: bolder;
    font-size: 1rem;
  }

  div {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding: 0 0.2rem;
    line-height: 3rem;
    height: 3rem;
  }
}

footer {
  top-border-1px($bc);
  position: fixed;
  left: 0;
  bottom: 0;
  z-index: 99;
  line-height: 3rem;
  height: 3rem;
  display: flex;
  flex-direction: row;
  width: 100%;
  background: rgba(238, 238, 238, 0.722);
  font-size: 0.8rem;

  nav {
    flex: 1.5;
    text-align: center;
    border-left: 1px solid #888;
    background: $y1;
    color: #fff;
    opacity: 0.9;
    letter-spacing: 1px;
  }

  >div {
    flex: 2;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    line-height: 1rem;
    color: #888;

    >div {
      display: flex;
      flex-direction: column;
      justify-content: space-around;
      align-items: center;
    }

    .iconfont {
      font-weight: 800 !important;
      font-size: 1rem;
      color: rgb(3, 169, 244);
    }

    .icon-ask {
      color: #4aee51;
    }
  }
}
</style>
