
import {
    GETGOODS,
    LISTPAGEGOODS,
    PASSLOGIN,
    PHONELOGIN
} from './mutation-types.js'
function storeLocalStore(data,state) {
    window.localStorage.setItem(data, JSON.stringify(state));
}

export default{
    
   [GETGOODS](state,{goodsRes}){
       state.goods = goodsRes;
       storeLocalStore('data',state);
   },

    [LISTPAGEGOODS](state,{goodsRes}){
       state.listgoods = goodsRes;
        storeLocalStore('listgoods', state);
    },
    //密码登录
    [PASSLOGIN](state,{user}){
        state.userInfo = user;
        storeLocalStore('username',state);
    },
    //手机号登录
    [PHONELOGIN](state,{phone}){
        state.userInfo = phone;
        storeLocalStore('username', state);
    }

}
