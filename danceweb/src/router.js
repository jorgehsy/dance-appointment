import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";
import Laboratory from "./views/Laboratory.vue"

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      name: "home",
      component: Home
    },
    {
     path: "/lab",
     name: "laboratory",
     component: Laboratory
    },
    {
     path: "/create/:id?",
     name: "create",
     props: true,
     component: () =>
       import("./components/Create.vue")
    }
  ]
});
