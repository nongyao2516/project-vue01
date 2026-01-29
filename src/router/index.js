import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/customer',
    name: 'customer',
    component: () => import( '../views/Customer.vue')
  },
  {
    path: '/employee',
    name: 'employee',
    component: () => import( '../views/Employees.vue')
  },
  {
    path: '/add_customer',
    name: 'add_customer',
    component: () => import( '../views/Add_customer.vue')
  },
   {
    path: '/add_employee',
    name: 'add_employee',
    component: () => import( '../views/Add_employee.vue')
  },
  {
    path: '/product',
    name: 'product',
    component: () => import( '../views/Product.vue')
  },
   {
    path: '/sh_product',
    name: 'sh_product',
    component: () => import( '../views/Sh_product.vue')
  },
   {
    path: '/add_product',
    name: 'add_product',
    component: () => import( '../views/Add_product.vue')
  },
  {
    path: '/popup_product',
    name: 'popup_product',
    component: () => import( '../views/Popup_customer.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
