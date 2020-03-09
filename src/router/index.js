import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import AddArt from '../views/addArt.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/agregar-articulo',
    name: 'addArt',
    component: AddArt
  },

]

const router = new VueRouter({
  routes
})

export default router
