<!-- EditSkill.vue -->
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
                <v-card-title class="text-h5">Edit Skill</v-card-title>

                <v-card-text>
                    <v-form ref="form">
                        <v-text-field
                            v-model="editedSkill.name"
                            label="Skill Name"
                            required
                            outlined
                            dense
                        ></v-text-field>

                        <v-text-field
                            v-model="editedSkill.type"
                            label="Type"
                            required
                            outlined
                            dense
                        ></v-text-field>

                        <v-select
                            v-model="editedSkill.level"
                            :items="[1, 2, 3, 4, 5]"
                            label="Select a Grade Level"
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
    name: "EditSkill",
    props: {
        skill: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialog: false,
            editedSkill: { ...this.skill },
        };
    },
    methods: {
        async submitEdit() {
            const payload = {
                id: this.editedSkill.id,
                name: this.editedSkill.name,
                type: this.editedSkill.type,
                level: Number(this.editedSkill.level),
            };
            try {
                const response = await ResumeService.updateSkill(this.editedSkill.id ,payload);
                this.$swal("Success", "Skill has been updated successfully!", "success");
                this.$emit("skill-updated", this.editedSkill);
                this.dialog = false;
            } catch (error) {
                this.$swal("Error", "An error occurred while saving the skill.", "error");
                console.error(error);
            }
        },
    },
};
</script>
