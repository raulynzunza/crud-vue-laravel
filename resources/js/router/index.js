import { createRouter, createWebHistory } from 'vue-router'
import login from '../pages/Login.vue'
import dashboard from '../pages/Dashboard.vue'
import notFound from '../pages/NotFound.vue'
import AddUser from '../pages/AddUser.vue'
import UpdateUser from '../pages/UpdateUser.vue'
import Register from '../pages/Register.vue'

const routes = [
    {
        path: '/',
        component: login
    },
    {
        path: '/register',
        component: Register
    },
    {
        path: '/dashboard',
        component: dashboard
    },
    {
        path: '/dashboard/adduser',
        component: AddUser
    },
    {
        path: '/dashboard/edituser/:id',
        component: UpdateUser
    },
    {
        path: '/:pathMatch(.*)*',
        component: notFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})



export default router