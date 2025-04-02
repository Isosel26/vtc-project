<template>
    <div>
      <h2>Courses en attente</h2>
      <table>
        <thead>
          <tr>
            <th>Départ</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="course in courses" :key="course.id">
            <td>{{ course.departure }}</td>
            <td>{{ course.destination }}</td>
            <td>{{ formatDate(course.scheduled_at) }}</td>
            <td><button @click="acceptCourse(course.id)">Accepter</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'ChauffeurCourses',
    data() {
      return {
        courses: [],
      };
    },
    methods: {
      async fetchCourses() {
        const token = localStorage.getItem('access_token');
        try {
          const response = await axios.get('http://localhost:8000/api/courses', {
            headers: {
              Authorization: `Bearer ${token}`
            }
          });
          this.courses = response.data;
        } catch (error) {
          console.error("Erreur lors du chargement des courses", error);
        }
      },
      async acceptCourse(id) {
        const token = localStorage.getItem('access_token');
        try {
          await axios.post(`http://localhost:8000/api/courses/${id}/accept`, {}, {
            headers: {
              Authorization: `Bearer ${token}`
            }
          });
          alert("Course acceptée !");
          this.fetchCourses(); // recharge les courses restantes
        } catch (error) {
          console.error("Erreur lors de l'acceptation", error);
        }
      },
      formatDate(datetime) {
        return new Date(datetime).toLocaleString();
      }
    },
    mounted() {
      this.fetchCourses();
    }
  }
  </script>
  
  <style scoped>
  table {
    border-collapse: collapse;
    width: 100%;
  }
  th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
  }
  </style>
  