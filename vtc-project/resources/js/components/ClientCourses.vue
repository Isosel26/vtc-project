<template>
  <div class="page">
    <div class="container">
      <h2>Mes courses</h2>

      <p v-if="courses.length === 0" class="empty">Vous n'avez pas encore de course.</p>

      <div v-else class="course-list">
        <div v-for="course in courses" :key="course.id" class="course-card">
          <div class="course-row">
            <div class="course-info">
              <span class="label">Départ</span>
              <span class="value">{{ course.departure }}</span>
            </div>
            <div class="course-info">
              <span class="label">Destination</span>
              <span class="value">{{ course.destination }}</span>
            </div>
          </div>
          <div class="course-row">
            <div class="course-info">
              <span class="label">Date</span>
              <span class="value">{{ formatDate(course.scheduled_at) }}</span>
            </div>
            <div class="course-info">
              <span class="label">Statut</span>
              <span :class="['badge', course.status]">{{ statutLabel(course.status) }}</span>
            </div>
          </div>
          <div v-if="course.chauffeur" class="chauffeur-info">
            <span class="label">Chauffeur</span>
            <span class="value">{{ course.chauffeur.name }}</span>
          </div>
          <div v-else class="chauffeur-info waiting">
            En attente d'un chauffeur...
          </div>
        </div>
      </div>

      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      <router-link to="/client" class="link">← Demander une nouvelle course</router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ClientCourses',
  data() {
    return {
      courses: [],
      errorMessage: ''
    };
  },
  created() {
    this.fetchCourses();
  },
  methods: {
    async fetchCourses() {
      try {
        const token = localStorage.getItem('access_token');
        const response = await axios.get('http://localhost:8000/api/client/courses', {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.courses = response.data;
      } catch (error) {
        console.error(error);
        this.errorMessage = 'Erreur lors du chargement de vos courses.';
      }
    },
    formatDate(datetime) {
      const date = new Date(datetime);
      if (isNaN(date.getTime())) return 'Date invalide';
      return date.toLocaleString('fr-FR');
    },
    statutLabel(status) {
      const labels = { pending: 'En attente', accepted: 'Acceptée', finished: 'Terminée' };
      return labels[status] || status;
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

.container {
  max-width: 700px;
  margin: 0 auto;
  position: relative;
  z-index: 1;
}

h2 {
  font-size: 1.8rem;
  font-weight: 900;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  margin-bottom: 2rem;
  text-align: center;
}

.course-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.course-card {
  background-color: #1a1a1a;
  border: 1px solid #2a2a2a;
  border-radius: 14px;
  padding: 1.25rem 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.course-row {
  display: flex;
  gap: 2rem;
}

.course-info {
  display: flex;
  flex-direction: column;
  gap: 0.2rem;
  flex: 1;
}

.label {
  font-size: 0.65rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: #666666;
}

.value {
  font-size: 0.95rem;
  color: #ffffff;
  font-weight: 600;
}

.badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.05em;
  text-transform: uppercase;
}

.badge.pending  { background-color: #3a2800; color: #ffc107; }
.badge.accepted { background-color: #002a10; color: #4caf50; }
.badge.finished { background-color: #2a2a2a; color: #aaaaaa; }

.chauffeur-info {
  font-size: 0.85rem;
  color: #aaaaaa;
  padding-top: 0.5rem;
  border-top: 1px solid #2a2a2a;
}

.chauffeur-info.waiting {
  font-style: italic;
  color: #666666;
}

.empty {
  text-align: center;
  color: #666666;
  font-style: italic;
  margin: 2rem 0;
}

.error {
  color: #ff6b6b;
  text-align: center;
  margin-top: 1rem;
}

.link {
  color: #aaaaaa;
  text-decoration: none;
  font-size: 0.85rem;
  display: block;
  text-align: center;
  margin-top: 2rem;
  transition: color 0.2s;
}

.link:hover {
  color: #ffffff;
}
</style>
