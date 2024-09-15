// store/index.js
import Vue from "vue";
import Vuex from "vuex";
import { auth } from "./auth.module";
import { profile } from "./profile.module";
import { user } from "./user.module";
import { users } from "./users.module";
import { menu } from "./menu.module";
import { configuration } from "./configuration.module";
import { userManagement } from "./admin/user.module";
import { configurationManagement } from "./admin/configuration.module";
import { menuManagement } from "./admin/menu.module";
import { shuffle, getToday } from '../lib/utils';
import { getRemoteData } from '../lib/utils';
import QuizService from "../services/quiz.service";


Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        count: 0,
        questionIndex: -1,
        score: 0,
        endGame: false,
        questionList: '',
        questions: [],
        questionCount: 0,
    },
    mutations: {
        SET_QUIZ_DATA(state, data) {
            state.questions = data;
            state.questionCount = data.length;
            state.questionList = data.map(qi => qi.id).join(',');
        },
        SET_END_GAME(state) {
            state.endGame = true;
        },
        RESET_QUIZ(state) {
            state.questions = [];
            state.questionList = '';
            state.questionIndex = -1;
            state.score = 0;
            state.endGame = false;
        },
        RESET_QUESTION_INDEX(state) {
            state.questionIndex = -1;
        },
        SET_QUESTION_INDEX(state, n) {
            state.questionIndex = n;
        },
        INCREMENT(state) {
            state.count++;
        },
        RESET_SCORE(state) {
            state.score = 0;
        },
        INCREMENT_SCORE(state) {
            state.score++;
        },
    },
    actions: {
        fetchQuizData({ commit }, {category, difficulty}) {
            // Fetch and process quiz data
            return getRemoteData(category, difficulty).then(data => {

                let raw_questions = data.results ? data.results : null;
                if (raw_questions) {
                    raw_questions = raw_questions.map((item, index) => {
                        const answers = [item.correct_answer, ...item.incorrect_answers];
                        let choices = answers.map((ans, i) => ({
                            id: i,
                            text: ans,
                        }));
                        shuffle(choices);
                        return {
                            ...item,
                            answers,
                            id: index,
                            text: item.question,
                            answer: 0,
                            choices,
                        };
                    });
                    commit('SET_QUIZ_DATA', raw_questions);
                }
            }).catch(err => {
                console.error(err);
            });
        },
        addScore({ commit }, {quiz}) {
            QuizService.setScore(quiz, this.state.score);
        },
        setEndGame({ commit }) {
            commit('SET_END_GAME');
            const today = getToday();
            localStorage.setItem("vue-app", JSON.stringify({
                endGame: true,
                questions: this.state.questionList,
                date: today,
                score: this.state.score,
                count: this.state.count,
                questionIndex: this.state.questionIndex
            }));
        },
        resetQuiz({ commit }) {
            commit('RESET_QUIZ');
            // Initialize quiz data again if needed
        },
        resetQuestionIndex({ commit }) {
            commit('RESET_QUESTION_INDEX');
        },
        setQuestionIndex({ commit }, n) {
            commit('SET_QUESTION_INDEX', parseInt(n, 10));
        },
        increment({ commit }) {
            commit('INCREMENT');
        },
        resetScore({ commit }) {
            commit('RESET_SCORE');
        },
        incrementScore({ commit }) {
            commit('INCREMENT_SCORE');
        }
    },
    getters: {
        getQuestion: (state) => (n) => state.questions[n],
        doubleCount: (state) => state.count * 2,
    },
    modules: {
        auth,
        user,
        users,
        profile,
        configuration,
        menu,
        userManagement,
        configurationManagement,
        menuManagement
    },
});
