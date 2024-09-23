<template>
    <v-col md="8">
        <v-card class="card-shadow border-radius-xl">
            <div class="px-4 pt-5">
                <h6 class="mb-0 text-typo text-h6 font-weight-bold">
                    Education
                </h6>
                <CreateEducation @education-added="addEducation"></CreateEducation>
            </div>
            <div class="px-4 pt-6 pb-1">
                <div v-for="(formation, index) in user.formations"
                     :key="index">
                    <v-list-item
                        :key="formation.name"
                        class="px-0 py-1 bg-gray-100 border border-radius-lg p-6 mb-4"
                    >
                        <v-list-item-content class="px-4">
                            <v-row>
                                <v-col cols="8">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-3 text-sm text-typo font-weight-bold">
                                            {{ formation.name }}
                                        </h6>
                                        <v-row>
                                            <v-col md="6">
                                                <h6 class="mb-3 text-sm text-typo font-weight-bold">{{ formation.school }}</h6>
                                            </v-col>
                                            <v-col md="6">
                                                <span class="dates">{{ formatDateRange(formation.startedAt) }} - {{ formatDateRange(formation.endedAt)  }}</span>
                                            </v-col>
                                        </v-row>
                                        <p class="details">
                                            {{ formation.description }}
                                        </p>
                                    </div>
                                </v-col>

                                <v-col cols="4" class="text-end">
                                    <div class="d-flex align-center text-sm text-body">
                                        <EditEducation :education="formation" @education-updated="updateEducation"></EditEducation>
                                        <DeleteEducation :education="formation" @education-deleted="deletedEducation"></DeleteEducation>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-list-item-content>
                    </v-list-item>
                </div>
            </div>

        </v-card>
    </v-col>
</template>
<script>

import {mapGetters} from "vuex";
import CreateEducation from "../Modal/Create/CreateEducation.vue";
import EditEducation from "../Modal/Edit/EditEducation.vue";
import DeleteEducation from "../Modal/Delete/DeleteEducation.vue";

export default {
    name: "Education",
    components: {
        DeleteEducation,
        EditEducation,
        CreateEducation
    },
    data: function () {
        return {
        };
    },
    computed: {
        ...mapGetters('user', ['user']),
    },
    methods: {
        addEducation(education) {
            this.user.formations.push(education);
        },
        updateEducation(updatedFormation) {
            const index = this.user.formations.findIndex(formation => formation.id === updatedFormation.id);
            if (index !== -1) {
                this.$set(this.user.formations, index, updatedFormation);
            }
        },
        deletedEducation(updatedFormation) {
            this.user.formations = this.user.formations.filter(formation => formation.id !== updatedFormation.id);
        },
        formatDateRange(datetimeString) {
            const date = new Date(datetimeString);
            const options = { year: 'numeric', month: 'long' };
            const formattedStart = date.toLocaleDateString('fr-FR', options);

            return `${formattedStart}`;
        }
    }
};
</script>
