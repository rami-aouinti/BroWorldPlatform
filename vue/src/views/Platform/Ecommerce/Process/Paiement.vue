<template>
    <v-container>
        <v-card>
            <v-card-title>Payment</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="submitPayment">
                    <v-text-field
                        v-model="payment.cardNumber"
                        label="Numéro de Carte"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="payment.expiryDate"
                        label="Date d'Expiration (MM/AA)"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="payment.cvc"
                        label="CVC"
                        required
                    ></v-text-field>
                    <v-btn type="submit" color="primary">Confirmer le Paiement</v-btn>
                </v-form>
            </v-card-text>
        </v-card>
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
