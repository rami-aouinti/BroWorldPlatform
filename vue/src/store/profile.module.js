import UserService from "../services/user.service";

const profileData = JSON.parse(localStorage.getItem("profile"));

export const profile = {
    namespaced: true,
    state: {
        profile: profileData,
    },
    mutations: {
        setProfile(state, profileData) {
            state.profile = profileData.data;
        },
    },
    actions: {
         async loadProfile({ commit }) {
            try {
                const data = await UserService.getProfile();
                commit('setProfile', data);
            } catch (error) {
                console.error('Invalid APi:', error);
            }
        },
    },
    getters: {
        profile(state) {
            return state.profile;
        },
    },
};
