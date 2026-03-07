<template>
  <div class="page">
    <div class="container">
      <h2>Admin — Chauffeurs</h2>

      <p v-if="message" :class="['feedback', messageType]">{{ message }}</p>

      <p v-if="chauffeurs.length === 0" class="empty">Aucun chauffeur inscrit pour le moment.</p>

      <div v-else class="driver-list">
        <div v-for="chauffeur in chauffeurs" :key="chauffeur.id" class="driver-card">
          <div class="driver-info">
            <span class="driver-name">{{ chauffeur.name }}</span>
            <span class="driver-email">{{ chauffeur.email }}</span>
          </div>
          <div class="driver-right">
            <span :class="['badge', 'badge--' + chauffeur.statut]">{{ chauffeur.statut }}</span>
            <div class="actions">
              <button
                @click="approuver(chauffeur.id)"
                :disabled="chauffeur.statut === 'approved'"
                class="btn btn--approve"
              >Approuver</button>
              <button
                @click="refuser(chauffeur.id)"
                :disabled="chauffeur.statut === 'rejected'"
                class="btn btn--reject"
              >Refuser</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminDashboard',
  data() {
    return {
      chauffeurs: [],
      message: '',
      messageType: 'success'
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
        this.messageType = 'error';
      }
    },
    async approuver(id) {
      try {
        const token = localStorage.getItem('access_token');
        await axios.post(`http://localhost:8000/api/admin/chauffeurs/${id}/approuver`, {}, {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.message = 'Chauffeur approuvé.';
        this.messageType = 'success';
        this.fetchChauffeurs();
      } catch (error) {
        console.error(error);
        this.message = 'Erreur lors de l\'approbation.';
        this.messageType = 'error';
      }
    },
    async refuser(id) {
      try {
        const token = localStorage.getItem('access_token');
        await axios.post(`http://localhost:8000/api/admin/chauffeurs/${id}/refuser`, {}, {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.message = 'Chauffeur refusé.';
        this.messageType = 'success';
        this.fetchChauffeurs();
      } catch (error) {
        console.error(error);
        this.message = 'Erreur lors du refus.';
        this.messageType = 'error';
      }
    }
  }
};
</script>

<style scoped>
.page {
  min-height: 100vh;
  background-color: #0a0a0a;
  padding: 3rem 2rem;
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
  opacity: 0.05;
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
  opacity: 0.05;
}

.container {
  max-width: 800px;
  margin: 0 auto;
  position: relative;
  z-index: 1;
}

h2 {
  font-size: 1.8rem;
  font-weight: 900;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 2rem;
}

.feedback {
  text-align: center;
  font-size: 0.85rem;
  font-weight: 600;
  padding: 0.75rem 1.25rem;
  border-radius: 10px;
  margin-bottom: 1.5rem;
}

.feedback.success {
  background-color: #0d2b1a;
  color: #4caf50;
  border: 1px solid #4caf50;
}

.feedback.error {
  background-color: #2b0d0d;
  color: #f44336;
  border: 1px solid #f44336;
}

.driver-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.driver-card {
  background-color: #1a1a1a;
  border: 1px solid #2a2a2a;
  border-radius: 14px;
  padding: 1.25rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}

.driver-info {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.driver-name {
  font-size: 1rem;
  font-weight: 700;
  color: #ffffff;
}

.driver-email {
  font-size: 0.8rem;
  color: #666666;
}

.driver-right {
  display: flex;
  align-items: center;
  gap: 1rem;
  flex-shrink: 0;
}

.badge {
  font-size: 0.65rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  padding: 0.3rem 0.75rem;
  border-radius: 20px;
}

.badge--pending {
  background-color: #2a2000;
  color: #ffc107;
  border: 1px solid #ffc107;
}

.badge--approved {
  background-color: #0d2b1a;
  color: #4caf50;
  border: 1px solid #4caf50;
}

.badge--rejected {
  background-color: #2b0d0d;
  color: #f44336;
  border: 1px solid #f44336;
}

.actions {
  display: flex;
  gap: 0.5rem;
}

.btn {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 8px;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  cursor: pointer;
  transition: opacity 0.2s;
  font-family: 'Inter', sans-serif;
}

.btn:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

.btn--approve {
  background-color: #1a3a1a;
  color: #4caf50;
  border: 1px solid #4caf50;
}

.btn--approve:hover:not(:disabled) {
  background-color: #224422;
}

.btn--reject {
  background-color: #3a1a1a;
  color: #f44336;
  border: 1px solid #f44336;
}

.btn--reject:hover:not(:disabled) {
  background-color: #442222;
}

.empty {
  text-align: center;
  color: #666666;
  font-style: italic;
  margin: 2rem 0;
}
</style>
