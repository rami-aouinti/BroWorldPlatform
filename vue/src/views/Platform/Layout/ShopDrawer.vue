<template>
    <div class="fixed-plugin" :class="showShopDrawer === true ? 'show' : ''">
        <v-card class="scrollable-card shadow-lg">
            <div class="card-padding mb-16">
                <div class="float-start">
                    <h5 class="text-h5 text-dark font-weight-bold mt-3 mb-0">
                        Cart
                    </h5>
                    <p class="text-body font-weight-light">Enjoy</p>
                </div>
                <div class="float-end mt-4">
                    <v-btn
                        :ripple="false"
                        icon
                        rounded
                        width="20px"
                        height="20px"
                        class="text-dark"
                        @click="$emit('toggleShopDrawer', false)"
                    >
                        <v-icon size="18" class="material-icons-round">clear</v-icon>
                    </v-btn>
                </div>
            </div>
            <hr class="horizontal dark my-1" />
            <div class="card-padding">
                <v-row v-if="carts.length > 0">
                    <v-col v-for="cart in carts" :key="cart.id" cols="12" md="12">
                            <v-card-title>
                                <v-row>
                                    <v-col cols="6">
                                        <v-avatar
                                            size="36"
                                            class="border border-white ms-n3"
                                        >
                                            <img :src="'http://localhost/img/products/' + cart.product.image" alt="Avatar" />
                                        </v-avatar>
                                        {{ cart.product.name }}
                                    </v-col>
                                    <v-col cols="6">
                                        <label class="text-sm text-body mb-0">Quantity: {{ cart.quantity }}</label>
                                        <v-select
                                            :items="numbers"
                                            v-model="cart.quantity"
                                            color="#e91e63"
                                            class="font-size-input input-style placeholder-light border-radius-md select-style mt-0"
                                            height="16"
                                            @change="updateCartQuantity(cart.product.id, cart.quantity)"
                                        >
                                        </v-select>
                                    </v-col>
                                </v-row>

                            </v-card-title>
                            <v-card-text>
                                Prix: {{ cart.product.price }} €
                            </v-card-text>
                            <v-card-actions>
                                <v-btn @click="addToCart(cart.product.id)">Add</v-btn>
                                <v-btn @click="increaseItem(cart.product.id)">Increase</v-btn>
                                <v-btn @click="removeItem(cart.product.id)">Remove</v-btn>
                            </v-card-actions>
                    </v-col>
                </v-row>

                <v-row v-else>
                    <v-col>
                        <p>Your cart is empty.</p>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="5">
                        <p>Total Qty: {{ totalQuantity }}</p>
                    </v-col>
                    <v-col cols="7">
                        <p>Total Price: {{ totalPrice }} €</p>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="6">
                        <v-btn @click="clearCart">Clean</v-btn>
                    </v-col>
                    <v-col cols="6">
                        <v-btn @click="goToCheckoutPage">Checkout</v-btn>
                    </v-col>
                </v-row>
            </div>
        </v-card>
    </div>
</template>

<script>
import Vue from "vue";
import VueGitHubButtons from "vue-github-buttons";
import "vue-github-buttons/dist/vue-github-buttons.css";
import ShopService from "../../../services/shop.service";

Vue.use(VueGitHubButtons);

export default {
    props: {
        showShopDrawer: {
            type: Boolean,
            default: false,
        },
        sidebarColor: {
            type: String,
            default: "success",
        },
        sidebarTheme: {
            type: String,
            default: "dark",
        },
        navbarFixed: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            sidebarColorModel: this.sidebarColor,
            isActive: false,
            navbarFixedModel: this.navbarFixed,
            carts: [],
            totalQuantity: 0,
            totalPrice: 0,
            quantity: 1,
            numbers: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
        };
    },
    async mounted() {
        await this.getCart();
    },
    methods: {
        goToCheckoutPage() {
            this.$emit('toggleShopDrawer', false);
            this.$router.push({ name: 'checkout' });
        },
        active: function () {
            this.isActive = !this.isActive;
        },
        async getCart() {
            const cartData = await ShopService.getCart();
            this.carts = cartData ? cartData : [];
            this.totalQuantity = this.carts.reduce((total, cart) => total + cart.quantity, 0);
            this.totalPrice = this.carts.reduce((total, cart) => total + cart.quantity * cart.product.price, 0);
        },
        async addToCart(productId) {
            await ShopService.addToCart(productId);
            await this.getCart();
        },
        async increaseItem(productId) {
            await ShopService.decreaseItem(productId);
            await this.getCart();
        },
        async removeItem(productId) {
            await ShopService.removeItem(productId);
            await this.getCart();
        },
        async clearCart() {
            await ShopService.clearCart();
            await this.getCart();
        },
        async updateCartQuantity(productId, quantity) {
            await ShopService.addToCart(productId, quantity);
            await this.$emit('updateCart');
        }
    },
};
</script>
<style>
.scrollable-card {
    overflow-y: auto; /* Activer le scroll vertical */
}
</style>
