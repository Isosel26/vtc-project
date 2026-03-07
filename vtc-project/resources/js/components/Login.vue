<template>
  <div class="login">
    <h2>Connexion</h2>
    <form @submit.prevent="login">
      <div>
        <label for="email">Email :</label>
        <input type="email" v-model="email" id="email" required />
      </div>
      <div>
        <label for="password">Mot de passe :</label>
        <input type="password" v-model="password" id="password" required />
      </div>
      <button type="submit">Se connecter</button>
    </form>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: '',
      errorMessage: ''
    };
  },
  methods: {
    async login() {
      try {
        let response;
        try {
          response = await axios.post('http://localhost:8000/api/admin/login', {
            email: this.email,
            password: this.password
          });
        } catch {
          response = await axios.post('http://localhost:8000/api/login', {
            email: this.email,
            password: this.password
          });
        }

        const token = response.data.access_token;
        const role = response.data.role;
        const statut = response.data.statut;

        localStorage.setItem('access_token', token);
        localStorage.setItem('user_role', role);

        // On stocke le statut uniquement pour les chauffeurs
        if (statut) {
          localStorage.setItem('chauffeur_statut', statut);
        }

        if (role === 'admin') {
          this.$router.push('/admin');
        } else if (role === 'client') {
          this.$router.push('/client');
        } else if (role === 'chauffeur') {
          this.$router.push('/chauffeur');
        } else {
          this.$router.push('/');
        }
      } catch (error) {
        console.error(error);
        this.errorMessage = 'Erreur lors de la connexion. Vérifiez vos identifiants.';
      }
    }
  }
};
</script>

<style scoped>
.error {
  color: red;
}
</style>
