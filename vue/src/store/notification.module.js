// store/profile.module.js
import Vue from 'vue';
import Vuex from 'vuex';
import NotificationService from "../services/notification.service";

Vue.use(Vuex);

export const notification = {
    namespaced: true,
    state: {
        notifications: []
    },
    mutations: {
        setNotification(state, notifications) {
            state.notifications = notifications;
        },
        markAllAsRead(state) {
            state.notifications.forEach(notification => {
                notification.isRead = true;
            });
        },
    },
    actions: {
        async fetchNotification({ commit }) {
            try {
                const notifications = await NotificationService.getNotifications();
                commit('setNotification', notifications);
            } catch (error) {
                console.error('Error', error);
            }
        },

        async markAllAsRead({ commit }) {
            try {
                await NotificationService.readNotifications();

                commit('markAllAsRead');
            } catch (error) {
                console.error('Error', error);
            }
        },
    },
    getters: {
        notification: state => {
            return state.notifications;
        },
        unreadNotificationCount(state) {
            return state.notifications.filter(notification => !notification.isRead).length;
        }
    },

};
