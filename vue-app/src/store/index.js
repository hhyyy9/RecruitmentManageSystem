import Vue from 'vue'
import Vuex from 'vuex'
// import persistedState from 'vuex-persistedstate'
import VuexPersistence from 'vuex-persist'

const vuexLocal = new VuexPersistence({
    storage: window.localStorage
})
Vue.use(Vuex)

export default new Vuex.Store({
 plugins: [vuexLocal.plugin],
  state: {
    userName: "",
    SMSCode: "",
    userInfo: "",
    uid:"",
    uidToken:"",
    isMini: "",
    cardType:"",
    token:'',
    phone:'',
  },
  mutations: {
     SET_USER_NAME: (state, userName) => {
      state.userName = userName;
    },
    SET_SMS_CODE: (state,SMSCode) => {
      state.SMSCode = SMSCode;
    },
    SET_USER_INFO: (state,userInfo) => {
      state.userInfo = userInfo;
    },
    SET_UID: (state,uid) => {
      state.uid = uid;
    },
    SET_uidToken: (state,uidToken) => {
      state.uidToken = uidToken;
    },

    SET_isMini: (state,isMini) => {
      state.isMini = isMini;
    },

    SET_cardType: (state,cardType) => {
      state.cardType = cardType;
    },

    SET_token:(state,token) => {
      state.token = token;
    },

    SET_phone:(state,phone) => {
      state.phone = phone;
    },
    

     // 定义全局的清理方法
    RESET_ALL_STATE(state, payload) {
      state.uid = '';
      state.userName = '';
      state.SMSCode = '';
      state.userInfo = '';
      state.uidToken = "";
      state.cardType = '';
    }
  },
  actions: {
    
    
  },
  modules: {

  }
})
