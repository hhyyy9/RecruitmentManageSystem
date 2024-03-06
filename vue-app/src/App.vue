<template>
  <div id="app">
    <keep-alive>
      <router-view v-if="$route.meta.keepAlive"></router-view>
    </keep-alive>
    <router-view v-if="!$route.meta.keepAlive"></router-view>
  </div>
</template>
<script>
export default {
  name: "App",
  components: {},
  mounted() {
    var ua = navigator.userAgent.toLowerCase();
    var isWeixin = ua.indexOf("micromessenger") != -1;
    if (isWeixin) {
      this.$wx.miniProgram.getEnv((resone) => {
        if (resone.miniprogram) {
          //"在小程序内现实二维码");
          this.$store.commit("SET_isMini", "1");
        } else {
          //不在小程序内"直接跳url
          this.$store.commit("SET_isMini", "0");
        }
      });
    }
    window.localStorage.setItem("scanCodeUrl", location.href);
  },
};
</script>
<style lang="less">
html,
body {
  padding: 0;
  border: 0;
  margin: 0;
  box-sizing: border-box;
}
</style>
