// store/profile.module.js
import Vue from 'vue';
import Vuex from 'vuex';
import UserService from '../services/user.service'; // Assurez-vous que le chemin est correct

Vue.use(Vuex);

export const users = {
    namespaced: true,
    state: {
        users: null,
    },
    mutations: {
        setUsers(state, users) {
            state.users = users;
        },
    },
    actions: {
        async fetchUsers({ commit }) {
            try {
                const response = await UserService.getUsers(); // Assurez-vous que cette méthode fonctionne
                commit('setUsers', response.data);
            } catch (error) {
                console.error('Erreur lors de la récupération du profil:', error);
            }
        },
    },
    getters: {
        users: state => {
            return state.users;
        },
    },
};
