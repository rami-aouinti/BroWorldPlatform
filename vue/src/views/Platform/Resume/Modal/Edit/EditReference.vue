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
                <v-card-title class="text-h5">Edit Reference</v-card-title>

                <v-card-text>
                    <v-form ref="form">
                        <v-text-field
                            v-model="editedSkill.name"
                            label="reference Name"
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
    name: "EditReference",
    props: {
        reference: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialog: false,
            editedReference: { ...this.reference },
        };
    },
    methods: {
        async submitEdit() {
            const payload = {
                id: this.editedReference.id,
                name: this.editedReference.name,
                type: this.editedReference.type,
                level: Number(this.editedReference.level),
            };
            try {
                const response = await ResumeService.updateReference(this.editedReference.id ,payload);
                this.$swal("Success", "Reference has been updated successfully!", "success");
                this.$emit("reference-updated", this.editedReference);
                this.dialog = false;
            } catch (error) {
                this.$swal("Error", "An error occurred while saving the reference.", "error");
                console.error(error);
            }
        },
    },
};
</script>
