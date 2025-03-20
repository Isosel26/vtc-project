import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Login from '../components/Login.vue';
import CourseRequest from '../components/CourseRequest.vue';
import CourseList from '../components/CourseList.vue';

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/login', name: 'Login', component: Login },
  { path: '/client', name: 'Client', component: CourseRequest },
  { path: '/chauffeur', name: 'Chauffeur', component: CourseList },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
