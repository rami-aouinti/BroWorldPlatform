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
                    New Formation
                </v-card-title>

                <v-card-text>
                    <v-form ref="form">
                        <v-text-field
                            v-model="name"
                            label="Formation Name"
                            required
                            outlined
                            dense
                        ></v-text-field>

                        <v-text-field
                            v-model="school"
                            label="School"
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

                        <v-textarea
                            v-model="description"
                            label="Description"
                            outlined
                            dense
                            required
                        ></v-textarea>

                        <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="startedAt"
                                    label="Start Date"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    outlined
                                    dense
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="startedAt" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menu = false">OK</v-btn>
                            </v-date-picker>
                        </v-menu>

                        <v-menu
                            v-model="menuEnd"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="endedAt"
                                    label="End Date"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    outlined
                                    dense
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="endedAt" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menuEnd = false">OK</v-btn>
                            </v-date-picker>
                        </v-menu>
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
    name: "CreateFormation",
    data() {
        return {
            dialog: false,
            valid: false,
            name: null,
            school: null,
            description: null,
            levels: [1, 2, 3, 4, 5],
            selectedLevel: null,
            startedAt: null,
            endedAt: null,
            menu: false,
            menuEnd: false,
        };
    },
    computed: {
        ...mapGetters("user", ["user"]),
    },
    methods: {
        async submitForm() {
            if (!this.name || !this.school || !this.description || !this.selectedLevel || !this.startedAt) {
                this.$swal("Error", "Please fill out all required fields.", "error");
                return;
            }

            const payload = {
                name: this.name,
                school: this.school,
                description: this.description,
                gradeLevel: Number(this.selectedLevel),
                startedAt: this.startedAt,
                endedAt: this.endedAt || null,
            };

            try {
                const response = await ResumeService.createEducation(payload);
                this.$swal("Success", "Formation has been added successfully!", "success");
                this.dialog = false;
                this.resetForm();
                this.$emit('education-added', payload);
            } catch (error) {
                this.$swal("Error", "An error occurred while saving the formation.", "error");
                console.error(error);
            }
        },

        resetForm() {
            this.name = null;
            this.school = null;
            this.description = null;
            this.selectedLevel = null;
            this.startedAt = null;
            this.endedAt = null;
        }
    },
};
</script>
