<template>
  <el-row class="container" style="height: 100%">
    <v-header v-on:logout="logouthand" :userinfo="userinfo"></v-header>
    <el-col :span="24" class="main">
      <el-row>
        <!-- 下面这个menu是左边的侧栏hhh。而且看起来并没有使用路由，所以是始终显示在左边的 -->
        <el-menu
          :default-active="$route.path"
          class="mar-l el-menu-vertical-demo el-col el-col-3"
          light
          router
        >
          <template v-for="(item,index) in $router.options.routes[0].children" v-if="!item.hidden">
            <el-menu-item :index="item.path">
              <i class="fa" :class="item.class"></i>
              {{item.name}}
            </el-menu-item>
          </template>
        </el-menu>
        <!-- 下面的section是着整个网页的主体(应该就像是ele-main这种？) -->
        <section class="contentCon">
          <el-col :span="21" :offset="3" class="content-wrapper">
            <transition>
              <!-- 看到了吧，这里就用到了router-view!因此能够省去大段代码的重复了 -->
              <router-view
                @login="loginhand"
                @scanblock="scanblock"
                @scanpost="scanpost"
                @replypost="replypost"
                @scanpeople="scanpeople"
                @newPost="newPost"
                @deleteuser="deleteuser"
                @assignowner="assignowner"
                :postinfo="postinfo"
                :postreply="postreply"
                :userinfo="userinfo"
                :blocks="blocks"
                :urlprefix="urlprefix"
                :blockcontent="blockcontent"
                :blockinfo="blockinfo"
                :guestinfo="guestinfo"
                :userlist="userlist"
              ></router-view>
            </transition>
          </el-col>
        </section>
      </el-row>
    </el-col>
  </el-row>
</template>
<script>
import header from "./views/header/header.vue";
// Set some global info, like user or something else
export default {
  data() {
    return {
      user: {},
      userinfo: {
        username: "null",
        nickname: "null",
        identity: "NORMAL",
        block: ""
      },
      tmpinfo: "tmpinfo",
      urlprefix: "http://192.168.43.139/forum",
      // blocks 是所有板块的名字和ID
      blocks: "",
      // blockcontent 是当前板块的内容
      blockcontent: "",
      // blockinfo包含了当前所在的板块的名字，ID, 还有页码
      blockinfo: "",
      postreply: "",
      postinfo: "",
      guestinfo: "",
      userlist: ""
    };
  },
  methods: {
    // in fact, I also want to rewrite this function...
    loginhand(e) {
      // console.log("he want to login");
      this.userinfo = e;
      console.log(this.userinfo.identity);
      this.$router.options.routes[0].children[1].hidden = true;
      this.$router.options.routes[0].children[2].hidden = true;
      if (this.userinfo.identity === "ADMIN") {
        // 删除用户和帖子
        this.$router.options.routes[0].children[4].hidden = false;
        this.$router.options.routes[0].children[5].hidden = false;
        this.getuserlist(this.userinfo.username, "0");
      }
      // Here if the user is a admin, then we should load all uer info
      // @@@@@@@@@@@@@@@for debug
      // this.blocks = [{ name: 'b1', blockID: "1" }, { name: 'b2', blockID: "2" }, { name: 'b3', blockID: "3" }];
      // @@@@@@@@@@@@@@ for debug
    },
    logouthand() {
      if (this.user.username === "null") {
        this.$message({
          message: "你又没登陆...退出个啥...",
          type: "success"
        });
        return;
      }
      this.userinfo = {
        username: "null",
        nickname: "null",
        identity: "NORMAL",
        block: ""
      };
      this.$router.options.routes[0].children[4].hidden = true;
      this.$router.options.routes[0].children[5].hidden = true;
      this.$router.options.routes[0].children[8].hidden = true;
      this.$router.options.routes[0].children[1].hidden = false;
      this.$router.options.routes[0].children[2].hidden = false;
      this.$message({
        message: "正在退出...",
        type: "success"
      });
      this.$router.push("/login");
    },
    modify(blockID, info) {
      var url = this.urlprefix + "/manager/changeinfo.php";
      this.$http
        .post(url, {
          blockID: blockID,
          username: this.userinfo.username,
          info: info
        })
        .then(response => {
          response = response.body;
          if (response.statusCode === "0") {
            alert("修改成功");
            this.getblocks();
            // then I decide to do nothing xixixi, for I'm lazy
          } else if (response.statusCode === "1") {
            alert("权限不足！");
          }
        })
        .catch(res => {
          console.log("Error in modify the info of a block");
          console.log(res);
        });
    },
    getblocks() {
      console.log("now begging to get block info");
      this.$http.post(this.urlprefix + "/post/index.php", {}).then(response => {
        response = response.body;
        this.blocks = response.result;
      });
    },
    deletePost(postID) {
      var url = this.urlprefix + "/manager/deletepost.php";
      this.$http
        .post(url, {
          postID: postID,
          username: this.userinfo.username
        })
        .then(response => {
          response = response.body;
          if (response.statusCode === "0") {
            alert("删除成功");
            this.scanblock(this.blockinfo.blockID, "0");
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
    },
    assignowner(username, blockID) {
      var url = this.urlprefix + "/manager/newblocker.php";
      this.$http
        .post(url, {
          blockID: blockID,
          targetname: username,
          username: this.userinfo.username
        })
        .then(response => {
          response = response.body;
          if (response.statusCode === "0") {
            alert("任命成功");
            // then I decide to do nothing xixixi, for I'm lazy
          } else if (response.statusCode === "1") {
            alert("权限不足！");
          } else if (response.statusCode === "2") {
            alert("目标用户不存在！");
          } else {
            alert("目标版面不存在");
          }
        })
        .catch(res => {
          console.log("Error in assign a new blockowner");
          console.log(res);
        });
    },
    getuserlist(username, page) {
      var url = this.urlprefix + "/manager/alluser.php";
      this.$http
        .post(url, {
          username: username,
          page: page
        })
        .then(response => {
          response = response.body;
          // console.log(response.statusCode === 0);
          if (response.statusCode === "0") {
            this.userlist.content = response.userlist;
            this.userlist.maxpage = response.maxpage;
          } else if (response.statusCode === "1") {
            alert("权限不足！");
          } else {
            alert("到达队尾");
          }
        })
        .catch(res => {
          console.log("Error in index to block");
          console.log(res);
        });
    },
    deleteuser(username) {
      var url = this.urlprefix + "/manager/deleteuser.php";
      this.$http
        .post(url, {
          username: this.userinfo.username,
          targetname: username
        })
        .then(response => {
          response = response.body;
          // console.log(response.statusCode === 0);
          if (response.statusCode === "0") {
            alert("成功删除");
            // then the default action is to jump to the userlist page"0"
            // so we should firstly load new userlist
            this.getuserlist(this.userinfo.username, "0");
            this.$router.push({ name: "deleteUsr" });
          } else if (response.statusCode === "1") {
            alert("权限不足");
          } else {
            alert("目标用户不存在");
          }
        })
        .catch(res => {
          console.log("Error in delete a user");
          console.log(res);
        });
    },
    // 重写这个函数了，之前的设计太糟糕了，哪有把功能拆成七八块然后分布在不同地方的...
    scanblock(blockID, page) {
      var url = this.urlprefix + "/post/findblock.php";
      this.$http
        .post(url, {
          // @@@@@@@@@@ for debug
          // this.$http
          //   .post("123", {
          // @@@@@@@@ for debug
          "blockID": blockID,
          "page": page
        })
        .then(response => {
          response = response.body;
          constants.log(response);
          // console.log(response.statusCode === 0);
          if (response.statusCode === "0") {
            // response = response.body;
            this.blockinfo = {
              blockID: blockID,
              page: page,
              maxpage: response.maxpage
            };
            this.blockcontent = response.result;
            this.$router.push({ name: "scanBlock" });
          } else if (response.statusCode === "1") {
            alert("版面不存在！");
          } else {
            alert("到达队尾");
          }
        })
        .catch(res => {
          console.log("Error in scan the content of a block");
          console.log(res);
          // @@@@@@@@@@@@@@@@ for debug
          // this.blockinfo = { blockID: blockID, page: page, maxpage: "100" };
          // this.blockcontent = [{ title: "p1", postID: "1" }, { title: "p2", postID: "2" }, { title: "p3", postID: "3" }];
          // this.$router.push({ name: 'scanBlock' });
          // @@@@@@@@@@@@@@@@ for debug
        });
    },
    scanpost(id, page) {
      console.log("you want to scan the post: " + id + "   " + page);
      var url = this.urlprefix + "/post/findpost.php";
      console.log("begin to send request");
      this.$http
        .post(url, {
          // @@@@@@@@ for debug
          // console.log('begin to send request');
          // this.$http
          //   .post("123", {
          // @@@@@@@@@@@@@@ for debug
          postID: id,
          page: page
          // One post might have more than one page of replys
        })
        .then(response => {
          response = response.body;
          if (response.statusCode === "0") {
            this.postinfo = {
              title: response.title,
              postID: id,
              page: page,
              maxpage: response.maxpage
            };
            this.postreply = response.responseList;
            this.$router.push({ name: "scanPost" });
          } else if (response.statusCode === "1") {
            alert("帖子不存在！");
          } else {
            alert("到达队尾");
          }
        })
        .catch(res => {
          console.log("Error in scan posts");
          console.log(res);
          // @@@@@@@@@@@@@@@@ for debug
          // this.postinfo = { title: 'p_title', postID: "1", page: "0", maxpage: "100" };
          // this.postreply = [{ floor: "1", username: "gkc", content: "hello", time: "19980101", likeNum: "0" }, { floor: "2", username: "hty", content: "hello", time: "19980101", likeNum: "0" }, { floor: "3", username: "zwt", content: "hello", time: "19980101", likeNum: "0" }];
          // this.$router.push({ name: 'scanPost' });
          // @@@@@@@@@@@@@@@@ for debug
        });
    },
    scanpeople(username) {
      console.log("you want to see people: " + username);
      var url = this.urlprefix + "/user/homepage.php";
      this.$http
        .post(url, {
          // @@@@@@@@@@for debug
          // this.$http
          //   .post("123", {
          // @@@@@@@@@@for debug
          username: username
        })
        .then(response => {
          response = response.body;
          this.guestinfo = response;
          this.$router.push({ name: "scanPeople" });
        })
        .catch(res => {
          console.log("Error in visit a person");
          console.log(res);
          // @@@@@@@@@@@@ for debug
          // this.guestinfo = { username: 'hyz', nickname: 'xzz', birthday: '19980303', gender: 'male', email: "98email", score: 10, signdate: "981010" };
          // this.$router.push({ name: 'scanPeople' });
          // @@@@@@@@@@@@ for debug
        });
    },
    replypost(content) {
      var url = this.urlprefix + "/post/pushresponse.php";
      this.$http
        .post(url, {
          postID: this.postinfo.postID,
          username: this.userinfo.username,
          content: content
        })
        .then(response => {
          response = response.body;
          if (response.statusCode === "0") {
            // 感受到了直接调用函数的爽快
            this.scanpost(this.postinfo.postID, "0");
          } else {
            alert("发回复失败");
          }
        })
        .catch(res => {
          console.log("Error in reply to a post");
          console.log(res);
          // @@@@@@@@@@@@ for debug
          // @@@@@@@@@@@@ for debug
        });
    },
    newPost(title, content) {
      var url = this.urlprefix + "/post/pushpost.php";
      this.$http
        .post(url, {
          blockID: this.blockinfo.blockID,
          username: this.userinfo.username,
          content: content,
          title: title
        })
        .then(response => {
          response = response.body;
          if (response.statusCode === "0") {
            console.log(response);
            // 感受到了直接调用函数的爽快
            // scanpost(this.blockinfo.blockID, "0");
            this.scanblock(this.blockinfo.blockID, "0");
          } else {
            alert("发帖子失败");
          }
        })
        .catch(res => {
          console.log("Error in push a post");
          console.log(res);
        });
    }
  },
  created() {
    // 需要进行的一件事情，是向后台请求所有的板块信息，包括名字和id
    console.log("now begging to get block info");
    this.$http
      .post("http://192.168.43.139/forum/post/index.php", {})
      .then(response => {
        response = response.body;
        this.blocks = response.result;
        console.log(response.result);
      })
      .catch(e => {
        console.log("ERR in APP create during get blocks");
      });
  },
  beforeCreate() {
    if (this.$route.path === "/") {
      this.$router.push({ path: "/login" });
    }
  },
  components: {
    "v-header": header
  }
};
</script>
<style scoped>
/* fa图标右侧需要流出空白 elementUI图标已自带样式 */
i.fa {
  vertical-align: baseline;
  margin-right: 10px;
}

body {
  font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB,
    Microsoft YaHei, SimSun, sans-serif;
  background-color: #f2f2f2;
}

.menu,
.el-menu {
  height: 100%;
  background-color: #e6e6e6;
  position: fixed;
  float: left;
}

.container {
  padding-top: 80px;
  height: 100%;
}

.container .main {
  padding: 0;
}

.container ul li.el-menu-item {
  font-size: 100%;
}

.container .mar-l {
  padding: 0;
}

.container .content-wrapper {
  padding: 20px;
}
</style>