<template>
  <div class="client-courses">
    <h2>Mes courses</h2>

    <p v-if="courses.length === 0">Vous n'avez pas encore de course.</p>

    <table v-else>
      <thead>
        <tr>
          <th>Départ</th>
          <th>Destination</th>
          <th>Date</th>
          <th>Statut</th>
          <th>Chauffeur</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="course in courses" :key="course.id">
          <td>{{ course.departure }}</td>
          <td>{{ course.destination }}</td>
          <td>{{ formatDate(course.scheduled_at) }}</td>
          <td :class="course.status">{{ statutLabel(course.status) }}</td>
          <td>{{ course.chauffeur ? course.chauffeur.name : 'En attente d\'un chauffeur' }}</td>
        </tr>
      </tbody>
    </table>

    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
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
      return date.toLocaleString();
    },
    statutLabel(status) {
      const labels = {
        pending: 'En attente',
        accepted: 'Acceptée',
        finished: 'Terminée'
      };
      return labels[status] || status;
    }
  }
};
</script>

<style scoped>
.client-courses {
  padding: 2rem;
  max-width: 900px;
  margin: auto;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}
th, td {
  padding: 0.8rem;
  border: 1px solid #ccc;
  text-align: center;
}
thead {
  background-color: #333;
  color: #fff;
}
td.pending  { color: orange; font-weight: bold; }
td.accepted { color: green;  font-weight: bold; }
td.finished { color: gray;   font-weight: bold; }
.error { color: red; }
</style>
