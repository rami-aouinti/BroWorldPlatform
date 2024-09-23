<template>
    <v-container>
        <v-row>
            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>Products</v-card-title>
                    <v-card-text>
                        <v-list>
                            <v-list-item-group>
                                <v-list-item
                                    v-for="(item, index) in cartProducts.products"
                                    :key="index"
                                >
                                    <v-list-item-content>
                                        <v-list-item-title>{{ item.product.name }}</v-list-item-title>
                                        <v-list-item-subtitle>
                                            Qty: {{ item.quantity }} | Prix: {{ item.product.price }} €
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list-item-group>
                        </v-list>
                        <v-divider></v-divider>
                        <div>Total: {{ cartProducts.totals.price }} €</div>
                        <div>Qty Total: {{ cartProducts.totals.quantity }}</div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>Coordonnées du Client</v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="submitCheckout">
                            <v-text-field
                                v-model="customer.name"
                                label="Nom"
                                required
                            ></v-text-field>
                            <v-text-field
                                v-model="customer.email"
                                label="Email"
                                required
                                type="email"
                            ></v-text-field>
                            <v-text-field
                                v-model="customer.address"
                                label="Adresse"
                                required
                            ></v-text-field>
                            <v-text-field
                                v-model="customer.city"
                                label="Ville"
                                required
                            ></v-text-field>
                            <v-text-field
                                v-model="customer.zip"
                                label="Code Postal"
                                required
                            ></v-text-field>
                            <v-btn @click="goToPayment" color="primary">Payer</v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
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
        };
    },
    mounted() {
        this.fetchCartProducts();
    },
    methods: {
        async fetchCartProducts() {
            const response = await fetch('/api/cart');
            this.cartProducts = await response.json();
        },
        goToPayment() {
            // Redirige vers la page de paiement, en passant les informations nécessaires
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
