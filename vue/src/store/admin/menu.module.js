// store/profile.module.js
import Vue from 'vue';
import Vuex from 'vuex';
import UserService from '../../services/admin/users.service'; // Assurez-vous que le chemin est correct

Vue.use(Vuex);

export const menuManagement = {
    namespaced: true,
    state: {
        menuManagement: null,
    },
    mutations: {
        setMenuManagement(state, menuManagement) {
            state.menuManagement = menuManagement;
        },
    },
    actions: {
        async fetchMenu({ commit }) {
            try {
                const response = await UserService.getMenu(); // Assurez-vous que cette méthode fonctionne
                commit('setMenuManagement', response.data);
            } catch (error) {
                console.error('Erreur lors de la récupération du profil:', error);
            }
        },
    },
    getters: {
        menuManagement: state => {
            return state.menuManagement;
        },
    },
};
