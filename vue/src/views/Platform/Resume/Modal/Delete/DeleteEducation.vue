<template>
    <div>
        <v-btn
            :ripple="false"
            color="transparent"
            class="text-danger font-weight-bolder shadow-0"
            small
            simple
            @click="removeEducation(deletedEducation.id)"
        >
            <v-icon size="16" class="me-0 material-icons-round">delete</v-icon>
        </v-btn>
    </div>
</template>

<script>
import ResumeService from "../../../../../services/resume.service";

export default {
    name: "DeleteEducation",
    props: {
        education: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialog: false,
            deletedEducation: { ...this.education },
        };
    },
    methods: {
        async removeEducation(educationId) {
            try {
                await ResumeService.deleteEducation(educationId);
                this.$emit("education-deleted", this.deletedEducation);
                this.$swal("Success", "Education has been removed successfully!", "success");
            } catch (error) {
                this.$swal("Error", "An error occurred while removing the education.", "error");
            }
        },
    },
};
</script>
