<template>
  <div class="admin">
    <h2>Tableau de bord Admin — Gestion des chauffeurs</h2>

    <table v-if="chauffeurs.length > 0">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="chauffeur in chauffeurs" :key="chauffeur.id">
          <td>{{ chauffeur.name }}</td>
          <td>{{ chauffeur.email }}</td>
          <td>{{ chauffeur.statut }}</td>
          <td>
            <button @click="approuver(chauffeur.id)" :disabled="chauffeur.statut === 'approved'">
              Approuver
            </button>
            <button @click="refuser(chauffeur.id)" :disabled="chauffeur.statut === 'rejected'">
              Refuser
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <p v-else>Aucun chauffeur inscrit pour le moment.</p>
    <p v-if="message" class="message">{{ message }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminDashboard',
  data() {
    return {
      chauffeurs: [],
      message: ''
    };
  },
  created() {
    this.fetchChauffeurs();
  },
  methods: {
    async fetchChauffeurs() {
      try {
        const token = localStorage.getItem('access_token');
        const response = await axios.get('http://localhost:8000/api/admin/chauffeurs', {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.chauffeurs = response.data;
      } catch (error) {
        console.error(error);
        this.message = 'Erreur lors du chargement des chauffeurs.';
      }
    },
    async approuver(id) {
      try {
        const token = localStorage.getItem('access_token');
        await axios.post(`http://localhost:8000/api/admin/chauffeurs/${id}/approuver`, {}, {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.message = 'Chauffeur approuvé.';
        this.fetchChauffeurs();
      } catch (error) {
        console.error(error);
        this.message = 'Erreur lors de l\'approbation.';
      }
    },
    async refuser(id) {
      try {
        const token = localStorage.getItem('access_token');
        await axios.post(`http://localhost:8000/api/admin/chauffeurs/${id}/refuser`, {}, {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.message = 'Chauffeur refusé.';
        this.fetchChauffeurs();
      } catch (error) {
        console.error(error);
        this.message = 'Erreur lors du refus.';
      }
    }
  }
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: left;
}
button {
  margin-right: 5px;
}
.message {
  margin-top: 10px;
  color: green;
}
</style>
