// store/profile.module.js
import Vue from 'vue';
import Vuex from 'vuex';
import UserService from '../services/user.service'; // Assurez-vous que le chemin est correct

Vue.use(Vuex);

export const profile = {
    namespaced: true,
    state: {
        profile: null,
    },
    mutations: {
        setProfile(state, profile) {
            state.profile = profile;
        },
    },
    actions: {
        async fetchProfile({ commit }) {
            try {
                const response = await UserService.getProfileData(); // Assurez-vous que cette méthode fonctionne
                commit('setProfile', response.data);
            } catch (error) {
                console.error('Erreur lors de la récupération du profil:', error);
            }
        },
    },
    getters: {
        profile: state => {
            return state.profile;
        },
    },
};
