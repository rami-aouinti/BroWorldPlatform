// store/index.js
import Vue from "vue";
import Vuex from "vuex";
import { auth } from "./auth.module";
import { profile } from "./profile.module";
import { user } from "./user.module";
import { menu } from "./menu.module";
import { configuration } from "./configuration.module";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        user,
        profile,
        configuration,
        menu
    },
});
