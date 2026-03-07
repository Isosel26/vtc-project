import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import CourseRequest from '../components/CourseRequest.vue';
import CourseList from '../components/CourseList.vue';
import ChauffeurCourses from '../components/ChauffeurCourses.vue';
import AdminDashboard from '../components/AdminDashboard.vue';
import ClientCourses from '../components/ClientCourses.vue';

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/login', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },

  // Routes protégées — meta indique qui a le droit d'accéder
  { path: '/client', name: 'Client', component: CourseRequest, meta: { requiresAuth: true, role: 'client' } },
  { path: '/client/courses', name: 'ClientCourses', component: ClientCourses, meta: { requiresAuth: true, role: 'client' } },
  { path: '/chauffeur', name: 'Chauffeur', component: CourseList, meta: { requiresAuth: true, role: 'chauffeur' } },
  { path: '/chauffeur/dashboard', name: 'ChauffeurDashboard', component: ChauffeurCourses, meta: { requiresAuth: true, role: 'chauffeur' } },
  { path: '/admin', name: 'Admin', component: AdminDashboard, meta: { requiresAuth: true, role: 'admin' } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Guard : vérifié avant chaque changement de page
router.beforeEach((to, _from, next) => {
  const requiresAuth = to.meta.requiresAuth;
  const requiredRole = to.meta.role;
  const token = localStorage.getItem('access_token');
  const userRole = localStorage.getItem('user_role');

  if (requiresAuth && !token) {
    next('/login');
    return;
  }

  if (requiresAuth && requiredRole && userRole !== requiredRole) {
    next('/login');
    return;
  }

  next();
});

export default router;
