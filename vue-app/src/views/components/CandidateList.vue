<template>
  <div class="gift-div">
    <div class="title-pic">
      <div class="left-view">
        <div class="right-title">apply Id: {{ tableData.applied_id }}</div>
        <div>Apply status:</div>
        <van-tag v-if="tableData.status == 1" type="success">pass</van-tag>
        <van-tag v-if="tableData.status == 2" type="danger">reject</van-tag>
        <van-tag v-if="tableData.status == 0" type="warning"
          >wait to be reviewed</van-tag
        >
      </div>

      <div class="right-button" @click="CheckApply(tableData)">Edit Aplly</div>
    </div>
    <div class="des-title">Application Open: {{ tableData.start_time }}</div>
    <div class="des-title">Application Close: {{ tableData.end_time }}</div>
    <div class="des-title">Position name: {{ tableData.position_name }}</div>
    <div class="gift-content">
      <div class="des-title">Describe: /n{{ tableData.desc }}</div>
      <div class="des-title-big">Salary: {{ tableData.salary_range }}</div>
    </div>
  </div>
</template>

<script>
import { parseTime, dateStrChangeTimeTamp } from "@/utils/timeFormat.js";
import { Tag } from "vant";

export default {
  name: "CandidateList",
  components: {
    [Tag.name]: Tag,
  },
  data() {
    return {
      kongge: "",
      time: 0,
    };
  },
  filters: {
    startTimeFilter(value, data) {
      var d = new Date();
      var time = parseTime(d, "{y}-{m}-{d} {h}:{i}:{s}");
      //当前时间时间戳
      var timeNow = dateStrChangeTimeTamp(time);

      var startTime = dateStrChangeTimeTamp(value);

      let time11 = startTime - timeNow;
      // debugger;
      return time11;
    },
    timeFilter(value, data) {
      var d = new Date();
      var time = parseTime(d, "{y}-{m}-{d} {h}:{i}:{s}");
      //当前时间时间戳
      var timeNow = dateStrChangeTimeTamp(time);
      var endTime = dateStrChangeTimeTamp(value);
      let time11 = endTime - timeNow;
      // debugger;
      return time11;
    },
  },
  props: {
    tableData: {
      type: Object,
      default: () => {},
    },
  },
  mounted() {},
  methods: {
    toDetail(item) {
      // console.log(item);
    },
    Apply(tableData) {
      this.$emit("ApplyJob", tableData);
    },
  },
  watch: {
    tableData(old) {},
  },
};
</script>

<style lang="scss" scoped>
.gift-div {
  margin: 2.3vw 0vw 0 0vw;
  .title-pic {
    margin: 5.3vw 0vw 0 4.8vw;
    width: 90.4vw;
    height: 6.1vw;
    display: flex;
    justify-content: space-between;
    .left-view {
      display: flex;
      .left-pic {
        width: 6.6vw;
        height: 5.6vw;
        background: url(../../assets/imgs/Google.png) no-repeat;
        background-size: contain;
      }
      .right-title {
        font-size: 5vw;
        margin-left: 1.7vw;
        margin-top: -0.5vw;
        font-family: "PingFang-RE";
        display: flex;
        background-image: linear-gradient(
          to right,
          rgba(200, 162, 128, 1),
          rgba(76, 41, 17, 1)
        );
        -webkit-background-clip: text;
        color: transparent;
      }
    }

    .right-button {
      height: 4.5vw;
      background: rgb(23, 113, 248);
      color: white;
      padding: 0.5vw 1vw 1vw 1vw;
      font-size: 4vw;
      border-radius: 1%;
    }
  }
  .des-title {
    margin: 3vw 0vw 0 4.8vw;
    font-size: 4vw;
    color: #61361c;
    // text-align: center;
  }
  .gift-content {
    margin: 2.3vw 2.5vw 10vw 2.8vw;

    min-height: 15vw;
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    // background: yellow;
    .des-title {
      margin: 3vw 0vw 0 4.8vw;
      font-size: 4vw;
      color: #61361c;
      // text-align: center;
    }
    .des-title-big {
      margin: 3vw 0vw 0 4.8vw;
      font-size: 4vw;
      color: #61361c;
      font-size: 6vw;
    }
  }
}
</style>
