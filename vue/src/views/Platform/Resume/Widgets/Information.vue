<template>
    <v-col lg="8">
            <v-row>
                <v-col md="12">
                    <div class="overflow-hidden position-relative border-radius-xl">
                        <img
                            src="@/assets/img/illustrations/pattern-tree.svg"
                            class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-10"
                        />
                        <span class="mask bg-gradient-default opacity-10"></span>
                        <v-row>
                            <v-col md="2"><v-avatar width="120" height="180" class="shadow border-radius-lg">
                                <img
                                    src="@/assets/img/bruce-mars.jpg"
                                    alt="Avatar"
                                    class="border-radius-lg"
                                />
                            </v-avatar></v-col>
                            <v-col md="10">
                                <div class="px-4 py-4 position-relative">

                                    <div class="me-4">
                                        <h6 class="text-white text-h6 mb-0">
                                            {{ this.profile.title }}
                                        </h6>
                                        <p class="text-white text-sm font-weight-light opacity-8 mb-0">{{ this.user.firstName }} {{ this.user.lastName }}</p>
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex">
                                            <div class="me-4">
                                                <h6 class="text-white text-h6 mb-0">
                                                    Email
                                                </h6>
                                                <p class="text-white text-sm font-weight-light opacity-8 mb-0">{{ this.user.email }}</p>
                                            </div>
                                            <div>
                                                <h6 class="text-white text-h6 mb-0">
                                                    Birthday
                                                </h6>
                                                <p class="text-white text-sm font-weight-light opacity-8 mb-0">08/1989</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex">
                                            <div class="me-4">
                                                <h6 class="text-white text-h6 mb-0">
                                                    Mobile
                                                </h6>
                                                <p class="text-white text-sm font-weight-light opacity-8 mb-0">{{ this.profile.mobile }}</p>
                                            </div>
                                            <div>
                                                <h6 class="text-white text-h6 mb-0">
                                                    Country
                                                </h6>
                                                <p class="text-white text-sm font-weight-light opacity-8 mb-0">{{ this.profile.address.country }}</p>
                                            </div>
                                        </div>

                                        <div
                                            class="ms-auto w-10 d-flex align-items-end justify-content-end mt-auto"
                                        >
                                            <v-img src="@/assets/img/logos/mastercard.png" alt="logo" width="22" height="22" contain
                                            ></v-img>
                                        </div>
                                    </div>
                                </div>
                            </v-col>

                        </v-row>

                    </div>
                </v-col>
                <v-col md="12">
                    <Language></Language>
                </v-col>
            </v-row>
        </v-col>
</template>
<script>

import {mapGetters} from "vuex";
import Language from "./Language.vue";

export default {
    name: "Information",
    components: {
        Language
    },
    data: function () {
        return {
        };
    },
    computed: {
        ...mapGetters('user', ['user']),
        ...mapGetters('profile', ['profile']),
    },
};
</script>
