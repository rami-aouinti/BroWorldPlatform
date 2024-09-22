<template>
    <v-container fluid class="py-6">
        <v-row class="px-4">
            <Information></Information>
            <Skill></Skill>
        </v-row>
        <v-row class="px-4">
            <Education></Education>
            <Hobby></Hobby>
        </v-row>
        <v-col class="px-4">
            <Project></Project>
        </v-col>
    </v-container>
</template>
<script>

import Information from "./Widgets/Information.vue";
import Skill from "./Widgets/Skill.vue";
import Education from "./Widgets/Education.vue";
import Reference from "./Widgets/Reference.vue";
import Project from "./Widgets/Project.vue";
import {mapGetters} from "vuex";
import Hobby from "./Widgets/Hobby.vue";

export default {
  name: "Resume",
  components: {
      Hobby,
      Project,
      Reference,
      Education,
      Skill,
      Information
  },
  data: function () {
    return {
    };
  },
    computed: {
        ...mapGetters('profile', ['profile']),
        ...mapGetters('user', ['user']),
    },
};
</script>
