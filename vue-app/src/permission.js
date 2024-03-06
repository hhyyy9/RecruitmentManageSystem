import router from "./router";
router.beforeEach((to, from, next) => {
  var ff = window.location.href
   if (ff.indexOf('weixin.wasu.com') != -1) {
     window.location.href = 'https://mini-wechat.wasu.cn/web/xingmiaoByCard/index.html#/'
   } else {
    next();
   }
})