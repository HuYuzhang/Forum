<template>
  <section class="form-section">
    <button v-on:click="onClick">{{ msg }}</button>
    <!-- {{ this.$route.params.info }} -->
  </section>
</template>
<script>
  export default {
    data() {
      return {
        msg: this.prop
      };
    },
    props: ['prop', 'userinfo'],
    methods: {
      onClick() {
        console.log('click');
        console.log(this.userinfo);
        this.msg = '123';
        // this.$emit('tryparam');
        // alert('hello world!');
        // this.$router.push('/index');
        // this.$emit('hyzclicked', 1);
      }
    }
  }
</script>
<style>
  .form-section {
    padding: 10px;
    width: 500px;
  }
</style>
