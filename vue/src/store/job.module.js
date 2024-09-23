import Vue from 'vue';
import Vuex from 'vuex';
import JobService from "../services/job.service";

Vue.use(Vuex);

export const job = {
    namespaced: true,
    state: {
        job: [],
    },
    mutations: {
        setBlog(state, job) {
            state.job = job;
        },
    },
    actions: {
        async fetchJobs({ commit }) {
            try {
                const response = await JobService.getJobs();
                commit('setBlog', response.data);
            } catch (error) {
                console.error('Error:', error);
            }
        },
    },
    getters: {
        job: state => {
            return state.job;
        },
    },
};
