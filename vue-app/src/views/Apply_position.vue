<template>
  <div class="position_list">
    <van-form @submit="onSubmit">
      <van-field
        style="min-height: 80px"
        v-model="email"
        name="email"
        label="email"
        placeholder="email"
        autosize
        :rules="[{ required: true, message: 'please input email' }]"
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
import { getpositionlist, updateposition } from "@/utils/api-new";
import { Button, Field, Toast, CellGroup, Cell, Form } from "vant";
export default {
  name: "Login",
  data() {
    return {
      email: "",
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

  created() {
    //Toast.setDefaultOptions({ duration: 200000 });
  },
  activated() {},
  destroyed() {},
  methods: {
    onSubmit() {},
    getList() {
      let _that = this;
      getpositionlist({}).then((res) => {
        if (res.error_no == 0) {
          _that.dataList = res.data.list;
        }
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.position_list {
  background: red($color: #000000);
}
</style>
