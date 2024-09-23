<template>
    <v-container fluid class="py-6">
        <v-row>
            <v-col lg="8" class="mx-auto">
                <v-card class="card-shadow border-radius-xl">
                    <div class="px-4 pt-4">
                        <div class="d-flex align-center">
                            <div>
                                <h6 class="text-h6 text-typo font-weight-bold mb-2">
                                    Payment
                                </h6>
                                <v-form @submit.prevent="submitPayment">
                                    <v-text-field
                                        v-model="payment.cardNumber"
                                        label="Numéro de Carte"
                                        required
                                        rounded
                                        outlined
                                        dense
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="payment.expiryDate"
                                        label="Date d'Expiration (MM/AA)"
                                        required
                                        rounded
                                        outlined
                                        dense
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="payment.cvc"
                                        label="CVC"
                                        required
                                        rounded
                                        outlined
                                        dense
                                    ></v-text-field>
                                    <v-btn type="submit">Confirm</v-btn>
                                </v-form>
                            </div>
                        </div>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            payment: {
                cardNumber: '',
                expiryDate: '',
                cvc: '',
            },
        };
    },
    methods: {
        submitPayment() {
            // Logique pour traiter le paiement
            console.log('Détails du paiement:', this.payment);
            // Ajoute la logique d'envoi au serveur ici
        },
    },
};
</script>

<style scoped>
</style>
