<template>
    <div>
        <v-btn
            :ripple="false"
            color="transparent"
            class="text-danger font-weight-bolder shadow-0"
            small
            simple
            @click="removeReference(deletedReference.id)"
        >
            <v-icon size="16" class="me-0 material-icons-round">delete</v-icon>
        </v-btn>
    </div>
</template>

<script>
import ResumeService from "../../../../../services/resume.service";

export default {
    name: "DeleteReference",
    props: {
        reference: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialog: false,
            deletedReference: { ...this.reference },
        };
    },
    methods: {
        async removeReference(referenceId) {
            try {
                await ResumeService.deleteReference(referenceId);
                this.$emit("reference-deleted", this.deletedReference);
                this.$swal("Success", "Reference has been removed successfully!", "success");
            } catch (error) {
                this.$swal("Error", "An error occurred while removing the reference.", "error");
            }
        },
    },
};
</script>
