// store/profile.module.js
import Vue from 'vue';
import Vuex from 'vuex';
import UserService from '../services/user.service'; // Assurez-vous que le chemin est correct

Vue.use(Vuex);

export const user = {
    namespaced: true,
    state: {
        user: null,
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
    },
    actions: {
        async fetchUser({ commit }) {
            try {
                const response = await UserService.getProfile(); // Assurez-vous que cette méthode fonctionne
                commit('setUser', response.data);
            } catch (error) {
                console.error('Erreur lors de la récupération du profil:', error);
            }
        },
    },
    getters: {
        user: state => {
            return state.user;
        },
    },
};
