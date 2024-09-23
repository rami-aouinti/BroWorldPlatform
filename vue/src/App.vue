<template>
  <router-view></router-view>
</template>

<script>
import authHeader from "./services/auth-header";

export default {
    created() {
        this.checkAuth();
    },
    methods: {
        checkAuth() {
            if (!this.$store.state.auth.status.loggedIn) {
                this.logout();
            } else {
                this.verifyToken();
            }
        },
        async verifyToken() {
            try {
                const response = await fetch('http://localhost/api/v1/profile ', { headers: authHeader() });

                if (response.status === 401) {
                    this.logout();
                }
            } catch (error) {
                console.error('Erreur lors de la vérification du token', error);
            }
        },
        logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.$store.commit('auth/logout'); // Mutations pour déconnecter l'utilisateur
            this.$router.push("/login");
        }
    }
}
</script>
