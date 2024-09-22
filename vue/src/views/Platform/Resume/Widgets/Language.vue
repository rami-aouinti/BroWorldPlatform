<template>
    <v-card class="card-shadow border-radius-xl">
        <div class="px-4 py-4 d-flex align-center">
            <h6 class="mb-0 text-typo text-h6 font-weight-bold">
                Languages
            </h6>
            <CreateLanguage @language-added="addLanguage"></CreateLanguage>
        </div>
        <div class="px-4 pb-3 pt-3">
            <v-row>
                <v-col
                    v-for="(language, index) in this.user.languages"
                    :key="index"
                    md="6"
                >
                    <v-list-item class="px-3 py-1 bg-gray-100 border border-radius-lg p-6 mb-6">
                        <v-list-item-content class="px-4">
                            <v-row>
                                <v-col md="4">
                                    <v-avatar size="16" rounded class="me-4">
                                        <v-img
                                            :src="`${language.flag}`"
                                            alt="logo"
                                            max-width="80"
                                            contain
                                        ></v-img>
                                    </v-avatar>
                                </v-col>
                                <v-col md="8">
                                    <v-icon
                                        v-for="n in 4"
                                        :key="n"
                                        :class="{ 'star-filled': n <= language.level }"
                                        size="12"
                                    >
                                        fas fa-star
                                    </v-icon>
                                </v-col>
                            </v-row>
                        </v-list-item-content>
                        <v-list-item-content class="py-0 text-end">
                            <div class="d-flex align-center text-sm text-body">
                                <EditLanguage :language="language" @skill-updated="updateLanguage"></EditLanguage>
                                <DeleteLanguage :language="language" @skill-delete="deletedLanguage"></DeleteLanguage>
                            </div>
                        </v-list-item-content>
                    </v-list-item>
                </v-col>
            </v-row>
        </div>
    </v-card>
</template>
<script>

import {mapGetters} from "vuex";
import CreateLanguage from "../Modal/Create/CreateLanguage.vue";
import EditSkill from "../Modal/Edit/EditSkill.vue";
import EditLanguage from "../Modal/Edit/EditLanguage.vue";
import DeleteLanguage from "../Modal/Delete/DeleteLanguage.vue";


export default {
    name: "Language",
    components: {
        DeleteLanguage,
        EditLanguage,
        EditSkill,
        CreateLanguage
    },
    data: function () {
        return {
        };
    },
    computed: {
        ...mapGetters('user', ['user']),
    },
    methods: {
        addLanguage(language) {
            this.user.languages.push(language);
        },
        updateLanguage(updatedLanguage) {
            const index = this.user.languages.findIndex(language => language.id === updatedLanguage.id);
            if (index !== -1) {
                this.$set(this.user.languages, index, updatedLanguage);
            }
        },
        deletedLanguage(deletedLanguage) {
            this.user.languages = this.user.languages.filter(language => language.id !== deletedLanguage.id);
        },
    }
};
</script>
<style scoped>
.star-filled {
    color: gold;
}
</style>
