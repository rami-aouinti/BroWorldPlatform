// main.js
import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store"; // Utilisez le store principal
import vuetify from "./plugins/vuetify";
import DashboardPlugin from "./plugins/dashboard-plugin";
import VeeValidate from "vee-validate";
import Photoswipe from "vue-pswipe";

Vue.use(Photoswipe);
Vue.use(VeeValidate);
Vue.use(DashboardPlugin);

Vue.config.productionTip = false;

new Vue({
    router,
    store,
    vuetify,
    render: (h) => h(App),
    created() {
        this.$store.dispatch('profile/fetchProfile');
        this.$store.dispatch('user/fetchUser');
        this.$store.dispatch('menu/fetchMenu');
        this.$store.dispatch('configuration/fetchConfiguration');
    },
}).$mount("#app");
