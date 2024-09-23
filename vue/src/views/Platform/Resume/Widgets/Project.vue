<template>
    <v-card>
        <div class="px-4 pt-4">
            <h6 class="mb-1 text-typo text-h6 font-weight-bold">Projects</h6>
            <p class="text-sm text-body">List of projects and references</p>
        </div>
        <div class="px-4 py-4">
            <v-row>
                <v-col lg="3">
                    <v-card class="px-4 py-4 card-shadow border-radius-xl h-100">
                        <CreateReference @reference-added="addReference"></CreateReference>
                    </v-card>
                </v-col>
                <v-col v-for="card in cards" :key="card.title" lg="3" md="6">
                    <v-card>
                        <div class="position-relative">
                            <a class="d-block shadow-xl border-radius-xl">
                                <v-img :src="card.image" class="shadow border-radius-xl">
                                </v-img>
                            </a>
                        </div>
                        <div class="px-1 pt-6">
                            <p class="text-body font-weight-light mb-0 text-sm">
                                {{ card.title }}
                            </p>
                            <a href="javascript:" class="text-decoration-none">
                                <h5 class="text-h5 font-weight-bold text-typo mb-2">
                                    {{ card.style }}
                                </h5>
                            </a>
                            <p class="mb-6 text-sm text-body font-weight-light">
                                {{ card.description }}
                            </p>
                            <div class="d-flex align-center justify-space-between">
                                <v-btn
                                    outlined
                                    color="#e91e63"
                                    class="font-weight-bolder py-4 px-5"
                                    small
                                >
                                    View Project
                                </v-btn>
                                <span class="avatar-group d-flex">
                        <v-tooltip
                            bottom
                            color="#212529"
                            v-for="avatar in card.avatars"
                            :key="avatar.name"
                        >
                          <template v-slot:activator="{ on, attrs }">
                            <v-avatar
                                v-bind="attrs"
                                v-on="on"
                                size="24"
                                class="border border-white ms-n3"
                            >
                              <img :src="avatar.image" alt="Avatar" />
                            </v-avatar>
                          </template>
                          <span>{{ avatar.name }}</span>
                        </v-tooltip>
                      </span>
                            </div>
                        </div>
                    </v-card>
                </v-col>
            </v-row>
        </div>
    </v-card>
</template>
<script>

import {mapGetters} from "vuex";
import CreateReference from "../Modal/Create/CreateReference.vue";

export default {
    name: "Project",
    components: {
        CreateReference
    },
    data: function () {
        return {
            cards: [
                {
                    image: require("@/assets/img/home-decor-1.jpg"),
                    title: "Project #2",
                    style: "Modern",
                    description:
                        "As Uber works through a huge amount of internal management turmoil.",
                    avatars: [
                        {
                            image: require("@/assets/img/team-1.jpg"),
                            name: "Elena Morison",
                        },
                        {
                            image: require("@/assets/img/team-2.jpg"),
                            name: "Ryan Milly",
                        },
                        {
                            image: require("@/assets/img/team-3.jpg"),
                            name: "Nick Daniel",
                        },
                        {
                            image: require("@/assets/img/team-4.jpg"),
                            name: "Peterson",
                        },
                    ],
                },
                {
                    image: require("@/assets/img/home-decor-2.jpg"),
                    title: "Project #1",
                    style: "Scandinavian",
                    description:
                        "Music is something that every person has his or her own specific opinion about.",
                    avatars: [
                        {
                            image: require("@/assets/img/team-3.jpg"),
                            name: "Nick Daniel",
                        },
                        {
                            image: require("@/assets/img/team-4.jpg"),
                            name: "Peterson",
                        },
                        {
                            image: require("@/assets/img/team-1.jpg"),
                            name: "Elena Morison",
                        },
                        {
                            image: require("@/assets/img/team-2.jpg"),
                            name: "Ryan Milly",
                        },
                    ],
                },
                {
                    image: require("@/assets/img/home-decor-3.jpg"),
                    title: "Project #3",
                    style: "Minimalist",
                    description:
                        "Different people have different taste, and various types of music.",
                    avatars: [
                        {
                            image: require("@/assets/img/team-4.jpg"),
                            name: "Peterson",
                        },
                        {
                            image: require("@/assets/img/team-3.jpg"),
                            name: "Nick Daniel",
                        },
                        {
                            image: require("@/assets/img/team-2.jpg"),
                            name: "Ryan Milly",
                        },
                        {
                            image: require("@/assets/img/team-1.jpg"),
                            name: "Elena Morison",
                        },
                    ],
                },
            ],
        };
    },
    computed: {
        ...mapGetters('user', ['user']),
    },
    methods: {
    addReference(reference) {
        this.user.references.push(reference);
    }
}
};
</script>
