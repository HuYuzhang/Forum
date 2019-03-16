<template>
  <section class="form-section">
    <el-row class='infotype'>
      <!-- Below is the basic personal info -->
      <el-card class="box-info">
        <div class="nickname">
          <span>用户名： {{guestinfo.username}}</span>
          <!-- <el-button style="float: right; padding: 3px 0" type="text">查看发帖</el-button>
          <el-button style="float: right; padding: 3px 0" type="text">查看回复</el-button> -->
        </div>
        <div class="infotext">
          昵称： {{guestinfo.nickname}}
        </div>
        <div class="infotext">
          生日： {{guestinfo.birthday}}
        </div>
        <div class="infotext">
          性别： {{guestinfo.gender}}
        </div>
        <div class="infotext">
          电子邮箱： {{guestinfo.email}}
        </div>
        <div class="infotext">
          分数： {{guestinfo.score}}
        </div>
        <div class="infotext">
          注册日期： {{guestinfo.signdate}}
        </div>
      </el-card>
    </el-row>
    <!-- <el-row>
      <div class="header">发帖信息</div>
      <el-row v-for="post in userinfo.posts" type="flex">
        <el-row type="flex">
          <el-card class="nick-card">
            <br>
            <br>
            <el-row>
              <div class="nickname">{{ post.nickname }}</div>
            </el-row>
            <el-row>
              <div class="postdate">{{ post.date }}</div>
            </el-row>
          </el-card>

          <el-card class="box-card">
            <div class="text">{{ post.title }}</div>
            <div>
              <el-col :offset="20">
                <el-button @click="scanPost(post.id)" type="danger" size="small">查看帖子</el-button>
              </el-col>
            </div>
          </el-card>
        </el-row>
      </el-row>
    </el-row>
    <br>
    <br>
    <br>
    <br>
    <el-row>
      <div class="header">回复信息</div>
      <el-row v-for="(reply, index) in userinfo.replys" type="flex">
        <el-row type="flex">
          <el-card class="nick-card">
            <br>
            <br>
            <el-row>
              <div class="nickname">{{ reply.nickname }}</div>
            </el-row>
            <el-row>
              <div class="nickname">
              </div>
            </el-row>
            <el-row>
              <div class="postdate">{{ reply.date }}</div>
            </el-row>
            <el-row>
              <div class="postdate">楼层： {{ reply.floor }}</div>
            </el-row>
          </el-card>

          <el-card class="box-card">
            <div class="text">{{ reply.title }}</div>
            <div>
              <el-col :offset="20">
              </el-col>
            </div>
          </el-card>
        </el-row>
      </el-row>
    </el-row> -->
  </section>
</template>
<script scoped>
  export default {
    props: ["guestinfo"],
    data() {
      return {
      };
    },
    methods: {
      // scanPost(id) {
      //   this.$emit('scanpost', id);
      // },
    }
  }
</script>
<style scoped>
  .header {
    font-size: 50px;
    /* line-height: 40px; */
    /* text-align: center; */
  }

  .infotext {
    font-size: 20px;
    margin-left: 50px;
    line-height: 40px;
    /* text-align: center; */
  }

  .nickname {
    font-size: 50px;
    margin-left: 30px;
    /* margin-right: 30px; */
    text-align: center;
  }

  .postdate {
    font-size: 30px;
    margin-left: 30px;
    text-align: center;
  }

  .text {
    height: 200px;
    width: 800px;
    font-size: 20px;
    margin-left: 100px;
    margin-right: 100px;
    padding: 18px 0;
    /* height: 200px; */
    vertical-align: middle；
  }

  .infotype {
    width: 1200px;
    margin-left: 500px;
    margin-right: 100px;
  }

  .item {
    padding: 18px 0;
  }


  .nick-card {
    width: 200px;
    height: 300px;
  }

  .box-info {
    width: 400px;
    height: 300px;
  }

  .box-card {
    width: 1200px;
    height: 300px;
    line-height: 30px;
  }
</style>