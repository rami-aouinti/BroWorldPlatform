<template>
    <v-row>
        <v-btn
            :ripple="false"
            elevation="0"
            color="#fff"
            class="font-weight-bolder btn-outline-primary py-4 px-4 ms-auto"
            small
            @click="dialog = true"
        >
            <v-icon class="me-1" size="12">fa fa-plus</v-icon>
        </v-btn>

        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title class="text-h5">
                    New Skill
                </v-card-title>

                <v-card-text>
                    <v-form ref="form">
                        <v-text-field
                            v-model="name"
                            label="Skill Name"
                            required
                            outlined
                            dense
                        ></v-text-field>

                        <v-text-field
                            v-model="type"
                            label="Type"
                            required
                            outlined
                            dense
                        ></v-text-field>

                        <v-select
                            v-model="selectedLevel"
                            :items="levels"
                            label="Select a Grade Level"
                            outlined
                            dense
                        ></v-select>

                    </v-form>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="dialog = false">
                        Cancel
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="submitForm">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
import Vue from "vue";
import { mapGetters } from "vuex";
import VueSweetalert2 from "vue-sweetalert2";
import ResumeService from "../../../../../services/resume.service";

Vue.use(VueSweetalert2);

export default {
    name: "CreateSkill",
    data() {
        return {
            dialog: false,
            valid: false,
            name: null,
            type: null,
            levels: [1, 2, 3, 4, 5],
            selectedLevel: null
        };
    },
    computed: {
        ...mapGetters("user", ["user"]),
    },
    methods: {
        async submitForm() {
            if (!this.name || !this.type || !this.selectedLevel) {
                this.$swal("Error", "Please fill out all required fields.", "error");
                return;
            }

            const payload = {
                name: this.name,
                type: this.type,
                level: Number(this.selectedLevel),
            };
            try {
                const response = await ResumeService.createSkill(payload);
                this.$swal("Success", "Skill has been added successfully!", "success");
                this.dialog = false;
                this.resetForm();
                this.$emit('skill-added', payload);
            } catch (error) {
                this.$swal("Error", "An error occurred while saving the skill.", "error");
                console.error(error);
            }
        },

        resetForm() {
            this.name = null;
            this.type = null;
            this.selectedLevel = null;
        }
    },
};
</script>
