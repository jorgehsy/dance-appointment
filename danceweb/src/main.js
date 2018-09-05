import Vue from "vue";
import './plugins/vuetify'
import App from "./App.vue";
import router from "./router";

Vue.config.productionTip = false;
Vue.use(require('vue-moment'));
Vue.use(require('vue-cli-plugin-axios'));


new Vue({
  router,
  render: h => h(App)
}).$mount("#app");
