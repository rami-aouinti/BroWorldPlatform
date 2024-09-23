<template>
    <v-col md="5">
        <v-card class="card-shadow border-radius-xl h-100">
            <div class="px-4 pt-5 d-flex align-center">
                <h6 class="mb-0 text-typo text-h6 font-weight-bold">
                    References
                </h6>
                <CreateReference @reference-added="addReference"></CreateReference>
            </div>
            <div class="px-4 pt-6">
                <h6
                    class="text-uppercase text-body text-xs font-weight-bolder mb-3"
                >
                    Newest
                </h6>
                <div v-for="transaction in transactions1" :key="transaction.title">
                    <v-list-item :key="transaction.title" class="px-0 py-3">
                        <v-btn
                            :ripple="false"
                            icon
                            outlined
                            rounded
                            :color="transaction.color"
                            width="34px"
                            height="34px"
                            class="me-4"
                        >
                            <v-icon size="18" class="material-icons-round">{{
                                    transaction.icon
                                }}</v-icon>
                        </v-btn>

                        <v-list-item-content class="py-0">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-typo text-sm font-weight-bold">
                                    {{ transaction.title }}
                                </h6>
                                <span class="text-xs text-body">{{
                                        transaction.date
                                    }}</span>
                            </div>
                        </v-list-item-content>

                        <v-list-item-content class="py-0 text-end">
                            <div
                                :class="transaction.gradient"
                                class="text-sm font-weight-bold text-gradient"
                            >
                                {{ transaction.value }}
                            </div>
                        </v-list-item-content>
                    </v-list-item>
                </div>
                <h6
                    class="
                text-uppercase text-body text-xs
                font-weight-bolder
                mt-4
                mb-3
              "
                >
                    Yesterday
                </h6>
                <div v-for="transaction in transactions2" :key="transaction.title">
                    <v-list-item :key="transaction.title" class="px-0 py-3">
                        <v-btn
                            :ripple="false"
                            icon
                            outlined
                            rounded
                            :color="transaction.color"
                            width="34px"
                            height="34px"
                            class="me-4"
                        >
                            <v-icon size="18" class="material-icons-round">{{
                                    transaction.icon
                                }}</v-icon>
                        </v-btn>

                        <v-list-item-content class="py-0">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-typo text-sm font-weight-bold">
                                    {{ transaction.title }}
                                </h6>
                                <span class="text-xs text-body">{{
                                        transaction.date
                                    }}</span>
                            </div>
                        </v-list-item-content>

                        <v-list-item-content class="py-0 text-end">
                            <div
                                :class="transaction.gradient"
                                class="text-sm font-weight-bold text-gradient"
                            >
                                {{ transaction.value }}
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
import CreateEducation from "../Modal/Create/CreateEducation.vue";
import CreateReference from "../Modal/Create/CreateReference.vue";

export default {
    name: "Reference",
    components: {
        CreateReference,
        CreateEducation
    },
    data: function () {
        return {
            transactions1: [
                {
                    icon: "expand_more",
                    color: "#ea0606",
                    title: "Netflix",
                    date: "27 March 2020, at 12:30 PM",
                    value: "- $ 2,500",
                    gradient: "text-danger",
                },
                {
                    icon: "expand_less",
                    color: "#82d616",
                    title: "Apple",
                    date: "23 March 2020, at 04:30 AM",
                    value: "+ $ 2,000",
                    gradient: "text-success",
                },
            ],
            transactions2: [
                {
                    icon: "expand_more",
                    color: "#82d616",
                    title: "Stripe",
                    date: "26 March 2020, at 13:45 PM",
                    value: "+ $ 750",
                    gradient: "text-success",
                },
                {
                    icon: "expand_more",
                    color: "#82d616",
                    title: "HubSpot",
                    date: "26 March 2020, at 12:30 PM",
                    value: "+ $ 1,000",
                    gradient: "text-success",
                },
                {
                    icon: "expand_more",
                    color: "#82d616",
                    title: "Creative Tim",
                    date: "26 March 2020, at 08:30 AM",
                    value: "+ $ 2,500",
                    gradient: "text-success",
                },
                {
                    icon: "priority_high",
                    color: "#344767",
                    title: "Webflow",
                    date: "26 March 2020, at 05:00 AM",
                    value: "Pending",
                    gradient: "text-default",
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
