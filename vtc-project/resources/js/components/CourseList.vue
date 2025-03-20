<template>
    <div>
      <h2>Courses disponibles</h2>
      <ul>
        <li v-for="course in courses" :key="course.id">
          <p>
            <strong>Départ :</strong> {{ course.departure }} - 
            <strong>Destination :</strong> {{ course.destination }}
          </p>
          <button @click="acceptCourse(course.id)">Accepter la course</button>
        </li>
      </ul>
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
          // Rafraîchir la liste après acceptation
          this.fetchCourses();
        } catch (error) {
          console.error(error);
          alert('Erreur lors de l\'acceptation de la course.');
        }
      },
    },
  };
  </script>
  