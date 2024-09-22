<template>
    <div>
        <v-btn
            :ripple="false"
            elevation="0"
            color="transparent"
            class="font-weight-bolder py-4 px-4 ms-auto"
            small
            @click="dialog = true"
        >
            <v-icon class="me-1" size="12">fa fa-edit</v-icon>
        </v-btn>

        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title class="text-h5">Edit Language</v-card-title>

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
                    <v-btn color="red darken-1" text @click="dialog = false">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="submitEdit">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import ResumeService from "../../../../../services/resume.service";

export default {
    name: "EditLanguage",
    props: {
        language: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialog: false,
            editedLanguage: { ...this.language },
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
    methods: {
        async submitEdit() {
            const payload = {
                language: this.selectedLanguage.name,
                flag: this.selectedLanguage.flag,
                level: Number(this.selectedLevel),
            };
            try {
                const response = await ResumeService.updateLanguage(this.editedLanguage.id ,payload);
                this.$swal("Success", "Language has been updated successfully!", "success");
                this.$emit("language-updated", this.editedLanguage);
                this.dialog = false;
            } catch (error) {
                this.$swal("Error", "An error occurred while saving the language.", "error");
                console.error(error);
            }
        },
    },
};
</script>
