import { createRouter, createWebHistory } from 'vue-router';
import CreateUser from './components/CreateUser.vue';

const routes=[
    {
        path:'/user',
        name:'user',
        component:CreateUser
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});