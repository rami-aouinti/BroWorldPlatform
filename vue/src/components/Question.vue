<template>
    <v-container fluid class="px-6 mt-10">
        <v-row>
            <v-col class="mx-auto pt-0" cols="10">
        <v-card v-if="question" class="card-shadow border-radius-xl mb-30">
            <v-card-title class="d-flex justify-space-between">
                <div class="text-start mt-4">
                    <v-row>
                        <v-col lg="10" >
                            <h4>Question {{ questionNumber }}</h4>
                            <h5>Category : {{ question.category }}</h5>
                            <h5>Difficulty : {{ question.difficulty }}</h5>
                        </v-col>
                        <v-col lg="2" class="text-center">
                            <round-slider
                                class="d-flex justify-center mx-auto"
                                v-model="sliderValue"
                                :min="0"
                                :max="15"
                                width="6"
                                :borderColor="'#d3d3d3'"
                                :pathColor="'#d3d3d3'"
                                :rangeColor="'#cb0c9f'"
                                :tooltipColor="'#344767'"
                                :handleSize="20"
                                :start-angle="0"
                                :end-angle="270"
                                :line-cap="'round'"
                                :radius="40"
                                :read-only="true"
                            />
                        </v-col>
                    </v-row>
                </div>

            </v-card-title>
            <v-card-subtitle class="d-flex justify-space-between">

            </v-card-subtitle>
            <v-card-text>
                <p v-html="question.text"></p>
                <v-list>
                    <v-list-item v-for="ans in question.choices" :key="ans.id">
                        <v-list-item-content>
                            <v-btn
                                :disabled="isSubmitted"
                                @click="selectAnswer(ans.id)"
                                :class="{
                                    'success--text': isSubmitted && ans.id === question.answer,
                                    'error--text': isSubmitted && ans.id !== question.answer && ans.id === selected
                                }"
                            >
                                {{ ans.text }}
                            </v-btn>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card-text>
            <v-card-actions>
                <v-btn color="red" @click="showDialog">Quit</v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="isSubmitted || selected === null"
                    @click="submitAnswer"
                >
                    Submit Answer
                </v-btn>

                <v-btn
                    v-if="!isLastQuestion"
                    :disabled="!isSubmitted"
                    @click="gotoNextQuestion"
                >
                    Next Question
                </v-btn>

                <v-btn
                    v-if="isLastQuestion"
                    :disabled="!isSubmitted"
                    @click="gotoScore(question.quiz)"
                >
                    View Score
                </v-btn>
            </v-card-actions>
        </v-card>

        <v-dialog v-model="openDialog" persistent max-width="290">
            <v-card>
                <v-card-title class="headline">Quit Quiz</v-card-title>
                <v-card-text>Are you sure you want to quit?</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red" text @click="quitQuiz">OK</v-btn>
                    <v-btn text @click="closeDialog">Cancel</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapState, mapActions } from "vuex";
import RoundSlider from "vue-round-slider";


export default {
    components: {
        RoundSlider,
    },
    data() {
        return {
            selected: null,
            isSubmitted: false,
            openDialog: false,
            timeLeft: 15,
            timer: null,
            timerActive: false,
            RoundSlider,
            sliderValue: 15,
        };
    },
    computed: {
        ...mapState(['questions', 'questionCount', 'questionIndex', 'endGame']),
        question() {
            return this.questions[this.questionIndex];
        },
        questionNumber() {
            return `${this.questionIndex + 1} of ${this.questionCount}`;
        },
        isLastQuestion() {
            return this.questionIndex === this.questionCount - 1;
        }
    },
    watch: {
        // Watcher pour réinitialiser le timer quand la question change
        question() {
            this.resetTimer();
        }
    },
    mounted() {
        this.startTimer();
    },
    beforeDestroy() {
        clearInterval(this.timer);
    },
    methods: {
        ...mapActions(['incrementScore', 'addScore', 'setEndGame', 'setQuestionIndex', 'resetQuiz']),
        selectAnswer(id) {
            this.selected = id;
        },
        submitAnswer() {
            if (this.selected === this.question.answer) {
                this.incrementScore();
            }
            this.isSubmitted = true;
            clearInterval(this.timer); // Stopper le timer une fois la réponse soumise
        },
        gotoNextQuestion() {
            const nextId = this.questionIndex + 1;
            this.setQuestionIndex(nextId);
            this.isSubmitted = false;
            this.$router.push(`/question/${nextId}`);
            this.startTimer();
        },
        gotoScore(quiz) {
            this.$store.dispatch('addScore', {
                quiz: quiz
            });
            //this.addScore(quiz);
            this.setEndGame();
            this.$router.push('/score');
        },
        quitQuiz() {
            this.openDialog = false;
            clearInterval(this.timer);
            setTimeout(() => {
                this.resetQuiz();
                this.$router.push('/question/0');
            }, 200);
        },
        showDialog() {
            this.openDialog = true;
        },
        closeDialog() {
            this.openDialog = false;
        },
        // Démarrer le timer
        startTimer() {
            if (this.timer) {
                clearInterval(this.timer); // Arrête l'ancien timer si un autre est en cours
            }
            this.sliderValue = 15; // Réinitialise le slider à 38 pour la nouvelle question
            this.timer = setInterval(() => {
                if (this.sliderValue > 0) {
                    this.sliderValue--; // Diminue la valeur du slider (compte à rebours)
                } else {
                    clearInterval(this.timer); // Arrête le timer quand il atteint 16
                    this.gotoNextQuestion(); // Passe à la question suivante
                }
            }, 1000); // Réduction toutes les secondes
        },
        resetTimer() {
            clearInterval(this.timer);
            this.startTimer();
        },
        timeOut() {
            clearInterval(this.timer); // Arrêter le timer
            this.isSubmitted = true;
            if (!this.isLastQuestion) {
                this.gotoNextQuestion(); // Passer à la question suivante
            } else {
                this.gotoScore(); // Aller au score si c'est la dernière question
            }
        }
    }
};
</script>

<style scoped>
.success--text {
    color: #4caf50;
}
.error--text {
    color: #f44336;
}
</style>
