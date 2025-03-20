<template>
    <div>
      <h2>Demander une course</h2>
      <form @submit.prevent="submitCourse">
        <div>
          <label for="departure">Départ :</label>
          <input type="text" v-model="course.departure" id="departure" required />
        </div>
        <div>
          <label for="destination">Destination :</label>
          <input type="text" v-model="course.destination" id="destination" required />
        </div>
        <div>
          <label for="scheduled_at">Date et heure :</label>
          <input type="datetime-local" v-model="course.scheduled_at" id="scheduled_at" required />
        </div>
        <button type="submit">Demander la course</button>
      </form>
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
          const response = await axios.post('http://localhost:8000/api/courses', this.course, {
            headers: { Authorization: `Bearer ${token}` },
          });
          alert('Course demandée avec succès !');
        } catch (error) {
          console.error(error);
          alert('Erreur lors de la demande de course.');
        }
      },
    },
  };
  </script>
  