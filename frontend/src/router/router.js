import { createWebHistory, createRouter } from 'vue-router'

import MainPage from "@/pages/MainPage.vue";
import CatalogRoomsPage from "@/pages/CatalogRoomsPage.vue";
import AuthorizationPage from "../pages/AuthorizationPage.vue";


const routes = [
    { path: '/', component: MainPage },
    { path: '/catalog', component: CatalogRoomsPage },
    { path: '/login', component: AuthorizationPage },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router