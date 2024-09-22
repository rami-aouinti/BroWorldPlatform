<template>
    <v-col md="4">
        <v-card class="card-shadow border-radius-xl">
            <div class="px-4 pt-4 d-flex align-center">
                <h6 class="mb-0 text-h6 font-weight-bold text-typo">
                    Hobby
                </h6>
                <CreateHobby @hobby-added="addHobby"></CreateHobby>
            </div>
            <div class="px-4 pt-6 pb-1">
                <div v-for="(hobby, index) in this.user.hobbies"
                     :key="index">
                    <v-list-item
                        :key="hobby.name"
                        class="px-0 py-1 bg-gray-100 border border-radius-lg p-6 mb-6"
                    >
                        <v-list-item-content class="px-4">
                            <div class="d-flex align-center">
                                <v-icon size="16" class="me-2 material-icons-round"
                                >{{ hobby.icon }}</v-icon
                                >
                                <h6 class="text-sm text-typo font-weight-bold">
                                    {{ hobby.name }}
                                </h6>
                            </div>
                        </v-list-item-content>

                        <v-list-item-content class="py-0 text-end">
                            <div class="d-flex align-center text-sm text-body">
                                <EditHobby :hobby="hobby" @hobby-updated="updateHobby"></EditHobby>
                                <DeleteHobby :hobby="hobby" @hobby-deleted="deletedHobby"></DeleteHobby>
                            </div>
                        </v-list-item-content>
                    </v-list-item>
                </div>
            </div>
        </v-card>
    </v-col>
</template>
<script>

import {mapGetters} from "vuex";
import CreateHobby from "../Modal/Create/CreateHobby.vue";
import EditHobby from "../Modal/Edit/EditHobby.vue";
import DeleteHobby from "../Modal/Delete/DeleteHobby.vue";

export default {
    name: "Hobby",
    components: {
        DeleteHobby,
        EditHobby,
        CreateHobby
    },
    data: function () {
        return {

        };
    },
    computed: {
        ...mapGetters('user', ['user']),
    },
    methods: {
        addHobby(hobby) {
            this.user.hobbies.push(hobby);
        },
        updateHobby(updatedHobby) {
            const index = this.user.hobbies.findIndex(hobby => hobby.id === updatedHobby.id);
            if (index !== -1) {
                this.$set(this.user.hobbies, index, updatedHobby);
            }
        },
        deletedHobby(deletedHobby) {
            this.user.hobbies = this.user.hobbies.filter(hobby => hobby.id !== deletedHobby.id);
        },
    }
};
</script>
