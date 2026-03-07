<template>
  <div class="page">
    <div class="card">
      <h2>Connexion</h2>
      <form @submit.prevent="login">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" v-model="email" id="email" placeholder="votre@email.fr" required />
        </div>
        <div class="form-group">
          <label for="password">Mot de passe</label>
          <input type="password" v-model="password" id="password" placeholder="••••••••" required />
        </div>
        <button type="submit" class="btn">Se connecter</button>
      </form>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      <router-link to="/register" class="link">Pas encore de compte ? S'inscrire</router-link>
    </div>
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
        if (statut) localStorage.setItem('chauffeur_statut', statut);

        if (role === 'admin') this.$router.push('/admin');
        else if (role === 'client') this.$router.push('/client');
        else if (role === 'chauffeur') this.$router.push('/chauffeur');
        else this.$router.push('/');
      } catch (error) {
        console.error(error);
        this.errorMessage = 'Identifiants incorrects. Veuillez réessayer.';
      }
    }
  }
};
</script>

<style scoped>
.page {
  min-height: 100vh;
  background-color: #0a0a0a;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  position: relative;
  overflow: hidden;
}

.page::before {
  content: '';
  position: absolute;
  top: -100px;
  right: -100px;
  width: 350px;
  height: 350px;
  background: #ffffff;
  border-radius: 50% 40% 60% 30% / 40% 50% 30% 60%;
  opacity: 0.06;
}

.page::after {
  content: '';
  position: absolute;
  bottom: -120px;
  left: -80px;
  width: 400px;
  height: 400px;
  background: #ffffff;
  border-radius: 60% 40% 30% 50% / 50% 60% 40% 30%;
  opacity: 0.06;
}

.card {
  background-color: #1a1a1a;
  border: 1px solid #2a2a2a;
  border-radius: 16px;
  padding: 2.5rem;
  width: 100%;
  max-width: 420px;
  position: relative;
  z-index: 1;
}

.card h2 {
  font-size: 1.5rem;
  font-weight: 900;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 2rem;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: #aaaaaa;
  margin-bottom: 0.4rem;
}

.form-group input {
  width: 100%;
  padding: 0.8rem 1rem;
  background-color: #2a2a2a;
  border: 1px solid #3a3a3a;
  border-radius: 10px;
  color: #ffffff;
  font-size: 0.95rem;
  font-family: 'Inter', sans-serif;
  outline: none;
  transition: border-color 0.2s;
}

.form-group input:focus {
  border-color: #888888;
}

.form-group input::placeholder {
  color: #555555;
}

.btn {
  width: 100%;
  padding: 0.85rem;
  background-color: #888888;
  color: #ffffff;
  border: none;
  border-radius: 10px;
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  cursor: pointer;
  margin-top: 0.75rem;
  transition: background-color 0.2s;
  font-family: 'Inter', sans-serif;
}

.btn:hover {
  background-color: #aaaaaa;
}

.error {
  color: #ff6b6b;
  font-size: 0.85rem;
  text-align: center;
  margin-top: 1rem;
}

.link {
  color: #aaaaaa;
  text-decoration: none;
  font-size: 0.82rem;
  text-align: center;
  display: block;
  margin-top: 1.25rem;
  transition: color 0.2s;
}

.link:hover {
  color: #ffffff;
}
</style>
