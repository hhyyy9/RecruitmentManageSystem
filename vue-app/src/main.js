import Vue from 'vue'
import App from './App.vue'
import { Lazyload } from 'vant';
import router from './router'
import store from './store'
import 'lib-flexible/flexible'
import "@/permission";//登录和权限管理
import wx from 'weixin-js-sdk'
import WotDesign from 'wot-design'
import 'wot-design/lib/theme-default/index.css'
// import "./rem.js" 
// 开发环境下面使用vConsole进行调试
if (process.env.NODE_ENV === 'development' || process.env.NODE_ENV ==='test') {
  const VConsole = require('vconsole')
  new VConsole()
}
Vue.prototype.$wx = wx


Vue.use(WotDesign)

Vue.config.productionTip = false

new Vue({
  store,
  router,
  render: h => h(App)
}).$mount('#app')
// 注册时可以配置额外的选项
Vue.use(Lazyload, {
  lazyComponent: true,
});

