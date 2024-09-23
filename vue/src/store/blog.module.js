import Vue from 'vue';
import Vuex from 'vuex';
import BlogService from "../services/blog.service";

Vue.use(Vuex);

export const blog = {
    namespaced: true,
    state: {
        blog: [],
    },
    mutations: {
        setBlog(state, blog) {
            state.blog = blog;
        },
        ADD_COMMENT(state, { postId, comment }) {
            const post = state.blog.find(p => p.id === postId);
            if (post) {
                post.comments.push(comment);
            }
        },
    },
    actions: {
        async fetchPosts({ commit }) {
            try {
                const response = await BlogService.getPosts();
                commit('setBlog', response);
            } catch (error) {
                console.error('Error:', error);
            }
        },
        async addComment({ commit }, { postId, content }) {
            try {
                const response = await BlogService.addComment(postId, content);
                const newComment = response.data;

                commit('ADD_COMMENT', { postId, comment: newComment });
            } catch (error) {
                console.error('Error adding comment:', error);
            }
        },
    },
    getters: {
        blog: state => {
            return state.blog;
        },
    },
};
