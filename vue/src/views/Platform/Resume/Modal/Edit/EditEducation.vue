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
                <v-card-title class="text-h5">Edit Education</v-card-title>

                <v-card-text>
                    <v-form ref="form">
                        <v-text-field
                            v-model="editedEducation.name"
                            label="Formation Name"
                            required
                            outlined
                            dense
                        ></v-text-field>

                        <v-text-field
                            v-model="editedEducation.school"
                            label="School"
                            required
                            outlined
                            dense
                        ></v-text-field>

                        <v-select
                            v-model="editedEducation.selectedLevel"
                            :items="levels"
                            label="Select a Grade Level"
                            outlined
                            dense
                        ></v-select>

                        <v-textarea
                            v-model="editedEducation.description"
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
                                    v-model="editedEducation.startedAt"
                                    label="Start Date"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    outlined
                                    dense
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="editedEducation.startedAt" no-title scrollable>
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
                                    v-model="editedEducation.endedAt"
                                    label="End Date"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    outlined
                                    dense
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="editedEducation.endedAt" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menuEnd = false">OK</v-btn>
                            </v-date-picker>
                        </v-menu>
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
    name: "EditEducation",
    props: {
        education: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialog: false,
            editedEducation: { ...this.education },
            menu: false,
            menuEnd: false,
            levels: [1, 2, 3, 4, 5],
        };
    },
    methods: {
        async submitEdit() {
            const payload = {
                name: this.editedEducation.name,
                school: this.editedEducation.school,
                description: this.editedEducation.description,
                gradeLevel: Number(this.editedEducation.selectedLevel),
                startedAt: this.editedEducation.startedAt,
                endedAt: this.editedEducation.endedAt || null,
            };
            try {
                const response = await ResumeService.updateEducation(this.editedEducation.id ,payload);
                this.$swal("Success", "Education has been updated successfully!", "success");
                this.$emit("education-updated", this.editedEducation);
                this.dialog = false;
            } catch (error) {
                this.$swal("Error", "An error occurred while saving the education.", "error");
                console.error(error);
            }
        },
    },
};
</script>
