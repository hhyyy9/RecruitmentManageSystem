<template>
  <div class="login">
    <img src="@/assets/imgs/Logo.png" alt class="logo" />
    <div class="text_1">Login to system</div>
    <van-cell-group>
      <van-field
        v-model="info.username"
        placeholder="please input account"
        clearable
      />
      <van-field
        v-model="info.checkcode"
        placeholder="please input password"
        clearable
      >
      </van-field>
    </van-cell-group>

    <van-button
      class="login-btn"
      @click="toLogin"
      :disabled="info.username.length <= 0 || info.checkcode.length <= 0"
    >
      <span>Login</span>
    </van-button>
  </div>
</template>

<script>
import { Button, CellGroup, Field, Toast, Checkbox, Dialog } from "vant";
import { login } from "@/utils/api-new";
export default {
  name: "Login",
  data() {
    return {
      timer: null,
      isCheckCode: false,
      agreementChecked: false,
      info: {
        username: "",
        checkcode: "",
      },
      // 验证码类型，0-登录验证码，1-完善手机号验证码(该手机号无对应uid)
      codeState: 0,
    };
  },
  components: {
    [Button.name]: Button,
    [CellGroup.name]: CellGroup,
    [Field.name]: Field,
    [Toast.name]: Toast,
    [Checkbox.name]: Checkbox,
    [Dialog.Component.name]: Dialog.Component,
  },

  created() {
    //Toast.setDefaultOptions({ duration: 200000 });
  },
  activated() {},
  destroyed() {},
  methods: {
    //登陆
    toLogin() {
      // if (this.codeState == 0) {
      login({
        account: this.info.checkcode,
        password: this.info.username,
      }).then((res) => {
        if (res.error_no == 0) {
          // this.$store.commit("SET_token", res.data.token);
          // this.$store.commit("SET_phone", res.data.phone);

          this.$router.push({
            path: "Post_Position",
            // query: { tableData: JSON.stringify(data) },
          });
        } else {
          Toast(res.msg);
        }
      });
    },
  },
};
</script>
<style lang="scss" scoped>
.login {
  padding: 133px 51px 0 51px;
  font-family: PingFangSC-Regular, PingFang SC;

  .logo {
    width: 182px;
    height: 226px;
    display: block;
    margin: 0 auto;
  }

  .text_1 {
    line-height: 50px;
    color: #17181a;
    font-size: 36px;
    margin-top: 43px;
    margin-bottom: 29px;
    text-align: left;
    font-weight: 400;
  }

  .allowed {
    background: -ms-linear-gradient(
      left,
      rgb(246, 170, 110),
      rgb(223, 109, 52)
    );
    background: -o-linear-gradient(left, rgb(246, 170, 110), rgb(223, 109, 52));
    background: -webkit-linear-gradient(
      left,
      rgb(246, 170, 110),
      rgb(223, 109, 52)
    );
    color: #ffffff;
  }

  .visibleDiv {
    visibility: visible;
  }

  .agreement-check {
    margin-top: 30px;
    margin-left: 10px;
    font-size: 24px;
    color: #42464d;
    text-align: left;

    /deep/.van-checkbox__icon {
      height: 24px;
      line-height: 24px;

      .van-icon {
        width: 24px;
        height: 24px;
        line-height: 24px;
        font-size: 20px;
      }
    }

    /deep/.van-checkbox__label {
      line-height: 24px;
      margin-left: 8px;

      .agree-link {
        color: #e17c4a;
      }
    }
  }

  .login-btn {
    background: -ms-linear-gradient(
      left,
      rgb(246, 170, 110),
      rgb(247, 110, 60)
    );
    background: -o-linear-gradient(left, rgb(246, 170, 110), rgb(247, 110, 60));
    background: -webkit-linear-gradient(
      left,
      rgb(246, 170, 110),
      rgb(247, 110, 60)
    );
    color: #ffffff;
    width: 100%;
    border-radius: 52px;
    opacity: 1;
    font-size: 38px;
    font-weight: 500;
    height: 92px;
    line-height: 92px;
    margin-top: 67px;
  }

  /deep/.van-button--disabled {
    opacity: 0.55;
    background: #f6aa6f;
  }

  /deep/.van-cell {
    height: 92px;
    line-height: 92px;
    padding: 0 47px;
    border-radius: 46px;
    background-color: #f3f3f3;
    font-size: 30px;
    margin-bottom: 30px;
  }

  [class*="van-hairline"]::after {
    border: none;
  }

  /deep/.van-cell::after {
    border: none;
  }

  /deep/.van-field__control {
    color: #17181a;
    font-size: 30px;
    line-height: normal;
    height: 92px;
    padding: 30px 0;
    outline: 0;
    -webkit-appearance: none;
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
  }

  ::-webkit-input-placeholder {
    font-size: 30px;
  }

  /* Firefox 4-18 */
  :-moz-placeholder {
    font-size: 30px;
  }

  /* Firefox 19-50 */
  ::-moz-placeholder {
    font-size: 30px;
  }

  /* - Internet Explorer 10–11
  - Internet Explorer Mobile 10-11 */
  :-ms-input-placeholder {
    font-size: 30px !important;
  }

  /* Edge (also supports ::-webkit-input-placeholder) */
  ::-ms-input-placeholder {
    font-size: 30px;
  }

  /* CSS Working Draft */
  ::placeholder {
    font-size: 30px;
  }

  /deep/.van-field__clear {
    font-size: 35px;
    line-height: 32px;
  }
}

/deep/.van-toast {
  min-width: 470px;
  min-height: 113px;
  line-height: 33px;
  font-size: 24px;
  border-radius: 8px;
}
</style>
