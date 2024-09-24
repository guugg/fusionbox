import { createRouter, createWebHistory  } from 'vue-router'
import HomeComponent from '@/views/HomeView.vue'
import AboutComponent from '@/views/AboutView.vue'

const routes = [
    { path: '/', component: HomeComponent },
    { path: '/about', component: AboutComponent },
]

const router = createRouter({
    history: createWebHistory (),
    routes,
})

export default router
