<template>
  <section class="form-section">
    <el-container direction="vertical">
      <el-main>
        <el-row type="flex" justify="center">
          <div class="show-section top">
            <span>欢迎使用BBS</span>
          </div>
        </el-row>

        <el-row type="flex" justify="center">
          <el-form
            :model="ruleForm"
            :rules="rules"
            ref="ruleForm"
            label-width="100px"
            class="demo-ruleForm"
          >
            <el-row type="flex" justify="center">
              <el-form-item label="账号" prop="username">
                <el-input v-model="ruleForm.username" placeholder="请输入账号"></el-input>
              </el-form-item>
            </el-row>

            <el-row type="flex" justify="center">
              <el-form-item label="密码" prop="password">
                <el-input type="password" v-model="ruleForm.password" placeholder="请输入密码"></el-input>
              </el-form-item>
            </el-row>
          </el-form>
        </el-row>

        <el-row type="flex" justify="center">
          <el-button type="primary" round v-on:click="Summit">登陆</el-button>
        </el-row>
      </el-main>
    </el-container>
  </section>
</template>
<script>
export default {
  props: ["urlprefix"],
  data() {
    return {
      ruleForm: {
        username: "",
        password: ""
      },
      rules: {
        username: [
          { required: true, message: "请输入账号", trigger: "blur" },
          { min: 3, max: 20, message: "长度在 3 到 20 个字符", trigger: "blur" }
        ],
        password: [{ required: true, message: "请输入密码", trigger: "blur" }]
        // password_again: [
        //   {validator: validatePass, trigger: 'blue'}
        // ]
      }
    };
  },
  methods: {
    Summit() {
      console.log(
        "now press the log in" + this.ruleForm.username + this.ruleForm.password
      );
      var url = this.urlprefix + "/user/signin.php";
      this.$http
        .post(url, {
          username: this.ruleForm.username,
          password: this.ruleForm.password,
        })
        .then(response => {
          // console.log(response.statusCode === 0);
          response = response.body;
          console.log(response);
          if (response.statusCode === "0") {
            this.$message({
              message: "欢迎回来",
              type: "success"
            });
            // 告知父组件成功登陆，从而更新全局状态
            this.$emit("login", {
              username: this.ruleForm.username,
              userid: response.userID,
              identity: response.identity,
            });
            // 返回主页
            this.$router.push("/index");
          } else if (response.statusCode === "1") {
            alert("用户不存在！");
          } else {
            alert("密码错误");
          }
        })
        .catch(e => {
          console.log("ERR in login!");
          // @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@For debug
          // this.$message({
          //   message: "欢迎回来",
          //   type: "success"
          // });
          // 告知父组件成功登陆，从而更新全局状态
          // this.$emit("login", {
          //   username: "hyz",
          //   userid: "123",
          //   identity: "NORMAL",
          //   block: "",
          // });
          // // 返回主页
          // this.$router.push("/index");
          // @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@For debug
        });
      // this.$router.push("/index");
      // console.log(this.ruleForm.username);
      // console.log(this.ruleForm.password);
      // this.$emit('login', {name: 'hyz', identity: 'admin'});
      // this.$router.push('/index')
    }
  }
};
</script>
<style>
.form-section {
  padding: 10px;
  width: 500px;
}

.show-section.top {
  background-color: white;
  padding: 10px;
  margin-top: 0;
}
</style>