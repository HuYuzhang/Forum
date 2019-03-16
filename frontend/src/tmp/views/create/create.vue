<template>
  <section class="form-section">
    <el-form
      :model="ruleForm"
      :rules="rules"
      ref="ruleForm"
      label-width="100px"
      class="demo-ruleForm"
    >
      <el-form-item label="账号" prop="username">
        <el-input v-model="ruleForm.username" placeholder="请输入账号"></el-input>
      </el-form-item>

      <el-form-item label="密码" prop="password">
        <!-- 诶真的是起了怪了，下面两行只是交换了属性的顺序，但是第一行的写法会导致完全不能隐藏密码，究竟是为什么... -->
        <!-- <el-input v-model="ruleForm.password" type='"password"'></el-input> -->
        <el-input type="password" v-model="ruleForm.password" placeholder="请输入密码"></el-input>
      </el-form-item>

      <el-form-item label="重复密码" prop="password_again">
        <el-input
          type="password"
          v-model="ruleForm.password_again"
          v-on:blur="check_with_password"
          placeholder="请再次输入密码"
        ></el-input>
      </el-form-item>

      <el-form-item label="昵称" prop="nickname">
        <el-input v-model="ruleForm.nickname"></el-input>
      </el-form-item>

      <el-form-item label="性别" prop="sex">
        <el-radio-group v-model="ruleForm.sex">
          <el-radio label="male">男</el-radio>
          <el-radio label="female">女</el-radio>
        </el-radio-group>
      </el-form-item>

      <el-form-item label="生日" required>
        <el-row>
          <el-form-item prop="date">
            <el-date-picker
              type="date"
              placeholder="选择你的生日"
              v-model="ruleForm.birthday"
              style="width: 100%;"
            ></el-date-picker>
          </el-form-item>
        </el-row>
      </el-form-item>

      <el-form-item label="邮箱" prop="email">
        <el-input v-model="ruleForm.email"></el-input>
      </el-form-item>
    </el-form>
    <el-row type="flex" justify="center">
      <el-button type="primary" round v-on:click="Summit">马上注册</el-button>
    </el-row>
  </section>
</template>
<script>
export default {
  props: ["urlprefix"],
  data() {
    return {
      ruleForm: {
        username: "",
        password: "",
        password_again: "",
        nickname: "",
        sex: "male",
        birthday: "",
        email: ""
      },
      rules: {
        username: [
          { required: true, message: "请输入账号", trigger: "blur" },
          { min: 3, max: 20, message: "长度在 3 到 20 个字符", trigger: "blur" }
        ],
        password: [{ required: true, message: "请输入密码", trigger: "blur" }],
        nickname: [{ required: true, message: "请输入昵称", trigger: "blur" }],
        sex: [{ required: true, message: "请选择性别", trigger: "blur" }],
        birthday: [{ required: true, message: "请选择生日", trigger: "blur" }],
        email: [{ required: true, message: "请输入邮箱", trigger: "blur" }]
        // password_again: [
        //   {validator: validatePass, trigger: 'blue'}
        // ]
      }
    };
  },
  methods: {
    check_with_password() {
      if (this.ruleForm.password !== this.ruleForm.password_again) {
        alert("两次输入的密码不一致！");
        this.ruleForm.password_again = "";
      }
    },

    Summit() {
      // console.log(typeof this.ruleForm.birthday);
      this.$message({
        message: "注册成功，请登陆",
        type: "success"
      });
      var url = this.urlprefix + "/user/signup.php";
      this.$http
        .post(url, {
          "username": this.ruleForm.username,
          "nickname": this.ruleForm.nickname,
          "password": this.ruleForm.password,
          "birthday": this.ruleForm.birthday,
          "gender": this.ruleForm.sex,
          "email": this.ruleForm.email
        })
        .then(response => {
          // console.log(response.statusCode === 0);
          if (response.statusCode === "0") {
            this.$message({
              message: "注册成功",
              type: "success"
            });
            // 返回登陆界面
            this.$router.push("/login");
          } else if (response.statusCode === "1") {
            alert("用户名已经存在！");
          } else {
            alert("邮箱已经被绑定");
          }
        });
    }
  }
};
</script>
<style scoped>
.form-section {
  padding: 10px;
  width: 500px;
}
</style>
