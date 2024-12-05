import { createWebHistory, createRouter } from 'vue-router'

import MainPage from "@/pages/MainPage.vue";
import CatalogRoomsPage from "@/pages/CatalogRoomsPage.vue";

const routes = [
    { path: '/', component: MainPage },
    { path: '/catalog', component: CatalogRoomsPage },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router