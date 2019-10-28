//app.js

App({
  globalData: {
    windowWidth: '',
    windowHeight: '',
    screenHeight: '',
    worknavid: '',
    qk:'LZBBZ-PQQCF-SNQJI-JSYKC-YR3IK-BBF26'
  },
  onLaunch: function () {
    var that = this;
    wx.getSystemInfo({
      success: function (res) {
        that.globalData.windowWidth = res.windowWidth;
        that.globalData.windowHeight = res.windowHeight;
        that.globalData.screenHeight = res.screenHeight
      },
    })
  },



})