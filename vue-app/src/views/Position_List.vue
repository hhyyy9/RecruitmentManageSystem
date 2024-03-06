<template>
  <div class="position_list">
    <img src="@/assets/imgs/Logo.png" alt class="logo" />
    <div v-if="dataList.length > 0" class="quanyi-list">
      <div v-for="(item, index) in dataList" :key="index">
        <quanyi-list @ApplyJob="ApplyJob" :tableData="item" />
      </div>

      <div class="bottom-text">It is the end~</div>
    </div>
    <van-dialog
      v-model="bindShow"
      title="Apply Position"
      show-cancel-button
      style="width: 90%"
      confirm-button-text="Apply"
      cancel-button-text="Cancle"
      @confirm="confirmApply"
      @cancel="canCelApply"
    >
      <div class="apply_div">
        Please input you Email, And we will be contact with you immediately
      </div>
      <van-field
        v-model="emailValue"
        label="Email"
        left-icon="fire"
        placeholder="You Email"
      />
    </van-dialog>
  </div>
</template>

<script>
import { getpositionlist, apply } from "@/utils/api-new";
const QuanyiList = () => import("./components/QuanyiList");
import { CellGroup, Field, Toast, Dialog } from "vant";
export default {
  name: "Login",
  data() {
    return {
      dataList: [],
      bindShow: false,
      emailValue: "",
      applyData: {},
    };
  },
  components: {
    [Field.name]: Field,
    [Toast.name]: Toast,
    [Dialog.Component.name]: Dialog.Component,
    QuanyiList,
  },

  created() {
    //Toast.setDefaultOptions({ duration: 200000 });
    this.getList();
  },
  activated() {},
  destroyed() {},
  methods: {
    confirmApply() {
      apply({
        candidate_email: this.emailValue,
        position_id: this.applyData.position_id,
      }).then((res) => {
        if (res.error_no == 0) {
          Toast(" Apply Successful!");
          this.bindShow = false;
        } else {
          Toast(res.error_message);
          this.bindShow = false;
        }
      });
    },
    canCelApply() {
      this.bindShow = false;
    },
    getList() {
      let _that = this;
      getpositionlist({}).then((res) => {
        if (res.error_no == 0) {
          _that.dataList = res.data.list;
        }
      });
    },
    //apply job
    ApplyJob(data) {
      this.bindShow = true;
      this.applyData = data;
    },
  },
};
</script>

<style lang="scss" scoped>
.position_list {
  background: red($color: #000000);
  .logo {
    width: 182px;
    height: 226px;
    display: block;
    margin: 0 auto;
    margin-top: 20px;
    margin-bottom: 20px;
  }
  .apply_div {
    font-size: 3.5vw;
    padding: 3vw;
  }
  .quanyi-list {
    // background: red;
    margin-bottom: 43vw;
  }
  .bottom-text {
    margin-top: 5vw;
    width: 100%;
    text-align: center;
    color: #999999;
    font-size: 3.5vw;
  }
}
</style>
