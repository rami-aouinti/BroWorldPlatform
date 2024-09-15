// store/profile.module.js
import Vue from 'vue';
import Vuex from 'vuex';
import UserService from '../../services/admin/users.service'; // Assurez-vous que le chemin est correct

Vue.use(Vuex);

export const configurationManagement = {
    namespaced: true,
    state: {
        configurationManagement: null,
    },
    mutations: {
        setConfigurationManagement(state, configurationManagement) {
            state.configurationManagement = configurationManagement;
        },
    },
    actions: {
        async fetchConfiguration({ commit }) {
            try {
                const response = await UserService.getConfiguration(); // Assurez-vous que cette méthode fonctionne
                commit('setConfigurationManagement', response.data);
            } catch (error) {
                console.error('Erreur lors de la récupération du profil:', error);
            }
        },
    },
    getters: {
        configurationManagement: state => {
            return state.configurationManagement;
        },
    },
};
