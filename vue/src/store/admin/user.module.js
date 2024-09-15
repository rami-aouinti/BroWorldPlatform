// store/profile.module.js
import Vue from 'vue';
import Vuex from 'vuex';
import UserService from '../../services/admin/users.service'; // Assurez-vous que le chemin est correct

Vue.use(Vuex);

export const userManagement = {
    namespaced: true,
    state: {
        userManagement: null,
    },
    mutations: {
        setUserManagement(state, userManagement) {
            state.userManagement = userManagement;
        },
    },
    actions: {
        async fetchUser({ commit }) {
            try {
                const response = await UserService.getUser(); // Assurez-vous que cette méthode fonctionne
                commit('setUserManagement', response.data);
            } catch (error) {
                console.error('Erreur lors de la récupération du profil:', error);
            }
        },
    },
    getters: {
        userManagement: state => {
            return state.userManagement;
        },
    },
};
