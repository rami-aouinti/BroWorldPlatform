<template>
    <div class="d-flex flex-column justify-center text-center h-100">
        <a href="javascript:void(0)" @click="dialog = true" class="text-decoration-none">
            <i class="fa fa-plus text-secondary mb-3" aria-hidden="true"></i>
            <h5 class="text-h5 text-secondary">New project</h5>
        </a>

        <!-- Modal avec Vuetify -->
        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">New Project</span>
                </v-card-title>

                <v-card-text>
                    <v-form>
                        <v-text-field label="Project Name" v-model="referenceTitle" outlined
                                      dense></v-text-field>
                        <v-text-field label="Project Name" v-model="referenceDescription" outlined
                                      dense></v-text-field>
                        <v-text-field label="Project Name" v-model="referenceCompany" outlined
                                      dense></v-text-field>

                        <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="referenceStartedAt"
                                    label="Start Date"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    outlined
                                    dense
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="referenceStartedAt" no-title scrollable>
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
                                    v-model="referenceEndedAt"
                                    label="End Date"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    outlined
                                    dense
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="referenceEndedAt" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menuEnd = false">OK</v-btn>
                            </v-date-picker>
                        </v-menu>

                        <dropzone class="my-dropzone" v-model="fileSingle" outlined
                                  dense></dropzone>

                        <v-select
                            v-model="selectedSkill"
                            :items="user.skills"
                            item-text="name"
                            label="Select a Skill"
                            outlined
                            dense
                        ></v-select>

                        <v-text-field label="Project Name" v-model="projectName" outlined
                                      dense></v-text-field>
                        <v-text-field label="Project Description" v-model="projectDescription" outlined
                                      dense></v-text-field>
                        <v-text-field label="Project Github Link" v-model="projectGithubLink" outlined
                                      dense></v-text-field>
                    </v-form>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="submitForm">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import Vue from "vue";
import { mapGetters } from "vuex";
import VueSweetalert2 from "vue-sweetalert2";
import ResumeService from "../../../../../services/resume.service";
import Dropzone from "../../../../Ecommerce/Products/Widgets/Dropzone.vue";

Vue.use(VueSweetalert2);

export default {
    name: "CreateReference",
    components: {Dropzone},
    data() {
        return {
            dialog: false,
            valid: false,
            projectName: '',
            projectDescription: '',
            projectGithubLink: '',
            referenceTitle: '',
            referenceDescription: '',
            referenceCompany: '',
            referenceStartedAt: null,
            referenceEndedAt: null,
            media: [],
            skill: [],
            menu: false,
            menuEnd: false,
            fileSingle: null,
            selectedSkill: []
        };
    },
    computed: {
        ...mapGetters("user", ["user"]),
    },
    methods: {
        async submitForm() {


            if (!this.projectName) {
                this.$swal("Error", "Please fill out all required fields.", "error");
                return;
            }

            const payload = {
                projectName: this.projectName,
                projectDescription: this.projectDescription,
                projectGithubLink: this.projectGithubLink,
                referenceTitle: this.referenceTitle,
                referenceDescription: this.referenceDescription,
                referenceCompany: this.referenceCompany,
                referenceStartedAt: this.referenceStartedAt,
                referenceEndedAt: this.referenceEndedAt,
                skillName: this.selectedSkill,
                photo: this.fileSingle
            };

            try {
                const response = await ResumeService.createReference(payload);
                this.$swal("Success", "Reference has been added successfully!", "success");
                this.dialog = false;
                this.resetForm();
                this.$emit('reference-added', payload);
            } catch (error) {
                this.$swal("Error", "An error occurred while saving the reference.", "error");
                console.error(error);
            }
        },

        resetForm() {
            this.projectName = null;
        }
    },
};
</script>
