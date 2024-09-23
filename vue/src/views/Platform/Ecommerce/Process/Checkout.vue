<template>
    <v-container fluid class="py-6">
        <v-row>
            <v-col lg="8" class="mx-auto">
                <v-card class="card-shadow border-radius-xl">
                    <div class="px-4 pt-4">
                        <div class="d-flex align-center">
                            <div>
                                <h6 class="text-h6 text-typo font-weight-bold mb-2">
                                    Checkout
                                </h6>
                                <p class="text-sm text-body font-weight-light mb-0">
                                    Order no. <span class="font-weight-bold">241342</span> from
                                    <span class="font-weight-bold">23.02.2021</span>
                                </p>
                                <p class="text-sm font-weight-light text-body">
                                    Code: <span class="font-weight-bold">KF332</span>
                                </p>
                            </div>
                            <v-btn
                                elevation="0"
                                :ripple="false"
                                height="43"
                                class="font-weight-bold text-uppercase btn-default bg-gradient-default py-2 px-6 me-2 ms-auto"
                                color="#5e72e4"
                                small>Invoice
                            </v-btn
                            >
                        </div>
                    </div>
                    <div class="px-4 pb-4">
                        <hr class="horizontal dark mt-0 mb-6" />
                        <v-row v-for="(product, index) in cartProducts" :key="index">
                            <v-col md="6">
                                <div class="d-flex">
                                    <v-avatar class="me-4 border-rounded" alt="product-image" width="60px" height="60px">
                                        <v-img :src="require('@/assets/img/products/product-12.jpg')">
                                        </v-img>
                                    </v-avatar>
                                    <div>
                                        <h6
                                            class="text-h6 text-typo text-lg font-weight-bold mb-0 mt-2 mb-1">
                                            {{ product.product.name }}
                                        </h6>
                                        <v-btn
                                            elevation="0"
                                            small
                                            :ripple="false"
                                            height="21"
                                            class="border-radius-lg bg-gradient-success text-xxs font-weight-bold px-2 py-2 badge-font-size ms-auto text-white"
                                            color="#cdf59b">{{ product.quantity }}
                                        </v-btn
                                        >
                                    </div>
                                </div>
                            </v-col>
                            <v-col md="6" class="text-end my-auto">
                                <v-btn
                                    elevation="0"
                                    :ripple="false"
                                    height="36"
                                    class="font-weight-bold text-uppercase btn-default bg-gradient-default px-4 me-2 ms-auto"
                                    color="#5e72e4"
                                    small
                                >Details</v-btn
                                >
                                <p class="text-sm text-body font-weight-light mt-2 mb-0">
                                    Do you like the product? Leave us a review
                                    <a href="javascript:" class="text-dark text-decoration-none">here</a>.
                                </p>
                            </v-col>
                        </v-row>
                        <hr class="horizontal dark my-6" />
                        <v-row>
                            <v-col lg="8" md="12">
                                <h6 class="text-h6 text-typo font-weight-bold mb-3">
                                    Billing Information
                                </h6>
                                <div
                                    class="d-flex flex-column bg-gray-100 pa-6 border-radius-lg"
                                >
                                    <v-form @submit.prevent="submitCheckout">
                                        <v-text-field
                                            v-model="customer.name"
                                            label="Nom"
                                            required
                                            rounded
                                            outlined
                                            dense
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="customer.email"
                                            label="Email"
                                            required
                                            type="email"
                                            rounded
                                            outlined
                                            dense
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="customer.address"
                                            label="Address"
                                            required
                                            rounded
                                            outlined
                                            dense
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="customer.city"
                                            label="Ville"
                                            required
                                            rounded
                                            outlined
                                            dense
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="customer.zip"
                                            label="Code Postal"
                                            required
                                            rounded
                                            outlined
                                            dense
                                        ></v-text-field>
                                        <v-btn @click="goToPayment" color="primary">Payer</v-btn>
                                    </v-form>
                                </div>
                            </v-col>
                            <v-col lg="4" md="12" class="ms-auto">
                                <h6 class="text-h6 text-typo font-weight-bold mb-3">
                                    Order Summary
                                </h6>
                                <div class="d-flex">
                                    <span class="mb-2 text-body text-sm"> Product Price: </span>
                                    <span class="text-dark font-weight-bold ms-auto">${{ this.totalPrice }}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="mb-2 text-body text-sm"> Delivery: </span>
                                    <span class="text-dark font-weight-bold ms-auto">$14</span>
                                </div>
                                <div class="d-flex">
                                    <span class="mb-2 text-body text-sm"> Taxes: </span>
                                    <span class="text-dark font-weight-bold ms-auto"
                                    >$1.95</span
                                    >
                                </div>
                                <div class="d-flex mt-6">
                                    <span class="mb-2 text-body text-lg"> Total: </span>
                                    <span
                                        class="text-dark text-lg ms-2 font-weight-bold ms-auto"
                                    >$105.95</span
                                    >
                                </div>
                            </v-col>
                        </v-row>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import ShopService from "../../../../services/shop.service";
import {mapGetters} from "vuex";

export default {
    data() {
        return {
            cartProducts: {
                products: [],
                totals: {
                    quantity: 0,
                    price: 0,
                },
            },
            customer: {
                name: '',
                email: '',
                address: '',
                city: '',
                zip: '',
            },
            timeline: [
                {
                    title: "Order received",
                    date: "22 DEC 7:20 PM",
                    color: "#b0eed3",
                    iconColor: "#1aae6f",
                    icon: "notifications",
                    btn: "secondary",
                },
                {
                    title: "Generate order id #1832412",
                    date: "22 DEC 7:21 AM",
                    color: "#b0eed3",
                    iconColor: "#1aae6f",
                    icon: "code",
                    btn: "secondary",
                },
                {
                    title: "Order transmited to courier",
                    date: "22 DEC 8:10 AM",
                    color: "#b0eed3",
                    iconColor: "#1aae6f",
                    icon: "shopping_cart",
                    btn: "secondary",
                },
                {
                    title: "Order delivered",
                    date: "22 DEC 4:54 PM",
                    color: "#b0eed3",
                    iconColor: "#1aae6f",
                    icon: "done",
                    btn: "success",
                },
            ],
            totalQuantity: 0,
            totalPrice: 0,
        };
    },
    mounted() {
        this.fetchCartProducts();
        this.customer.name = this.user.firstName;
        this.customer.email = this.user.email;
    },
    computed: {
        ...mapGetters('user', ['user']),
    },
    methods: {
        async fetchCartProducts() {
            const cartData = await ShopService.getCart();
            this.cartProducts = cartData ? cartData : [];
            this.totalQuantity = this.cartProducts.reduce((total, cart) => total + cart.quantity, 0);
            this.totalPrice = this.cartProducts.reduce((total, cart) => total + cart.quantity * cart.product.price, 0);
            console.log(this.cartProducts);

            console.log(this.totalQuantity);
            console.log(this.totalPrice);
        },
        goToPayment() {
            this.$router.push({
                name: 'payment', // Assure-toi que cette route est définie
                query: {
                    name: this.customer.name,
                    email: this.customer.email,
                    address: this.customer.address,
                    city: this.customer.city,
                    zip: this.customer.zip,
                },
            });
        },
    },
};
</script>

<style scoped>
</style>
