<template>
    <div v-if="score !== null" class="container">
        <div class="panel">
            <h4 class="title">{{ getPageTitle }}</h4>
            <p class="text">
                Your Score is <span class="score">{{ score }}</span>/{{ count }}
            </p>
            <router-link to="/question/0">Try Quiz Again?</router-link>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            score: null,
            count: null
        };
    },
    computed: {
        store() {
            return this.$store.state; // Remplacez `useCounterStore` par l'accès à Vuex dans Vue 2
        },
        errFlag() {
            const total = this.store.questionCount;
            const index = this.store.questionIndex;
            const endFlag = this.store.endGame;
            return index < 0 || !endFlag || (index >= 0 && total !== index + 1);
        },
        getPageTitle() {
            if (this.score === 0) {
                return "Tough Luck! 😢";
            } else if (this.score > 0 && this.score < 5) {
                return "You Can Do Better! 🙂";
            } else if (this.score === 8 || this.score === 9) {
                return "Almost Perfect Score! 😂";
            } else if (this.score === 10) {
                return "Perfect Score! 🎉";
            } else {
                return "Nice Score! 😄";
            }
        }
    },
    created() {
        if (this.errFlag) {
            this.$router.push('/error');
        } else {
            this.score = this.store.score;
            this.count = this.store.questionCount;
        }
    }
};
</script>
<style scoped>
.container {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}
.panel {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.title {
    font-size: 1.1rem;
    font-weight: bold;
}
.text {
    margin-bottom: 1rem;
}
.score {
    font-size: 1.5rem;
    font-weight: 600;
}
</style>
