import Vue from "vue";
import VueRouter from "vue-router";
const Login = () => import("../views/Login.vue");
const Position_List = () => import("../views/Position_List.vue");
const Apply_position = () => import("../views/Apply_position.vue");
const Candidate_List = () => import("../views/Candidate_List.vue");
const Post_Position = () => import("../views/Post_Position.vue");
const Position_List_HR = () => import("../views/Position_List_HR");

import Store from "@/store";
Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    redirect: "/Login",
  },
  {
    path: "/Login",
    name: "Login",
    component: Login,
    meta: {
      title: "Login",
      keepAlive: false,
    },
  },

  {
    path: "/Position_List",
    name: "Position_List",
    component: Position_List,
    meta: {
      requireLogin: false, //
      title: "Position_List",
      keepAlive: false,
    },
  },
  {
    path: "/Position_List_HR",
    name: "Position_List_HR",
    component: Position_List_HR,
    meta: {
      requireLogin: false, //
      title: "Position_List_HR",
      keepAlive: false,
    },
  },

  {
    path: "/Apply_position",
    name: "Apply_position",
    component: Apply_position,
    meta: {
      requireLogin: false, //
      title: "Apply_position",
      keepAlive: false,
    },
  },
  {
    path: "/Candidate_List",
    name: "Candidate_List",
    component: Candidate_List,
    meta: {
      requireLogin: false, //
      title: "Candidate_List",
      keepAlive: false,
    },
  },

  {
    path: "/Post_Position",
    name: "Post_Position",
    component: Post_Position,
    meta: {
      requireLogin: false, //
      title: "Post_Position",
      keepAlive: false,
    },
  },
];

const router = new VueRouter({
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.title) {
    document.title = to.meta.title;
  }
  //如果url里面有token就通过
  if (to.query.token) {
    next();
  } else {
    if (to.matched.some((record) => record.meta.requireLogin)) {
      // 判断该路由是否需要登录权限

      //if (sessionStorage.getItem('loginInfo')) {  // 判断当前用户的登录信息loginInfo是否存在
      if (Store.state.uidToken) {
        next();
      } else {
        next({
          path: "/login",
          query: {
            redirect: to.fullPath,
          },
        });
      }
    } else {
      next();
    }
  }
});

// 解决Vue-Router升级导致的Uncaught(in promise) navigation guard问题
const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location, onResolve, onReject) {
  if (onResolve || onReject)
    return originalPush.call(this, location, onResolve, onReject);
  return originalPush.call(this, location).catch((err) => err);
};

const originalReplace = VueRouter.prototype.replace;
VueRouter.prototype.replace = function replace(location, onResolve, onReject) {
  if (onResolve || onReject)
    return originalReplace.call(this, location, onResolve, onReject);
  return originalReplace.call(this, location).catch((err) => err);
};

export default router;
