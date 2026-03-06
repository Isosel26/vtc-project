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

  // Routes protégées — meta indique qui a le droit d'accéder
  { path: '/client', name: 'Client', component: CourseRequest, meta: { requiresAuth: true, role: 'client' } },
  { path: '/chauffeur', name: 'Chauffeur', component: CourseList, meta: { requiresAuth: true, role: 'chauffeur' } },
  { path: '/chauffeur/dashboard', name: 'ChauffeurDashboard', component: ChauffeurCourses, meta: { requiresAuth: true, role: 'chauffeur' } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Guard : vérifié avant chaque changement de page
router.beforeEach((to, from, next) => {
  const requiresAuth = to.meta.requiresAuth;
  const requiredRole = to.meta.role;
  const token = localStorage.getItem('access_token');
  const userRole = localStorage.getItem('user_role');

  // Si la page nécessite une connexion et que l'utilisateur n'est pas connecté
  if (requiresAuth && !token) {
    next('/login');
    return;
  }

  // Si la page nécessite un rôle précis et que l'utilisateur n'a pas le bon rôle
  if (requiresAuth && requiredRole && userRole !== requiredRole) {
    next('/login');
    return;
  }

  // Tout est bon, on laisse passer
  next();
});

export default router;
