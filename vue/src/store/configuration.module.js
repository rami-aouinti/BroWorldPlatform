// store/profile.module.js
import Vue from 'vue';
import Vuex from 'vuex';
import UserService from '../services/user.service';
import ConfigurationService from "../services/configuration.service"; // Assurez-vous que le chemin est correct

Vue.use(Vuex);

export const configuration = {
    namespaced: true,
    state: {
        configuration: null,
    },
    mutations: {
        setConfiguration(state, configuration) {
            state.configuration = configuration;
        },
    },
    actions: {
        async fetchConfiguration({ commit }) {
            try {
                const response = await ConfigurationService.getConfigurations(); // Assurez-vous que cette méthode fonctionne
                commit('setConfiguration', response);
            } catch (error) {
                console.error('Erreur lors de la récupération du profil:', error);
            }
        },
    },
    getters: {
        configuration: state => {
            return state.configuration;
        }
    },
};
