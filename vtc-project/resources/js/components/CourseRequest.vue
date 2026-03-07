<template>
  <div class="page">
    <div class="card">
      <h2>Demander une course</h2>
      <form @submit.prevent="submitCourse">
        <div class="form-group">
          <label for="departure">Départ</label>
          <input type="text" v-model="course.departure" id="departure" placeholder="Adresse de départ" required />
        </div>
        <div class="form-group">
          <label for="destination">Destination</label>
          <input type="text" v-model="course.destination" id="destination" placeholder="Adresse d'arrivée" required />
        </div>
        <div class="form-group">
          <label for="scheduled_at">Date et heure</label>
          <input type="datetime-local" v-model="course.scheduled_at" id="scheduled_at" required />
        </div>
        <button type="submit" class="btn">Réserver</button>
      </form>
      <router-link to="/client/courses" class="link">Voir mes courses →</router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'CourseRequest',
  data() {
    return {
      course: {
        departure: '',
        destination: '',
        scheduled_at: '',
      },
    };
  },
  methods: {
    async submitCourse() {
      try {
        const token = localStorage.getItem('access_token');
        const formattedDate = new Date(this.course.scheduled_at)
          .toISOString()
          .slice(0, 19)
          .replace('T', ' ');

        await axios.post('http://localhost:8000/api/courses', {
          ...this.course,
          scheduled_at: formattedDate
        }, {
          headers: { Authorization: `Bearer ${token}` },
        });

        alert('Course demandée avec succès !');
      } catch (error) {
        console.error(error);
        alert('Erreur lors de la demande de course.');
      }
    }
  },
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
  max-width: 480px;
  position: relative;
  z-index: 1;
}

.card h2 {
  font-size: 1.4rem;
  font-weight: 900;
  letter-spacing: 0.12em;
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

.link {
  color: #aaaaaa;
  text-decoration: none;
  font-size: 0.85rem;
  text-align: center;
  display: block;
  margin-top: 1.25rem;
  transition: color 0.2s;
}

.link:hover {
  color: #ffffff;
}
</style>
