// pages/login/index.js
import {
  M
} from '../../utils/M.js';
const m = new M();
let app = getApp();
let that;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    role: ['学生', '教师'],
    roleIndex: 0
  },
  role(e) {
    that.setData({
      roleIndex: e.detail.value
    });
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
    that = this;
    that.setData({
      width: app.globalData.windowWidth,
      height: app.globalData.windowHeight
    });
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function() {
    let loginStatus=wx.getStorageSync('s');
    if (loginStatus){
      wx.reLaunch({
        url: '../index/index',
      });
      return;
    }
  },
  login(e) {
    if (e.detail.value.userName == "") {
      m.showTost('请输入学号');
      return;
    } else if (e.detail.value.userPwd == "") {
      m.showTost('请输入密码');
      return;
    } else {
      // m.showLoading('正在登录');
      if (e.detail.value.role == 0) {
        m.sLogin({
          code: e.detail.value.userName,
          password: e.detail.value.userPwd
        }).then(res => {
          console.log(res);
          if (res.data.code == 200) {
            wx.setStorageSync('s', res.data.data);
            setTimeout(() => {
              wx.reLaunch({
                url: '../index/index',
              });
              wx.hideLoading();
            }, 1500);
          }else{
            wx.hideLoading();
            m.showModal('学号或密码错误');
          };
        },res=>{
          console.log(res);
        });
      } else if (e.detail.value.role == 1){
        m.tLogin({
          username: e.detail.value.userName,
          password: e.detail.value.userPwd
        }).then(res=>{
          if (res.data.code == 200) {
            wx.setStorageSync('s', res.data.data);
            setTimeout(() => {
              wx.reLaunch({
                url: '../index/index',
              });
              wx.hideLoading();
            }, 1500);
          } else {
            wx.hideLoading();
            m.showModal('账号或密码错误');
          };
        });
      }
    }
  }
})