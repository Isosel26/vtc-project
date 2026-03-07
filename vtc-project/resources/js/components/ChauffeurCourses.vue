<template>
  <div class="page">
    <div class="container">
      <h2>Dashboard Chauffeur</h2>

      <div v-if="statut !== 'approved'" class="warning-box">
        ⏳ Votre compte est en attente de validation par l'administrateur.<br>
        Vous ne pouvez pas encore accepter de courses.
      </div>

      <h3>Courses en attente</h3>

      <p v-if="courses.length === 0" class="empty">Aucune course disponible pour le moment.</p>

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
            <div class="course-action">
              <button
                @click="acceptCourse(course.id)"
                :disabled="statut !== 'approved'"
                class="btn"
              >
                Accepter
              </button>
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
  name: 'ChauffeurCourses',
  data() {
    return {
      courses: [],
      statut: localStorage.getItem('chauffeur_statut') || 'pending',
    };
  },
  methods: {
    async fetchCourses() {
      const token = localStorage.getItem('access_token');
      try {
        const response = await axios.get('http://localhost:8000/api/courses', {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.courses = response.data;
      } catch (error) {
        console.error('Erreur lors du chargement des courses :', error);
      }
    },
    async acceptCourse(courseId) {
      const token = localStorage.getItem('access_token');
      try {
        await axios.post(`http://localhost:8000/api/courses/${courseId}/accept`, {}, {
          headers: { Authorization: `Bearer ${token}` }
        });
        alert('Course acceptée !');
        this.fetchCourses();
      } catch (error) {
        if (error.response && error.response.status === 403) {
          alert(error.response.data.message);
        } else {
          alert("Erreur lors de l'acceptation de la course.");
        }
      }
    },
    formatDate(datetime) {
      const date = new Date(datetime);
      if (isNaN(date.getTime())) return 'Date invalide';
      return date.toLocaleString('fr-FR');
    }
  },
  mounted() {
    this.fetchCourses();
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
  text-align: center;
  margin-bottom: 1.5rem;
}

h3 {
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: #aaaaaa;
  margin-bottom: 1rem;
  margin-top: 1.5rem;
}

.warning-box {
  background-color: #2a2000;
  border: 1px solid #ffc107;
  border-radius: 12px;
  padding: 1rem 1.5rem;
  text-align: center;
  color: #ffc107;
  font-size: 0.88rem;
  line-height: 1.6;
  margin-bottom: 1rem;
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
  align-items: flex-end;
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

.course-action {
  flex-shrink: 0;
}

.btn {
  padding: 0.6rem 1.5rem;
  background-color: #888888;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  cursor: pointer;
  transition: background-color 0.2s;
  font-family: 'Inter', sans-serif;
}

.btn:hover:not(:disabled) {
  background-color: #aaaaaa;
}

.btn:disabled {
  background-color: #333333;
  color: #666666;
  cursor: not-allowed;
}

.empty {
  text-align: center;
  color: #666666;
  font-style: italic;
  margin: 2rem 0;
}
</style>
