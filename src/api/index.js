
import ajax from './ajax'
// const BASE_URL = 'http://localhost:4000'
// const url = '../../../static/data.json';
const tpurl = 'http://www.tp5.com/api/v1' || 'http://localhost/tp5/public/api/v1';

//推荐商品
export const recommend = () =>ajax(tpurl+'/recommend');

//首页商品
export const goods = () => ajax(tpurl + '/indexGoods');

// 轮播图数据
export const test = () => ajax(tpurl+'/test');

export const search = (searchData) => ajax(tpurl + '/search', { name: searchData});

export const sendCode = (phone) => ajax(tpurl+'/getphonecode',{phone})

export const passlogin = (username, password) => ajax(tpurl +'/passlogin',{username,password},'post')

export const islogin = (name,pass) =>ajax(tpurl+'/islogin',{name,pass});
// 手机登录
export const phonelogin = (username,code) =>ajax(tpurl+'/phonelogin',{username,code},'post')

//修改密码
export const setpass = (username, oldpassword, newpassword, usertoken) => ajax(tpurl + '/setpass', { username, oldpassword, newpassword, usertoken},'post');

//列表页面数据
export const listpagegoods = () => ajax(tpurl + '/listpagegoods');

//用户注册
export const register = (email, username, password, confirmpass) => 
ajax(tpurl + '/register', { email, username, password, confirmpass},'post');

export const getEmailcode = (email) => ajax(tpurl+'/emailcode',{email});

export const forgetPass = (email, emailcode,username, password, confirmpass) =>
    ajax(tpurl + '/forgetpass', { email, emailcode, username, password, confirmpass},'post')



