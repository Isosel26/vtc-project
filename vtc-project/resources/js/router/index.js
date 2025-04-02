import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import CourseRequest from '../components/CourseRequest.vue';
import CourseList from '../components/CourseList.vue';
import ChauffeurCourses from '../components/ChauffeurCourses.vue';

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/login', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },
  { path: '/client', name: 'Client', component: CourseRequest },
  { path: '/chauffeur', name: 'Chauffeur', component: CourseList },
  { path: '/chauffeur/dashboard', name: 'ChauffeurDashboard', component: ChauffeurCourses },
  
  // Pour tester, ajoute une route simple :
  { path: '/chauffeur/test', name: 'Test', component: { template: '<h1>Test Chauffeur Page</h1>' } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
