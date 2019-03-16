<template>
  <section>
    <el-container>
      <el-main>
        <el-row>
          <el-radio-group v-model="chooseBlock">
            <el-radio v-for="block in blocks" label="block.blockID">{{ block.name }}</el-radio>
          </el-radio-group>
        </el-row>
        <el-row v-for="user in userlist.content" type="flex">
          <el-row type="flex">
            <el-card class="box-card">
              <div class="text">{{ user.username }}</div>
              <div class="bt">
                <el-col :offset="60">
                  <el-button @click="deleteUser(user.userID)" type="danger" size="small">删除用户</el-button>
                  <el-button @click="assignowner(user.userID)" type="danger" size="small">任命版主</el-button>
                </el-col>
              </div>
            </el-card>
          </el-row>
        </el-row>
        <el-row>
          <el-input v-model="jumpto" placeholder="input target page"></el-input>
          <el-button @click="jump">jump</el-button>
        </el-row>
      </el-main>
    </el-container>
  </section>
</template>
<script type="text/ecmascript-6">
// Now I decide to add the function to assign the new blockowner here, though it seems different with the "deleteUser.vue"
export default {
  props: ["userlist", "blocks"],
  data() {
    return {
      jumpto: "0",
      chooseBlock: ""
    };
  },
  methods: {
    deleteUser(id) {
      this.$emit("deleteuser", id);
    },
    assignowner(id) {
      this.$emit("assignowner", id, this.chooseBlock);
    }
  },
  created() {},
};
</script>
<style>
.el-pagination {
  text-align: center;
  margin-top: 30px;
}
.el-message-box__btns .cancel {
  float: right;
  margin-left: 10px;
}
</style>
