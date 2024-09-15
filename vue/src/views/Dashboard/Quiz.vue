<template>
    <div>
        <v-container fluid class="px-6 mt-10">
            <v-row>
                <v-col class="mx-auto pt-0" cols="10">
                    <v-card class="card-shadow border-radius-xl mb-30">
                        <div class="card-header-padding">
                            <p class="font-weight-bold text-h6 text-typo mb-0">
                                Install Guidance
                            </p>
                        </div>
                        <v-card-text class="card-padding pt-0 font-size-root text-body">
                            <v-list-item class="pl-0">
                                <v-list-item-content>
                                    <v-list-item-title class="text-body"
                                    >To start using this product you will need to install it
                                        with the following commands:</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <ol>
                                <li class="mb-2">
                                    After the dependencies are installed you can now turn on the
                                    project by typing <code>npm run dev</code> command.
                                </li>
                            </ol>
                            <v-row>
                                <v-select
                                    v-model="selectedCategory"
                                    :items="categories"
                                    label="Select Category"
                                ></v-select>

                                <v-select
                                    v-model="selectedDifficulty"
                                    :items="difficulties"
                                    label="Select Difficulty"
                                ></v-select>
                            </v-row>
                            <v-alert color="#37d5f2">
                                <div v-if="!loading && !error">
                                    <StarButton @click="startQuiz">Start Quiz</StarButton>
                                </div>
                                <p v-if="loading">Fetching trivia questions....</p>
                                <p v-if="error">Oops, something went wrong!</p>
                            </v-alert>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import { getRemoteData } from '../../lib/utils';
import { shuffle } from '../../lib/utils';
import StarButton from "../../components/StartButton.vue";

export default {
    name: "quiz",
    components: {
        StarButton
    },
    data() {
        return {
            loading: false,
            error: false,
            selectedCategory: 'Geography',
            selectedDifficulty: 'easy',
            categories: ['Entertainment: Video Games', 'Vehicles', 'General Knowledge', 'Entertainment: Japanese Anime & Manga', 'Entertainment: Music', 'Entertainment: Film', 'Geography'],
            difficulties: ['easy', 'medium', 'hard'],
            quizzes: []
        };
    },
    computed: {
        ...mapGetters(['getQuestion', 'doubleCount']),
    },
    methods: {
        ...mapActions(['resetQuiz', 'setEndGame', 'resetScore', 'increment', 'setQuestionIndex']),
        startQuiz() {
            getRemoteData(this.selectedCategory, this.selectedDifficulty).then(data => {
                let raw_questions = data ? data : null;
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
                    this.$store.commit('SET_QUIZ_DATA', raw_questions);
                }
                this.loading = false;
            }).catch(err => {
                console.error(err);
                this.loading = false;
                this.error = true;
            });
            this.resetScore();
            this.increment();
            this.setQuestionIndex(0);
            this.$router.push({ path: `/question/0` });
        },
    },
    mounted() {
        this.resetQuiz();
        this.loading = true;

        getRemoteData(this.selectedCategory, this.selectedDifficulty).then(data => {
            let raw_questions = data ? data : null;
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
                this.$store.commit('SET_QUIZ_DATA', raw_questions);
            }
            this.loading = false;
        }).catch(err => {
            console.error(err);
            this.loading = false;
            this.error = true;
        });
    },
};
</script>
