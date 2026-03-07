<template>
  <div class="page">
    <div class="container">
      <h2>Courses disponibles</h2>

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
          <div class="course-action">
            <button @click="acceptCourse(course.id)" class="btn">Accepter la course</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'CourseList',
  data() {
    return {
      courses: [],
    };
  },
  created() {
    this.fetchCourses();
  },
  methods: {
    async fetchCourses() {
      try {
        const token = localStorage.getItem('access_token');
        const response = await axios.get('http://localhost:8000/api/courses', {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.courses = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    async acceptCourse(courseId) {
      try {
        const token = localStorage.getItem('access_token');
        await axios.post(`http://localhost:8000/api/courses/${courseId}/accept`, {}, {
          headers: { Authorization: `Bearer ${token}` },
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
  },
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
  margin-bottom: 2rem;
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
  gap: 1rem;
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

.course-action {
  text-align: right;
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

.btn:hover {
  background-color: #aaaaaa;
}

.empty {
  text-align: center;
  color: #666666;
  font-style: italic;
  margin: 2rem 0;
}
</style>
