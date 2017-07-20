import './bootstrap'

Vue.component('admin', require('./components/Admin.vue'));

const app = new Vue({
  el: '#app'
});