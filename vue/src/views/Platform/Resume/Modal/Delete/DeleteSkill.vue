<!-- DeleteSkill.vue -->
<template>
    <div>
        <v-btn
            :ripple="false"
            color="transparent"
            class="text-danger font-weight-bolder shadow-0"
            small
            simple
            @click="removeSkill(deletedSkill.id)"
        >
            <v-icon size="16" class="me-0 material-icons-round">delete</v-icon>
        </v-btn>
    </div>
</template>

<script>
import ResumeService from "../../../../../services/resume.service";
import skill from "../../Widgets/Skill.vue";

export default {
    name: "DeleteSkill",
    props: {
        skill: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialog: false,
            deletedSkill: { ...this.skill },
        };
    },
    methods: {
        async removeSkill(skillId) {
            try {
                await ResumeService.deleteSkill(skillId);
                this.$emit("skill-deleted", this.deletedSkill);
                this.$swal("Success", "Skill has been removed successfully!", "success");
            } catch (error) {
                this.$swal("Error", "An error occurred while removing the skill.", "error");
            }
        },
    },
};
</script>
