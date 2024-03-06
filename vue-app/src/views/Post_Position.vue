<template>
  <div class="position_list">
    <img src="@/assets/imgs/Logo.png" alt class="logo" />
    <van-form @submit="onSubmit">
      <van-field
        style="min-height: 80px"
        v-model="position_name"
        name="position name"
        label="position name"
        placeholder="position name"
        autosize
        :rules="[{ required: true, message: 'please input position name' }]"
      />
      <van-field
        style="min-height: 80px"
        v-model="planed_hired_num"
        name="planed hired num"
        label="planed hired num"
        placeholder="hired num"
        autosize
        :rules="[{ required: true, message: 'please input planed hired num' }]"
      />

      <van-field
        style="min-height: 80px"
        v-model="desc"
        name="description"
        label="description"
        placeholder="description"
        autosize
        :rules="[{ required: true, message: 'please input description' }]"
      />

      <van-field
        style="min-height: 80px"
        v-model="employer_id"
        name="employer Id"
        label="employer Id"
        placeholder="employer Id"
        autosize
        :rules="[{ required: true, message: 'please input employer Id' }]"
      />

      <van-field
        style="min-height: 80px"
        v-model="employer_icon"
        name="employer icon"
        label="employer icon"
        placeholder="employer icon"
        autosize
        :rules="[{ required: true, message: 'please input employer icon' }]"
      />

      <van-field
        style="min-height: 80px"
        v-model="start_time"
        name="start time"
        label="start time"
        placeholder="start time"
        autosize
        :rules="[{ required: true, message: 'please input start time' }]"
      />
      <van-field
        style="min-height: 80px"
        v-model="end_stime"
        name="end stime"
        label="end stime"
        placeholder="end stime"
        autosize
        :rules="[{ required: true, message: 'please input end stime' }]"
      />
      <div style="margin: 16px">
        <van-button round block type="info" native-type="submit"
          >submit</van-button
        >
      </div>
    </van-form>
  </div>
</template>

<script>
import { publishposition } from "@/utils/api-new";
import { Button, Field, Toast, CellGroup, Cell, Form } from "vant";
export default {
  name: "Login",
  data() {
    return {
      position_name: "",
      planed_hired_num: null,
      desc: "",
      start_time: "",
      end_stime: "",
      dataList: [],
      employer_id: null,
      employer_icon: "",
    };
  },
  components: {
    [Button.name]: Button,
    [Field.name]: Field,
    [Toast.name]: Toast,
    [CellGroup.name]: CellGroup,
    [Cell.name]: Cell,
    [Form.name]: Form,
  },

  created() {},
  activated() {},
  destroyed() {},
  methods: {
    onSubmit() {
      let _that = this;
      publishposition({
        position_name: this.position_name,
        planed_hired_num: parseInt(this.planed_hired_num),
        desc: this.desc,
        employer_id: parseInt(this.employer_id),
        employer_icon: this.employer_icon,
        start_time: this.start_time,
        end_stime: this.end_stime,
      }).then((res) => {
        if (res.error_no == 0) {
          Toast("Publish Successful");
        } else {
          Toast(res.error_message);
        }
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
}
</style>
