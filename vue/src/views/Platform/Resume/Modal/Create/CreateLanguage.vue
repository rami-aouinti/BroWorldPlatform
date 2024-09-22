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
                    New Language
                </v-card-title>

                <v-card-text>
                    <v-form ref="form">
                        <v-select
                            v-model="selectedLanguage"
                            :items="languages"
                            item-text="name"
                            item-value="name"
                            label="Select a Language"
                            outlined
                            dense
                            return-object
                        >
                            <template v-slot:selection="data">
                                <v-img :src="data.item.flag" alt="logo" max-width="20" contain></v-img>
                                <span>
                                    {{ data.item.name }}
                                </span>
                            </template>
                            <template v-slot:item="data">
                                <v-img :src="data.item.flag" alt="logo" max-width="20" contain></v-img>
                                <span>
                                    {{ data.item.name }}
                                </span>
                            </template>
                        </v-select>

                        <!-- Sélection du niveau -->
                        <v-select
                            v-model="selectedLevel"
                            :items="levels"
                            label="Select a Level"
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
    name: "CreateLanguage",
    data() {
        return {
            dialog: false,
            valid: false,
            languages: [
                { name: "ENGLISH", flag: "http://localhost/img/icons/flags/GB.png" },
                { name: "FRENCH", flag: "http://localhost/img/icons/flags/FR.png" },
                { name: "SPANISH", flag: "http://localhost/img/icons/flags/ES.png" },
                { name: "GERMAN", flag: "http://localhost/img/icons/flags/DE.png" },
                { name: "ITALIAN", flag: "http://localhost/img/icons/flags/IT.png" },
                { name: "JAPANESE", flag: "http://localhost/img/icons/flags/JP.png" },
                { name: "CHINESE", flag: "http://localhost/img/icons/flags/CN.png" },
                { name: "RUSSIAN", flag: "http://localhost/img/icons/flags/RU.png" },
                { name: "PORTUGUESE", flag: "http://localhost/img/icons/flags/PT.png" },
                { name: "ARABIC", flag: "http://localhost/img/icons/flags/TN.png" },
            ],
            levels: [1, 2, 3, 4, 5],
            selectedLanguage: null,
            selectedLevel: null,
        };
    },
    computed: {
        ...mapGetters("user", ["user"]),
    },
    methods: {
        async submitForm() {
            if (!this.selectedLanguage || !this.selectedLevel) {
                this.$swal("Error", "Please select a language and level.", "error");
                return;
            }

            const payload = {
                language: this.selectedLanguage.name,
                flag: this.selectedLanguage.flag,
                level: Number(this.selectedLevel),
            };
            try {
                const response = await ResumeService.createLanguage(payload)
                this.$swal("Success", "Language has been added successfully!", "success");
                this.dialog = false;
                this.resetForm();
                this.$emit('language-added', payload);
            } catch (error) {
                this.$swal("Error", "An error occurred while saving the language.", "error");
                console.error(error);
            }
        },

        resetForm() {
            this.selectedLanguage = null;
            this.selectedLevel = null;
        }
    },
};
</script>
