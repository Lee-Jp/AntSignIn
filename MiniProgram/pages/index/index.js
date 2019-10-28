// pages/signmap/index.js
let qmap = require("../../utils/qqmap-wx-jssdk.min.js");
import {
  M
} from '../../utils/M.js';
const m = new M();
const app = getApp();
let that;

Page({

  /**
   * 页面的初始数据
   */
  data: {
    mheight: app.globalData.windowHeight,
    lat: 0,
    lng: 0,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
    that = this;
    that.location();
    setInterval(function () {
      that.location();
    }, 1000000000);
  },
  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function() {
   
  },
  location() {
    wx.getLocation({
      type: 'gcj02',
      altitude: true,
      success: function(res) {
        m.showLoading('正在定位');
        that.qmap(res.latitude, res.longitude);
      },
    })
  },
  qmap(mylat, mylng) {
    // 实例化API核心类
    var qqmapsdk = new qmap({
      key: 'LZBBZ-PQQCF-SNQJI-JSYKC-YR3IK-BBF26', // 必填
    });
    qqmapsdk.calculateDistance({
      mode: 'straight', //可选值：'driving'（驾车）、'walking'（步行），不填默认：'walking',可不填
      //from参数不填默认当前地址
      //获取表单提交的经纬度并设置from和to参数（示例为string格式）
      from: mylat + ',' + mylng, //若起点有数据则采用起点坐标，若为空默认当前地址
      to: '37.98382703993055,114.46639350043402', //终点坐标
      //to:'38.042738,114.514934',
      success: function(res) { //成功后的回调
        console.log(res);
        if (res.status == 0) {
          let markers = [{
            iconPath: "../img/position.png",
            id: 0,
            latitude: '37.98382703993055',
            longitude: '114.46639350043402',
            width: 36,
            height: 36
          }];
          let redius = [{
            latitude: '37.98382703993055',
            longitude: '114.46639350043402',
            color: '#0282f5',
            fillColor: '#7cb5ec55',
            radius: 110,
            strokeWidth: 0
          }]
          that.setData({
            yuan: redius,
            marker: markers,
            lat: mylat,
            lng: mylng,
            range: res.result.elements[0].distance-5,
          });
        } else {
          m.showToast('地图请求异常');
        };
      },
      fail: function(error) {
        // console.error(error);
      },
      complete: function(res) {
        //console.log(res);
      }
    });
  },
  //地图初始化完成
  upmap() {
    setTimeout(() => { wx.hideLoading();},1500);
  },
  //扫码
  scanCode() {
    if (that.data.range > 110000){
      m.showModal('请开启GPS精准定位！');
       return;
    } 
    
    wx.scanCode({
      onlyFromCamera: true,
      scanType: 'qrCode',
      success(res) {
        console.log(res.result);
        let loginStatus = wx.getStorageSync('s');
        let sInfo = JSON.parse(res.result);//二维码数据
        if (sInfo.cid != loginStatus.cid){
          wx.showModal({
            title: '提示',
            content: '您不是本班学生，无法签到',
            showCancel: false,
            success(res) {
              if (res.confirm ) {
               
              }
            }
          });
          return;
        }
        if (res.result) {
          wx.startSoterAuthentication({
            requestAuthModes: ['fingerPrint'],
            challenge: loginStatus.code,
            authContent: '请输入指纹',
            success(res) {
              that.signSuccess(loginStatus,sInfo)
            },
            fail(res) {
              console.log(res);
              if (res.errCode == 90008) {
                wx.showModal({
                  title: '提示',
                  content: '请重新扫码',
                  showCancel:false,
                  success(res){
                    if(res.confirm){
                    }
                  }
                })
                return;
              } else if (res.errCode == 90010){
                wx.showModal({
                  title: '安全提示',
                  content: '请确认指纹信息安全！',
                  showCancel: false,
                  success(res) {
                    if (res.confirm) {
                      wx.reLaunch({
                        url: '../login/index',
                      })
                    }
                  }
                })
                return;
              }else{
                wx.showModal({
                  title: '提示',
                  content: '不支持指纹识别，请点击确定签到',
                  showCancel: false,
                  success(res) {
                    if (res.confirm && loginStatus) {
                      that.signSuccess(loginStatus, sInfo)
                    }
                  }
                })
              }
            
            }

          })
        }
      }
    })
  },
  signSuccess(stu, sInfo){
    let nowDate = new Date().getFullYear() + '-' + (new Date().getMonth() + 1) + '-' + new Date().getDate();
    console.log(sInfo);
    m.getSignStatu({
      cid: stu.cid,
      status:'1',
      starttime: sInfo.starttime,            //开始时间
      scode: stu.code,    //学号
      creattime: nowDate   //学生签到时间
    }).then(res=>{
      console.log(res);
      if(res.data.code==200){
        m.showTost(res.data.msg);
      }else{
        m.signIn({
          cid: stu.cid,
          classroom: sInfo.classroom,         //教室
          week: sInfo.week,            //星期
          starttime: sInfo.starttime,            //开始时间
          endtime: sInfo.endtime,            //结束时间
          cname: sInfo.cname,      //班级名称
          subname: sInfo.subname,        //课程名称
          scode: stu.code,    //学号
          sname: stu.name,            //姓名
          status: "1",               //状态码（说明见备注）
          creattime: nowDate   //学生签到时间
        }).then(res => {
          console.log(res);
          if (res.data.code == 200) {
            m.showModal('签到成功');
          }
        });
      }
    });

  }
})