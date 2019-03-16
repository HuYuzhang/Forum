<template>
  <section>
    <el-container>
      <el-main>
        <el-row>
          <el-input v-model="jumpto" placeholder="input target page"></el-input>
          <el-button @click="jump">jump</el-button>
        </el-row>
        <el-row v-for="reply in postreply" type="flex">
          <el-row type="flex">
            <el-card class="nick-card">
              <br>
              <br>
              <el-row>
                <div class="nickname">{{ reply.username }}</div>
              </el-row>
              <el-row>
                <div class="nickname">
                  <el-button @click="seepeople(reply.username)">个人主页</el-button>
                </div>
              </el-row>
              <el-row>
                <div class="postdate">{{ reply.time }}</div>
              </el-row>
              <el-row>
                <div class="postdate">楼层： {{ reply.floor }}</div>
              </el-row>
            </el-card>

            <el-card class="box-card">
              <div class="text">{{ reply.content }}</div>
              <div>
                <el-col :offset="20">
                  <el-button v-on:click="onZan(reply.floor)" type="danger" size="small">点赞</el-button>
                </el-col>
              </div>
            </el-card>
          </el-row>
        </el-row>
        <el-row class="reply" type="flex">
          <el-input v-model="tmpreply" placeholder="说一说你的想法吧"></el-input>
          <el-button @click="reply">回复</el-button>
        </el-row>
      </el-main>
    </el-container>
  </section>
</template>
  <script type="text/ecmascript-6">
export default {
  // 这里我们认为，回复人，回复内容，回复层数都已经包含在replys中了
  props: ["postreply", "postinfo", "urlprefix"],
  data() {
    return {
      tmpreply: "",
      jumpto: "0",
    };
  },
  methods: {
    onZan(floor) {
      // console.log("你点赞了");
      // console.log(index);
      // this.replys[index].zan++;
      // this.$emit("dianzan", floor);
      // I decide not to show the likeNum... then I can avoid jump between App.vue and post.vue... so vegetable
      var url = this.urlprefix + "/post/like.php";
      this.$http
        .post(url, {
          postID: this.postinfo.postID,
          floor: floor
        })
        .then(response => {
          if (response.statusCode === "0") {
            alert("点赞成功");
          } else {
            alert("点赞失败");
          }
        })
        .catch(res => {
          console.log("Error in like");
          console.log(res);
        });
    },
    onSubmit() {
      this.$message("模拟数据，这个方法并不管用哦~");
    },
    seepeople(username) {
      this.$emit("scanpeople", username);
    },
    reply() {
      this.$emit("replypost", this.tmpreply);
    },
    jump() {
      this.$emit("scanpost", this.postinfo.postID, this.jumpto);
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

.row-bg {
  padding: 10px 0;
  background-color: #f9fafc;
}

.text {
  height: 200px;
  width: 800px;
  font-size: 20px;
  margin-left: 100px;
  margin-right: 100px;
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
  font-size: 20px;
  text-align: center;
}

.nick-card {
  width: 200px;
  height: 300px;
}

.box-card {
  width: 1200px;
  height: 300px;
  line-height: 30px;
}
.reply {
  width: 800px;
  margin-left: 20px;
}
</style>