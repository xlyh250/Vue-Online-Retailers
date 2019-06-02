import {
    GETGOODS,
    PASSLOGIN,
    PHONELOGIN,
    LISTPAGEGOODS
} from './mutation-types.js'

import {
    goods,
    passlogin,
    phonelogin,
    listpagegoods
} from '@/api'

export default{

    // 获取商品
    async getGoods({commit,state}){
        const result = await goods();
        let goodsRes = result.data;
        commit(GETGOODS,{goodsRes})
    },

    //获取列表页面商品
    async listpagegoods({commit,sate}){
        const result = await listpagegoods();
        let goodsRes = result.data;
        commit(LISTPAGEGOODS,{goodsRes})
    },
    addgoods({ commit }, addgoods){
        let addgoodsRes = addgoods.addgoods
        commit(ADDGOODS, { addgoodsRes})
    },

    // commit函数里面的第二个参数和传入mutation第二个参数名称相同
    //密码登录
   async passlogin({commit},{username,password}){
       
       let userdata = await passlogin(username,password)
           const user = userdata;
           commit(PASSLOGIN,{user})
    },
    // 手机号登录
    async phonelogin({commit},{username,code}){
        const phone = await phonelogin(username,code);
        commit(PHONELOGIN,{phone})
    }

}