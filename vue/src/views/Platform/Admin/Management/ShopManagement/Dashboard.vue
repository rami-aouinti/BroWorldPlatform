<template>
  <div>
    <v-container fluid class="px-6 py-6">
        <v-row>
            <v-col md="12">
                <v-row>
                    <v-col sm="4" cols="12">
                        <div @click="goToCategoriesPage" style="cursor: pointer;">
                            <v-card class="mb-6 card-shadow border-radius-xl py-4">
                                <v-row no-gutters class="px-4">
                                    <v-col sm="4">
                                        <v-avatar
                                            color="bg-gradient-primary border-radius-xl mt-n8"
                                            class="shadow-primary"
                                            height="64"
                                            width="64"
                                        >
                                            <v-icon class="material-icons-round text-white" size="24"
                                            >leaderboard</v-icon
                                            >
                                        </v-avatar>
                                    </v-col>
                                    <v-col sm="8" class="text-end">

                                        <p class="text-sm mb-0 text-capitalize text-body font-weight-light">
                                            Total Categories
                                        </p>
                                        <h4 class="text-h4 text-typo font-weight-bolder mb-0">
                                            {{ this.categoryCount }}
                                        </h4>
                                    </v-col>
                                </v-row>
                                <hr class="dark horizontal mt-3 mb-4" />
                                <v-row class="px-4">
                                    <v-col cols="12">
                                        <p class="mb-0 text-body">
                                            <span class="text-sm font-weight-bolder">Category Management</span>
                                        </p>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </div>
                    </v-col>
                    <v-col sm="4" cols="12">
                        <div @click="goToProductsPage" style="cursor: pointer;">
                            <v-card class="mb-6 card-shadow border-radius-xl py-4">
                                <v-row no-gutters class="px-4">
                                    <v-col sm="4">
                                        <v-avatar
                                            color="bg-gradient-default border-radius-xl mt-n8"
                                            class="shadow-dark"
                                            height="64"
                                            width="64"
                                        >
                                            <v-icon class="material-icons-round text-white" size="24"
                                            >weekend</v-icon
                                            >
                                        </v-avatar>
                                    </v-col>
                                    <v-col sm="8" class="text-end">

                                        <p
                                            class="text-sm mb-0 text-capitalize text-body font-weight-light">
                                            Products
                                        </p>
                                        <h4 class="text-h4 text-typo font-weight-bolder mb-0">
                                            {{ this.productsCount }}
                                        </h4>

                                    </v-col>
                                </v-row>
                                <hr class="dark horizontal mt-3 mb-4" />
                                <v-row class="px-4">
                                    <v-col cols="12">
                                        <p class="mb-0 text-body">
                                            <span class="text-sm font-weight-bolder">Products Management</span>
                                        </p>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </div>
                    </v-col>
                    <v-col sm="4" cols="12">
                        <div @click="goToOrdersPage" style="cursor: pointer;">
                            <v-card class="mb-6 card-shadow border-radius-xl py-4">
                                <v-row no-gutters class="px-4">
                                    <v-col sm="4">
                                        <v-avatar
                                            color="bg-gradient-success border-radius-xl mt-n8"
                                            class="shadow-success"
                                            height="64"
                                            width="64"
                                        >
                                            <v-icon class="material-icons-round text-white" size="24"
                                            >store</v-icon
                                            >
                                        </v-avatar>
                                    </v-col>
                                    <v-col sm="8" class="text-end">

                                        <p
                                            class="text-sm mb-0 text-capitalize text-body font-weight-light">
                                            Orders
                                        </p>
                                        <h4 class="text-h4 text-typo font-weight-bolder mb-0">
                                            {{ this.ordersCount }}
                                        </h4>

                                    </v-col>
                                </v-row>
                                <hr class="dark horizontal mt-3 mb-4" />
                                <v-row class="px-4">
                                    <v-col cols="12">
                                        <p class="mb-0 text-body">
                                            <span class="text-sm font-weight-bolder">Order Management</span>
                                        </p>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </div>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
  </div>
</template>

<script>
import ShopService from "../../../../../services/admin/shop.service";

export default {
  name: "Dashboard",
  data() {
    return {
        categoryCount: 0,
        ordersCount: 0,
        productsCount: 0
    };
  },
    methods: {
        goToCategoriesPage() { this.$router.push({ name: 'AdminShopCategory' });},
        goToProductsPage() { this.$router.push({ name: 'AdminShopProduct' });},
        goToOrdersPage() { this.$router.push({ name: 'AdminShopOrder' });},
    },
    mounted() {

        ShopService.getTotalCategories().then(
            (response) => {
                this.categoryCount = response.count;
            },
            (error) => {
                this.content =
                    (error.response && error.response.data) ||
                    error.message ||
                    error.toString();
            }
        );

        ShopService.getTotalOrders().then(
            (response) => {
                this.ordersCount = response.count;
            },
            (error) => {
                this.content =
                    (error.response && error.response.data) ||
                    error.message ||
                    error.toString();
            }
        );

        ShopService.getTotalProducts().then(
            (response) => {
                this.productsCount = response.count;
            },
            (error) => {
                this.content =
                    (error.response && error.response.data) ||
                    error.message ||
                    error.toString();
            }
        );

    }
};
</script>
