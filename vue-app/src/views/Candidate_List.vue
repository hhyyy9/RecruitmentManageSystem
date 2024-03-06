<template>
  <div class="position_list">
    <img src="@/assets/imgs/Logo.png" alt class="logo" />
    <div v-if="dataList.length > 0" class="quanyi-list">
      <div v-for="(item, index) in dataList" :key="index">
        <Candidate-list @CheckApply="CheckApply" :tableData="item" />
      </div>

      <div class="bottom-text">It is the end~</div>
    </div>
    <van-dialog
      v-model="bindShow"
      title="Edit Apply Info"
      show-cancel-button
      style="width: 90%"
      confirm-button-text="Pass"
      cancel-button-text="Reject"
      @confirm="confirmApply"
      @cancel="canCelApply"
    >
      <div class="apply_div">Please 'Pass' or 'Reject' this request!</div>
    </van-dialog>
  </div>
</template>

<script>
import { getappliedinfolist, editappliedinfo } from "@/utils/api-new";
const CandidateList = () => import("./components/CandidateList");
import { Toast, Dialog } from "vant";
export default {
  name: "Login",
  data() {
    return {
      dataList: [],
      bindShow: false,
      tableData: {},
      applyData: {},
    };
  },
  components: {
    [Toast.name]: Toast,
    [Dialog.Component.name]: Dialog.Component,
    CandidateList,
  },

  created() {
    //Toast.setDefaultOptions({ duration: 200000 });
    let _that = this;
    if (this.$route.query.data) {
      this.tableData = JSON.parse(this.$route.query.data);
      this.getList();
    }
  },
  activated() {},
  destroyed() {},
  methods: {
    confirmApply() {
      editappliedinfo({
        applied_id: this.applyData.applied_id,
        status: 1,
        has_mailed: true,
      }).then((res) => {
        if (res.error_no == 0) {
          Toast(" Change Successful!");
          this.bindShow = false;
          this.getList();
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
      getappliedinfolist({
        employer_id: this.tableData.employer_id,
        position_id: this.tableData.position_id,
      }).then((res) => {
        if (res.error_no == 0) {
          _that.dataList = res.data.list;
        }
      });
    },
    //apply job
    CheckApply(data) {
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
