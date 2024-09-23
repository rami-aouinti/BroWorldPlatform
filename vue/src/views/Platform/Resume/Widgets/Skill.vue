<template>
    <v-col lg="4">
            <v-card class="card-shadow border-radius-xl">
                <div class="px-4 pt-4 d-flex align-center">
                    <h6 class="mb-0 text-h6 font-weight-bold text-typo">Skills</h6>
                    <CreateSkill @skill-added="addSkill"></CreateSkill>
                </div>
                <div class="px-4 pb-3 pt-3">
                    <div v-for="(skill, index) in this.user.skills" :key="index">
                        <v-list-item
                            :key="skill.id"
                            class="px-0 py-1 bg-gray-100 border border-radius-lg p-6 mb-6"
                        >
                            <v-list-item-content class="px-4">
                                <v-row>
                                    <v-col md="8">{{ skill.name }}</v-col>
                                    <v-col md="4">{{ skill.level }}</v-col>
                                </v-row>
                            </v-list-item-content>

                            <v-list-item-content class="py-0 text-end">
                                <div class="d-flex align-center text-sm text-body">
                                    <EditSkill :skill="skill" @skill-updated="updateSkill"></EditSkill>
                                    <DeleteSkill :skill="skill" @skill-deleted="deletedSkill"></DeleteSkill>
                                </div>
                            </v-list-item-content>
                        </v-list-item>
                    </div>
                </div>
            </v-card>
        </v-col>
</template>
<script>

import {mapGetters} from "vuex";
import CreateSkill from "../Modal/Create/CreateSkill.vue";
import EditSkill from "../Modal/Edit/EditSkill.vue";
import DeleteSkill from "../Modal/Delete/DeleteSkill.vue";

export default {
    name: "Skill",
    components: {
        DeleteSkill,
        EditSkill,
        CreateSkill
    },
    data: function () {
        return {
        };
    },
    computed: {
        ...mapGetters('user', ['user']),
    },
    methods: {
        addSkill(skill) {
            this.user.skills.push(skill);
        },
        updateSkill(updatedSkill) {
            const index = this.user.skills.findIndex(skill => skill.id === updatedSkill.id);
            if (index !== -1) {
                this.$set(this.user.skills, index, updatedSkill);
            }
        },
        deletedSkill(deletedSkill) {
            this.user.skills = this.user.skills.filter(skill => skill.id !== deletedSkill.id);
        },
    }
};
</script>
