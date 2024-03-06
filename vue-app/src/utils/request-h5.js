import axios from "axios";
import { Toast } from "vant";
import Store from "@/store";
import router from "@/router";

// 请求超时时间，30s
const requestTimeOut = 30 * 1000;
const success = 200;

// 系统全局请求对象
const service = axios.create({
  baseURL: process.env.VUE_APP_BASE_API,
  timeout: requestTimeOut,
  responseType: "json",
  validateStatus(status) {
    return status === success;
  },
});
//请求拦截，在每个请求发出去之前，针对每个域名做不同的配置
service.interceptors.request.use(
  (config) => {
    let _config = config;
    _config.data = _config.data ? _config.data : {};

    //根据不同的环境进行配置
    if (_config.requestBase == "VUE_APP_BASE_API") {
      // Toast.loading({
      //   duration: 0, // 持续展示 toast
      //   forbidClick: true,
      //   message: '加载中',
      // });
      _config.baseURL = process.env.VUE_APP_BASE_API;
    } else if (_config.requestBase == "VUE_APP_BASE_API_ONE") {
      _config.baseURL = process.env.VUE_APP_BASE_API_ONE;
      Toast.loading({
        duration: 0, // 持续展示 toast
        forbidClick: true,
        message: "加载中",
      });
    } else if (_config.requestBase == "VUE_APP_BASE_API_TWO") {
      _config.baseURL = process.env.VUE_APP_BASE_API_TWO;
      _config.headers["ri-accept"] = "true";
    } else if (_config.requestBase == "VUE_APP_BASE_API_Three") {
      _config.baseURL = process.env.VUE_APP_BASE_API_Three;
      Toast.loading({
        duration: 0, // 持续展示 toast
        forbidClick: true,
        message: "加载中",
      });
    } else if (_config.requestBase == "VUE_APP_BASE_API_Four") {
      _config.baseURL = process.env.VUE_APP_BASE_API_Four;
      Toast.loading({
        duration: 0, // 持续展示 toast
        forbidClick: true,
        message: "加载中",
      });
    }
    //权益
    _config.headers["ri-token"] = Store.state.uidToken
      ? Store.state.uidToken
      : "";
    // tokenTest, U20220124001243, 13399990000
    // _config.headers['ri-user-agent'] = "MOB-WEB";
    _config.headers["ri-accept"] = "true";

    //乐邦邦
    let token = Store.state.token;
    let location2 = { lat: "", lng: "" };
    let lol = { lat: "", lng: "" };
    let address = "";
    let tenant = "";

    _config.data.Token = token;
    _config.data.clientType = 1;
    _config.data.phoneModel = "phone";
    _config.data.versions = "2.23.0";

    if (_config.url != "/client-user/user/getTenant") {
      _config.data.lat = lol.lat || "";
      _config.data.lng = lol.lng || "";
      _config.data.tenant = tenant;
      _config.data.districtCode = "";
    }
    if (_config.data.lat == 0) {
      _config.data.lat = location2.lat || "";
    }
    if (_config.data.lng == 0) {
      _config.data.lng = location2.lng || "";
    }
    // 有的接口需要使用加密方式,在当时就已经获取过时间戳了,要保证加密时使用的时间戳与传入后台的时间戳一致
    _config.data.timestamp = _config.data.timestamp
      ? _config.data.timestamp
      : new Date().getTime();
    _config.headers["blade-auth"] = "app";
    _config.headers["clientType"] = _config.data.clientType;
    _config.headers["token"] = token || "";

    return _config;
  },
  (err) => {
    // 手动清除 Toast
    Toast.clear();
    return Promise.reject(err);
  }
);

service.interceptors.response.use(
  (response) => {
    // 手动清除 Toast
    Toast.clear();
    const res = response.data;
    if (res.error_no == 101) {
      Toast("登录已过期，请重新登录");
      setTimeout(() => {
        router.push("/Login");
      }, 500);
      return;
    } else {
      return res;
    }
  },
  (err) => {
    debugger;
    // 手动清除 Toast
    Toast.clear();
    if (err.toString().indexOf("Error: timeout") !== -1) {
      Toast("网络异常，请稍后再试");
    }
    if (err.toString().indexOf("Error: Network Error") !== -1) {
      Toast("网络异常，请稍后再试");
    }
    if (err.response) {
      switch (err.response.status) {
        case 445:
          Toast("登录已过期，请重新登录");

          break;
        default:
          Toast("网络异常，请稍后再试");
          break;
      }
    }
    return Promise.reject ? Promise.reject(err) : err;
  }
);

const request = {
  post(url, params, requestBase) {
    return service.post(url, params, {
      transformRequest: [
        (params) => {
          return tansParams(params);
        },
      ],
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      requestBase: requestBase ? requestBase : "VUE_APP_BASE_API",
    });
  },
  postJson(url, params, requestBase) {
    return service.post(url, params, {
      headers: {
        "Content-Type": "application/json",
      },
      requestBase: requestBase ? requestBase : "VUE_APP_BASE_API",
    });
  },
  put(url, params, requestBase) {
    return service.put(url, params, {
      transformRequest: [
        (params) => {
          return tansParams(params);
        },
      ],
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      requestBase: requestBase ? requestBase : "VUE_APP_BASE_API",
    });
  },

  get(url, params, requestBase) {
    let _params = {
      method: "get",
      url: url,
      requestBase: requestBase ? requestBase : "VUE_APP_BASE_API",
      params: params,
    };
    return service(_params);
  },

  upload(url, params) {
    return service
      .post(url, params, {
        headers: {
          "Content-Type": "multipart/form-data",
          Authorization: window.localStorage.getItem("token"),
        },
        timeout: 120 * 1000,
      })
      .then((r) => {
        return r;
      })
      .catch((r) => {
        this.$message.success("上传失败");
      });
  },

  download(url, params, filename) {
    return service
      .post(url, params, {
        transformRequest: [
          (params) => {
            return tansParams(params);
          },
        ],
        responseType: "blob",
      })
      .then((r) => {
        const content = r.data;
        const blob = new Blob([content]);
        if ("download" in document.createElement("a")) {
          const elink = document.createElement("a");
          elink.download = filename;
          elink.style.display = "none";
          elink.href = URL.createObjectURL(blob);
          document.body.appendChild(elink);
          elink.click();
          URL.revokeObjectURL(elink.href);
          document.body.removeChild(elink);
        } else {
          navigator.msSaveBlob(blob, filename);
        }
      })
      .catch((r) => {
        console.error(r);
        Message({
          message: "下载失败",
          type: "error",
          duration: messageDuration,
        });
      });
  },

  delete(url, params) {
    let _params;
    if (Object.is(params, undefined)) {
      _params = "";
    } else {
      _params = "?";
      for (const key in params) {
        // eslint-disable-next-line no-prototype-builtins
        if (params.hasOwnProperty(key) && params[key] !== null) {
          _params += `${key}=${params[key]}&`;
        }
      }
    }
    return service.delete(`${url}${_params}`);
  },
};

function tansParams(params) {
  let result = "";
  Object.keys(params).forEach((key) => {
    if (!Object.is(params[key], undefined) && !Object.is(params[key], null)) {
      result +=
        encodeURIComponent(key) + "=" + encodeURIComponent(params[key]) + "&";
    }
  });
  return result;
}

export default request;
