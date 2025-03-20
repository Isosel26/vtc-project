<template>
    <div class="register">
      <h2>Inscription</h2>
      <form @submit.prevent="register">
        <div>
          <label for="first_name">Prénom :</label>
          <input type="text" v-model="firstName" id="first_name" required />
        </div>
        <div>
          <label for="last_name">Nom :</label>
          <input type="text" v-model="lastName" id="last_name" required />
        </div>
        <div>
          <label for="email">Email :</label>
          <input type="email" v-model="email" id="email" required />
        </div>
        <div>
          <label for="password">Mot de passe :</label>
          <input type="password" v-model="password" id="password" required />
        </div>
        <div>
          <label for="password_confirmation">Confirmer le mot de passe :</label>
          <input type="password" v-model="passwordConfirmation" id="password_confirmation" required />
        </div>
        <button type="submit">S'inscrire</button>
      </form>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'Register',
    data() {
      return {
        firstName: '',
        lastName: '',
        email: '',
        password: '',
        passwordConfirmation: '',
        errorMessage: ''
      };
    },
    methods: {
      async register() {
        // Vérifie que le mot de passe et sa confirmation correspondent
        if (this.password !== this.passwordConfirmation) {
          this.errorMessage = "Les mots de passe ne correspondent pas.";
          return;
        }
        try {
          // Concatène prénom et nom pour former le champ "name"
          const fullName = this.firstName + ' ' + this.lastName;
          const response = await axios.post('http://localhost:8000/api/register/client', {
            name: fullName,
            email: this.email,
            password: this.password,
            password_confirmation: this.passwordConfirmation
          });
          alert('Inscription réussie ! Vous pouvez maintenant vous connecter.');
          // Redirige vers la page de connexion
          this.$router.push('/login');
        } catch (error) {
          console.error(error);
          if (error.response && error.response.data && error.response.data.errors) {
            // Rassemble les messages d'erreur
            this.errorMessage = Object.values(error.response.data.errors).join(' ');
          } else {
            this.errorMessage = 'Erreur lors de l\'inscription.';
          }
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
  