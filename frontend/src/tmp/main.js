// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource'
// import axios from 'axios';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import App from './App';
import Index from './views/index/index';
// import Table from './views/table/table';
import DeleteUsr from './views/deleteUsr/deleteUsr';
import DeletePost from './views/deletePost/deletePost';
import ScanBlock from './views/scanBlock/scanBlock';
import ScanPost from './views/post/post'
import Create from './views/create/create';
import Login from './views/login/login';
import ScanPeople from './views/people/people'
import ManageBlock from './views/manage/manage'
// import Mytmp from './views/create/try';
// import ue from './views/editor/editor';
import 'font-awesome/css/font-awesome.min.css';
import Mock from './mock/mock';

import '../static/UE/ueditor.config.js'
import '../static/UE/ueditor.all.min.js'
import '../static/UE/lang/zh-cn/zh-cn.js'
import '../static/UE/ueditor.parse.min.js'

Mock.mockData();
Vue.use(VueRouter);// 安装路由功能
/* eslint-disable no-new */
Vue.use(VueResource);
// Vue.prototype.$http = axios;
Vue.use(ElementUI);
Vue.http.options.emulateJSON = true;
Vue.http.options.headers = {
  'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
};
let routes = [
  {
    path: '/',
    component: App,
    children: [
      {path: '/index', component: Index, name: 'index', class: 'fa-line-chart', hidden: false},
      {path: '/login', component: Login, name: 'login', class: 'fa-plug', hidden: false},
      {path: '/create', component: Create, name: 'create', class: 'fa-plug', hidden: false},
      {path: '/scanBlock', component: ScanBlock, name: 'scanBlock', class: 'fa-plug', hidden: true},
      {path: '/deleteUsr', component: DeleteUsr, name: 'deleteUsr', class: 'fa-table', hidden: true},
      {path: '/deletePost', component: DeletePost, name: 'deletePost', class: 'fa-table', hidden: true},
      {path: '/scanPost', component: ScanPost, name: 'scanPost', class: 'fa-table', hidden: true},
      {path: '/scanPeople', component: ScanPeople, name: 'scanPeople', class: 'fa-table', hidden: true},
      {path: '/manageBlock', component: ManageBlock, name: 'editBlock', class: 'fa-table', hidden: true},
      // {path: '/test', component: Mytmp, name: 'tmp', class: 'fa-table', hidden: false},
    ]
  }
];
let router = new VueRouter({
  // 'mode': 'history', 去掉URL的#号，需要配置服务器http://router.vuejs.org/zh-cn/essentials/history-mode.html
  'linkActiveClass': 'active',
  routes
});
let app = new Vue({
  router
}).$mount('#app');
export default app;
