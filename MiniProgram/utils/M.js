import {Cd} from './B.js';
class M extends Cd{
  constructor(){
    super();
  }
  /**
   * 登录模块网络请求
   * */ 
  sLogin(datas){
    let parameter={
      url:'/public/admin/students/ajaxStudentLogin',
      type:'POST',
      data:datas
    }
    return this.ajax('encode',parameter);
  }
  tLogin(datas) {
    let parameter = {
      url: '/public/admin/manager/ajaxLoginManager',
      type: 'POST',
      data: datas
    }
    return this.ajax('encode', parameter);
  }
  signIn(datas){
    let parameter = {
      url: '/public/admin/students/ajaxSaveStatistics',
      type: 'POST',
      data: datas
    }
    return this.ajax('encode', parameter);
  }

  getSignStatu(datas){
    let parameter = {
      url: '/public/admin/students/ajaxGetStatus',
      type: 'POST',
      data: datas
    }
    return this.ajax('encode', parameter);
  }
 
}
export{M}