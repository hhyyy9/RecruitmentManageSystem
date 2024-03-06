<template>
  <div class="position_list">
    <img src="@/assets/imgs/Logo.png" alt class="logo" />
    <div v-if="dataList.length > 0" class="quanyi-list">
      <div v-for="(item, index) in dataList" :key="index">
        <Job-list @checkCandidate="checkCandidate" :tableData="item" />
      </div>

      <div class="bottom-text">It is the end~</div>
    </div>
  </div>
</template>

<script>
import { getpositionlist } from "@/utils/api-new";
const JobList = () => import("./components/JobList");
import { Field, Toast } from "vant";
export default {
  name: "Login",
  data() {
    return {
      dataList: [],
      applyData: {},
    };
  },
  components: {
    [Field.name]: Field,
    [Toast.name]: Toast,
    JobList,
  },

  created() {
    //Toast.setDefaultOptions({ duration: 200000 });
    this.getList();
  },
  activated() {},
  destroyed() {},
  methods: {
    getList() {
      let _that = this;
      getpositionlist({}).then((res) => {
        if (res.error_no == 0) {
          _that.dataList = res.data.list;
        }
      });
    },

    //apply job
    checkCandidate(data) {
      this.applyData = data;
      this.$router.push({
        path: "Candidate_List",
        query: { data: JSON.stringify(data) },
      });
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
