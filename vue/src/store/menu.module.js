// store/profile.module.js
import Vue from 'vue';
import Vuex from 'vuex';
import UserService from '../services/user.service';
import MenuService from "../services/menu.service"; // Assurez-vous que le chemin est correct

Vue.use(Vuex);

export const menu = {
    namespaced: true,
    state: {
        menu: null,
    },
    mutations: {
        setMenu(state, menu) {
            state.menu = menu;
        },
    },
    actions: {
        async fetchMenu({ commit }) {
            try {
                const response = await MenuService.getMenu();
                commit('setMenu', response);
            } catch (error) {
                console.error('Erreur lors de la récupération du profil:', error);
            }
        },
    },
    getters: {
        menu: state => {
            return state.menu;
        },
    },
};
