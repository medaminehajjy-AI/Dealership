import { createRouter, createWebHistory } from 'vue-router'

import Home from '../views/Home.vue'
import About from '../views/About.vue'
import Cars from '../views/Cars.vue'
import CarDetails from '../views/CarDetails.vue'
import Favorites from '../views/Favorites.vue'
import PurchaseRequests from '../views/PurchaseRequests.vue'
import Contact from '../views/Contact.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Profile from '../views/Profile.vue'

import Dashboard from '../views/admin/Dashboard.vue'
import AdminCars from '../views/admin/Cars.vue'
import CreateCar from '../views/admin/CreateCar.vue'
import EditCar from '../views/admin/EditCar.vue'
import AdminPurchaseRequests from '../views/admin/PurchaseRequests.vue'
import Statistics from '../views/admin/Statistics.vue'
import AdminBookings from '../views/admin/Bookings.vue'
import Customers from '../views/admin/Customers.vue'
import Messages from '../views/admin/Messages.vue'
import AdminLayout from '@/components/AdminLayout.vue'
import MainLayout from '@/views/MainLayout.vue'

import { useAuthStore } from '../stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),

  routes: [
    {
      path: '/',
      component: MainLayout,

      children: [

        {
          path: '',
          name: 'home',
          component: Home,
        },

        {
          path: 'about',
          name: 'about',
          component: About,
        },

        {
          path: 'cars',
          name: 'cars',
          component: Cars,
        },

        {
          path: 'cars/:id',
          name: 'car-details',
          component: CarDetails,
          props: true,
        },

        {
          path: 'favorites',
          name: 'favorites',
          component: Favorites,
        },

        {
          path: 'purchase-requests',
          name: 'purchase-requests',
          component: PurchaseRequests,
        },

        {
          path: 'contact',
          name: 'contact',
          component: Contact,
        },

        {
          path: 'login',
          name: 'login',
          component: Login,
          meta: {
            guest: true,
          },
        },

        {
          path: 'register',
          name: 'register',
          component: Register,
          meta: {
            guest: true,
          },
        },
        {
          path: '/profile',
          name: 'Profile',
          component: Profile,
          meta: {
              requiresAuth: true
          }
        },

      ],
    },

    // Admin Routes

    {
      path: '/admin',
      component: AdminLayout,
      meta: {
        requiresAuth: true,
        admin: true,
      },

      children: [
        {
          path: 'dashboard',
          name: 'dashboard',
          component: Dashboard,
        },
        {
          path: 'statistics',
          name: 'statistics',
          component: Statistics,
        },
        {
          path: 'cars',
          name: 'admin-cars',
          component: AdminCars,
        },

        {
          path: 'cars/create',
          name: 'CreateCar',
          component: CreateCar,
        },

        {
          path: 'cars/:id/edit',
          name: 'edit-car',
          component: EditCar,
          props: true,
        },

        {
          path: 'customers',
          name: 'admin-customers',
          component: Customers,
        },

        {
          path: 'purchase-requests',
          name: 'AdminPurchaseRequests',
          component: AdminPurchaseRequests,
        },
        {
          path: 'bookings',
          name: 'Admin_bookings',
          component: AdminBookings,
        },
        {
          path: 'messages',
          name: 'admin-messages',
          component: Messages,
        },
      ],
    },

    {
      path: '/:pathMatch(.*)*',
      redirect: '/',
    },
  ],


  /* this is fixing the scroll in the top of the page*/
  scrollBehavior(to, from, savedPosition) {
       
     /* WHY NOT WORKING !!
        if (to.name === 'home') {
            return { top: 300 }
        } */

       return { top: 60 }
    },
    
})

router.beforeEach((to, from, next) => {

  const auth = useAuthStore()

  // Protected routes
  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return next('/login')
  }

  // Admin only
  if (to.meta.admin && !auth.isAdmin) {
    return next('/')
  }

  // Prevent logged-in users from visiting Login/Register
  if (to.meta.guest && auth.isAuthenticated) {

    if (auth.isAdmin) {
      return next('/admin/dashboard')
    }

    return next('/')
  }

  next()
})

export default router
