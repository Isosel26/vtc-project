<template>
    <div class="chauffeur-courses">
      <h1>Dashboard Chauffeur</h1>
      <h2>Courses en attente</h2>
      <div v-if="courses.length === 0" class="no-courses">
        <p>Aucune course disponible</p>
      </div>
      <table v-else>
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
            <td>
              <button @click="acceptCourse(course.id)">Accepter</button>
            </td>
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
          console.log("Courses récupérées :", response.data);
          this.courses = response.data;
        } catch (error) {
          console.error("Erreur lors du chargement des courses :", error);
        }
      },
      async acceptCourse(courseId) {
        const token = localStorage.getItem('access_token');
        try {
          await axios.post(`http://localhost:8000/api/courses/${courseId}/accept`, {}, {
            headers: {
              Authorization: `Bearer ${token}`
            }
          });
          alert("Course acceptée !");
          this.fetchCourses(); // Recharge la liste après acceptation
        } catch (error) {
          console.error("Erreur lors de l'acceptation de la course :", error);
          alert("Erreur lors de l'acceptation de la course.");
        }
      },
      formatDate(datetime) {
        const date = new Date(datetime);
        if (isNaN(date.getTime())) {
          return "Date invalide";
        }
        return date.toLocaleString();
      }
    },
    mounted() {
      console.log("ChauffeurCourses monté");
      this.fetchCourses();
    }
  };
  </script>
  
  <style scoped>
  .chauffeur-courses {
    padding: 2rem;
    max-width: 800px;
    margin: auto;
  }
  
  h1, h2 {
    text-align: center;
    margin-bottom: 1rem;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
  }
  
  thead {
    background-color: #333;
    color: #fff;
  }
  
  th, td {
    padding: 0.8rem;
    border: 1px solid #ccc;
    text-align: center;
  }
  
  button {
    background-color: #28a745;
    border: none;
    color: #fff;
    padding: 0.5rem 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  button:hover {
    background-color: #218838;
  }
  
  .no-courses {
    text-align: center;
    font-size: 1.2rem;
    color: #666;
  }
  </style>
  