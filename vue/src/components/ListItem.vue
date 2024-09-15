<template>
    <li
        class="item"
        :class="{ selected: selected, correctBorder: isCorrect, wrongBorder: isCorrect === false }"
        @click="selectItem"
    >
        <span v-html="text"></span>
        <span v-if="isCorrect === true" class="correct">&#10003;</span>
        <span v-if="isCorrect === false" class="wrong">&#10007;</span>
    </li>
</template>

<script>
export default {
    name: 'ListItem',
    props: {
        text: {
            type: String,
            required: true,
        },
        id: {
            type: Number,
            required: true,
        },
        selected: {
            type: Boolean,
            required: true,
        },
        disabled: {
            type: Boolean,
            required: true,
        },
        isCorrect: {
            type: Boolean,
        },
    },
    methods: {
        selectItem() {
            if (this.disabled) return;
            this.$emit('select', this.id);
        },
    },
};
</script>

<style scoped>
.item {
    border: 1px solid var(--color-border);
    border-radius: 0.3rem;
    padding: 0.3rem 1rem;
    margin-bottom: 0.5rem;
    width: 100%;
    display: flex;
    justify-content: space-between;
    cursor: pointer;
}

.selected {
    border: 1px solid var(--color-text);
}

.correctBorder {
    border: 1px solid var(--color-text-green);
}

.wrongBorder {
    border: 1px solid var(--color-text-red);
}

.correct {
    font-weight: 600;
    color: var(--color-text-green);
}

.wrong {
    font-weight: 600;
    color: var(--color-text-red);
}
</style>
