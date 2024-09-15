<template>
    <transition name="button">

        <v-container>
            <v-row align="center" justify="center">
                <v-col cols="auto">
                    <v-btn
                        v-if="show"
                        @click="handleClick"
                        :rounded="true"
                        size="x-large"
                        block>Start Quiz
                    </v-btn>
                </v-col>
            </v-row>

        </v-container>
    </transition>
</template>

<script>
export default {
    name: 'StarButton',
    data() {
        return {
            show: true,
        };
    },
    methods: {
        handleClick() {
            this.show = false;
            this.$emit('click');
        },
    },
};
</script>

<style scoped>
.button-enter-active, .button-leave-active {
    transition: all 0.5s ease;
}
.button-enter-from, .button-leave-to {
    opacity: 0;
    transform: scale(1.5);
}
</style>
