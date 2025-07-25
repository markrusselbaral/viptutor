import { createRouter, createWebHistory } from 'vue-router'
import AdminLoginView from '../views/admin/AdminLogin.vue'
import AdminDashboardView from '../views/admin/AdminDashboard.vue'
import UserTaskView from '../views/user/UserTask.vue'
import UserLoginView from '../views/user/UserLogin.vue'
import UserRegisterView from '../views/user/UserRegister.vue'
import { useAuthStore } from '@/stores/authStore'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/admin-login',
      name: 'adminLogin',
      component: AdminLoginView,
    },
    {
      path: '/admin-dashboard',
      name: 'adminDashboard',
      component: AdminDashboardView,
      meta: { requiresAuth: true, requiresAdmin: true },
    },
    {
      path: '/login',
      name: 'UserLogin',
      component: UserLoginView,
    },
    {
      path: '/register',
      name: 'UserRegister',
      component: UserRegisterView,
    },
    {
      path: '/tasks',
      name: 'UserTask',
      component: UserTaskView,
      meta: { requiresAuth: true },
    },

  ],
})

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()
  
  try {
    // Check if the route requires authentication
    if (to.matched.some((record) => record.meta.requiresAuth)) {
      const isAuthenticated = await authStore.authCheck()
      
      if (!isAuthenticated) {
        return next({ name: 'adminLogin' })
      }


      // If the route is marked as admin-only
      if (to.matched.some((record) => record.meta.requiresAdmin)) {
        if (!isAuthenticated.is_admin) {
          return next({ path: '/tasks' }) // Non-admins go to their task list
        }
      }
    }

    next()
  } catch (error) {
    console.error('Error during auth check:', error)
    next({ name: 'adminLogin' })
  }
})


export default router
