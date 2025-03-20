<template>
    <div>
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
      };
    },
    methods: {
      async login() {
        try {
          // Assure-toi que l'URL correspond à ton API Laravel
          const response = await axios.post('http://localhost:8000/api/login', {
            email: this.email,
            password: this.password,
          });
          const token = response.data.access_token;
          localStorage.setItem('access_token', token);
          alert('Connexion réussie !');
          // Redirige selon le rôle (ici, on redirige vers /client par défaut)
          this.$router.push('/client');
        } catch (error) {
          console.error(error);
          alert('Erreur lors de la connexion.');
        }
      },
    },
  };
  </script>
  