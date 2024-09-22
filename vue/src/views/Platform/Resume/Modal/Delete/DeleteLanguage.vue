<template>
    <div>
        <v-btn
            :ripple="false"
            color="transparent"
            class="text-danger font-weight-bolder shadow-0"
            small
            simple
            @click="removeLanguage(deletedLanguage.id)"
        >
            <v-icon size="16" class="me-0 material-icons-round">delete</v-icon>
        </v-btn>
    </div>
</template>

<script>
import ResumeService from "../../../../../services/resume.service";

export default {
    name: "DeleteLanguage",
    props: {
        language: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialog: false,
            deletedLanguage: { ...this.language },
        };
    },
    methods: {
        async removeLanguage(languageId) {
            try {
                await ResumeService.deleteLanguage(languageId);
                this.$emit("language-deleted", this.deletedLanguage);
                this.$swal("Success", "Language has been removed successfully!", "success");
            } catch (error) {
                this.$swal("Error", "An error occurred while removing the language.", "error");
            }
        },
    },
};
</script>
