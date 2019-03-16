<template>
  <section>
    <el-container>
      <el-main>
        <el-row>
            <el-button @click="topclick">最多点击</el-button>
            <el-button @click="topreply">最多访问</el-button>
            <el-input v-model="hotblock" placeholder="输入你想查询的版块ID"></el-input>
            <el-button @click="tophot">热度最高</el-button>
            <el-button @click="topactive">最多发帖</el-button>
            <el-button @click="topavg">大于平均</el-button>
        </el-row>
        <div v-if="seeclick === true">
          <el-row><h1 style="font-size: 60px">最多点击的帖子</h1></el-row>
          <el-row v-for="post in mostclick" type="flex">
            <el-row type="flex">
              <el-card class="box-card">
                <div class="text">{{ post.title }}</div>
                <div class="bt">
                  <el-col :offset="60">
                    <el-button @click="scanPost(post.postID)" type="danger" size="small">查看帖子</el-button>
                  </el-col>
                  <br>
                  <br>
                  <el-col :offset="60">
                    <el-button v-if="userinfo.identity === 'ADMIN'" @click="deletePost(post.postID)" type="danger" size="small">删除帖子</el-button>
                  </el-col>
                  <el-col :offset="60">
                    <el-button v-if="userinfo.identity === 'ADMIN'" @click="deletePost(post.postID)" type="danger" size="small">删除帖子</el-button>
                  </el-col>
                </div>
              </el-card>
            </el-row>
          </el-row>
        </div>
        <div v-if="seereply === true">
        <el-row><h1 style="font-size: 60px">最多回复的帖子</h1></el-row>
        <el-row v-for="post in mostreply" type="flex">
          <el-row type="flex">
            <!-- <el-card class="nick-card">
              <br>
              <br>
              <el-row ><div class="nickname">{{ post.title }}</div></el-row>
              <el-row><div class="nickname"><el-button @click="seepeople(post.username)">个人主页</el-button></div></el-row>
              <el-row ><div class="postdate">{{ post.date }}</div></el-row>
            </el-card>-->
            <el-card class="box-card">
              <div class="text">{{ post.title }}</div>
              <div class="bt">
                <el-col :offset="60">
                  <el-button @click="scanPost(post.postID)" type="danger" size="small">查看帖子</el-button>
                </el-col>
                <br>
                <br>
                <el-col :offset="60">
                  <el-button v-if="userinfo.identity !== 'NORMAL'" @click="deletePost(post.postID)" type="danger" size="small">删除帖子</el-button>
                </el-col>
              </div>
            </el-card>
          </el-row>
        </el-row>
        </div>
        <div v-if="seehot === true">
        <el-row><h1 style="font-size: 60px">热度最高的帖子:</h1></el-row>
        <el-row v-for="user in hotquery" type="flex">
          <el-row type="flex">
            <el-card class="box-card">
              <div class="text">{{ user.postername }}</div>
            </el-card>
          </el-row>
        </el-row>
        </div>
        <div v-if="seeactive === true">
        <el-row><h1 style="font-size: 60px">最活跃的用户:</h1></el-row>
        <el-row v-for="user in active" type="flex">
          <el-row type="flex">
            <el-card class="box-card">
              <div class="text">{{ user.username }}</div>
              <br>
              <div class="text">{{ user.posttime }}</div>
            </el-card>
          </el-row>
        </el-row>
        </div>
        <div v-if="seeavg === true">
        <el-row><h1 style="font-size: 60px">点击数大于平均点击数的帖子</h1></el-row>
        <el-row v-for="post in avg" type="flex">
          <el-row type="flex">
            <el-card class="box-card">
              <div class="text">{{ post.postID }}</div>
            </el-card>
          </el-row>
        </el-row>
        </div>
      </el-main>
    </el-container>
  </section>
</template>
<script type="text/ecmascript-6">
// I decide to add the function of delete post in this file, use v-if to hide the button if user is not an admin
export default {
  props: ["mostclick", "mostreply", "urlprefix", "userinfo"],
  data() {
    return {
      seeclick: false,
      seereply: false,
      seehot: false,
      seeactive: false,
      seeavg: false,
      hotblock: "",
      hotquery: "",
      hotid: "",
      active: "",
      avg: "",
    };
  },
  created() {
  },
  methods: {
    topavg() {
      var url = this.urlprefix + "/find/findactivepost.php";
      this.$http
        .post(url, {
          "blockID": this.hotblock,
        })
        .then(response => {
          response = response.body;
          if (response.statusCode === "0") {
            this.avg = response.result;
            this.seeclick = false;
            this.seereply = false;
            this.seehot = false;
            this.seeactive = false;
            this.seeavg = true;
          } else if (response.statusCode === "1") {
            alert("查询失败！");
          }
        })
        .catch(res => {
          console.log("Error in find active post");
          console.log(res);
        });
    },
    topactive() {
      var url = this.urlprefix + "/find/finduser.php";
      this.$http
        .post(url, {
          "blockID": this.hotblock,
        })
        .then(response => {
          response = response.body;
          if (response.statusCode === "0") {
            this.active = response.userlist;
            this.seeclick = false;
            this.seereply = false;
            this.seehot = false;
            this.seeactive = true;
            this.seeavg = false;
          } else if (response.statusCode === "1") {
            alert("查询失败！");
          }
        })
        .catch(res => {
          console.log("Error in find active");
          console.log(res);
        });
    },
    topclick() {
      this.$emit('topclick');
      this.seeclick = true;
      this.seereply = false;
      this.seehot = false;
      this.seeactive = false;
      this.seeavg = false;
    },
    topreply() {
      this.$emit('topreply');
      this.seeclick = false;
      this.seereply = true;
      this.seehot = false;
      this.seeactive = false;
      this.seeavg = false;
    },
    tophot() {
      var url = this.urlprefix + "/find/findhotestpost.php";
      this.$http
        .post(url, {
          "blockID": this.hotblock,
        })
        .then(response => {
          response = response.body;
          if (response.statusCode === "0") {
            this.hotquery = response.result;
            this.hotid = response.postID;
            this.seeclick = false;
            this.seereply = false;
            this.seehot = true;
            this.seeactive = false;
            this.seeavg = false;
          } else if (response.statusCode === "1") {
            alert("查询失败！");
          }
        })
        .catch(res => {
          console.log("Error in find hottest");
          console.log(res);
        });
    },
    scanPost(id) {
      this.$emit('scanpost', id, "0");
      this.$emit('topclick');
      this.$emit('topreply');
    },
    deletePost(postID) {
      console.log('now delete post in most');
      var url = this.urlprefix + "/manager/deletepost.php";
      this.$http
        .post(url, {
          postID: postID,
          username: this.userinfo.username
        })
        .then(response => {
          response = response.body;
          console.log(response);
          if (response.statusCode === "0") {
            alert("删除成功");
          } else if (response.statusCode === "1") {
            alert("权限不足");
          } else {
            alert("目标帖子不存在");
          }
        })
        .catch(res => {
          console.log("Error in delete a post");
          console.log(res);
        });
      this.$emit('topclick');
      this.$emit('topreply');
    }
  }
};
</script>
<style scoped>
.el-row {
  margin-bottom: 20px;
}

.el-col {
  border-radius: 4px;
}

.bg-purple-dark {
  background: #99a9bf;
}

.bg-purple {
  background: #d3dce6;
}

.bg-purple-light {
  background: #e5e9f2;
}

.grid-content {
  border-radius: 4px;
  min-height: 36px;
}

.bt {
  margin-left: 1000px;
}
.row-bg {
  padding: 10px 0;
  background-color: #f9fafc;
}

.text {
  height: 50px;
  width: 800px;
  font-size: 60px;
  margin-left: 300px;
  /* margin-right: 100px; */
  padding: 18px 0;
  /* height: 200px; */
  vertical-align: middle；;
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

.nick-card {
  width: 200px;
  height: 300px;
}

.box-card {
  width: 1200px;
  height: 200px;
  line-height: 30px;
}
</style>