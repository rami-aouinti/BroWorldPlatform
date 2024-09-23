import Vue from 'vue';
import Vuex from 'vuex';
import ShopService from "../services/shop.service";

Vue.use(Vuex);

export const product = {
    namespaced: true,
    state: {
        product: [],
    },
    mutations: {
        setProduct(state, product) {
            state.product = product;
        },
    },
    actions: {
        async fetchProducts({ commit }) {
            try {
                const response = await ShopService.getProducts();
                commit('setProduct', response.data);
            } catch (error) {
                console.error('Error:', error);
            }
        },
    },
    getters: {
        product: state => {
            return state.product;
        },
    },
};
