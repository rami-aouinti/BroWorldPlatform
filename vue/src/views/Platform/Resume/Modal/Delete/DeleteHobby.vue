<template>
    <div>
        <v-btn
            :ripple="false"
            color="transparent"
            class="text-danger font-weight-bolder shadow-0"
            small
            simple
            @click="removeHobby(deletedHobby.id)"
        >
            <v-icon size="16" class="me-0 material-icons-round">delete</v-icon>
        </v-btn>
    </div>
</template>

<script>
import ResumeService from "../../../../../services/resume.service";

export default {
    name: "DeleteHobby",
    props: {
        hobby: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialog: false,
            deletedHobby: { ...this.hobby },
        };
    },
    methods: {
        async removeHobby(hobbyId) {
            try {
                await ResumeService.deleteHobby(hobbyId);
                this.$emit("hobby-deleted", this.deletedHobby);
                this.$swal("Success", "Hobby has been removed successfully!", "success");
            } catch (error) {
                this.$swal("Error", "An error occurred while removing the hobby.", "error");
            }
        },
    },
};
</script>
