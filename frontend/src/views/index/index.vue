<template>
  <section class="chart-container">
    <!-- <el-card v-for:"block in blocks">
      <h1>
        {{ block.name }}
      </h1>
    </el-card>-->
    <div style="text-align:center;">
      <span style="font-size:50px;">歡迎來到MyBBS</span>
      <br>
      <br>
    </div>
    <el-row :gutter="20" type="flex">
      <el-card v-for="block in blocks" class="block-card">
        <div class="block-img">
          <img v-bind:src="img" alt="logo">
        </div>
        <div class="block-text">
          <el-button type="success" v-on:click="gotoblock(block.blockID, block.name)">{{ block.name }}</el-button>
          <br>
          <br>
          <br>
          <h2>{{ block.info }}</h2>
        </div>
        <el-input v-if="(userinfo.identity === 'ADMIN' || userinfo.identity == block.blockID)" v-model="tmpinfo" placeholder="输入新的板块信息"></el-input>
        <el-button v-if="(userinfo.identity === 'ADMIN' || userinfo.identity == block.blockID)" @click="modify(block.blockID)">修改信息</el-button>
      </el-card>
    </el-row>
  </section>
</template>
<script>
  // 这个组件需要向后端发送blockID，从而获得对应的版面的内容
  export default {
    // 真正用的时候，记得删去data中的blocks属性，同时修改props中的blockss为blocks
    props: ["blocks", 'urlprefix', "userinfo"],
    data() {
      return {
        tmpinfo: "",
        img: "./static/img/cute.jpg",
      }
    },
    methods: {
      modify(id) {
        this.$emit("modifyblock", id, this.tmpinfo);
      },
      gotoblock(blockID, blockname) {
        console.log('now scan block');
        this.$emit('scanblock', blockID, "0");
      }
    }
    // components: {
    //   // 'v-charts': charts
    //   'blocks': block
    // }
  };
</script>
<style scoped>
  .block-card {
    width: 500px;
    height: 500px;
    padding: 10px;
  }

  .block-text {
    text-align: center;
  }

  .block-img {
    width: 200px;
    height: 200px;
    margin: 0 auto;
    vertical-align: middle;
  }

  .chart-container {
    background-color: #f2f2f2;
  }

  .show-section {
    margin: 10px;
    border-radius: 4px;
  }

  .show-section.top {
    background-color: white;
    padding: 10px;
    margin-top: 0;
  }

  .show-section span {
    font-weight: bold;
    font-size: 18px;
    color: #333333;
  }

  .el-rate {
    display: inline;
  }
</style>