<template>
  <section>
    <el-container>
      <el-main>
        <el-row>
          <el-input v-model="jumpto" placeholder="input target page"></el-input>
          <el-row type="flex">
            <el-button @click="jump">jump</el-button>
          </el-row>
          <br>
          <h1>最大页面数{{ blockinfo.maxpage }}</h1>
        </el-row>
        <el-row v-for="post in blockcontent" type="flex">
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
        <el-row>
          <el-input v-model="tmptitle" placeholder="发帖标题"></el-input>
          <el-input v-model="tmpcontent" placeholder="发帖内容"></el-input>
          <el-button @click="newPost">
            发帖
          </el-button>
        </el-row>
      </el-main>
    </el-container>
  </section>
</template>
<script type="text/ecmascript-6">
// I decide to add the function of delete post in this file, use v-if to hide the button if user is not an admin
export default {
  props: ["blockcontent", "blockinfo", "urlprefix", "userinfo"],
  data() {
    return {
      tmptitle: '',
      tmpcontent: '',
      jumpto: "0",
    };
  },
  created() {
  },
  methods: {
    scanPost(id) {
      this.$emit('scanpost', id, "0");
    },
    newPost() {
      this.$emit('newPost', this.tmptitle, this.tmpcontent);
    },
    jump() {
      this.$emit('scanblock', this.blockinfo.blockID, this.jumpto);
      console.log("You want to jump to the page: " + this.jumpto);
    },
    deletePost(postID) {
      this.$emit('deletePost', postID);
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