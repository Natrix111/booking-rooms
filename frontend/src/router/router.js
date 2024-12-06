import { createWebHistory, createRouter } from 'vue-router'

import MainPage from "@/pages/MainPage.vue";
import CatalogRoomsPage from "@/pages/CatalogRoomsPage.vue";
import RoomViewPage from "@/pages/RoomViewPage.vue";

const routes = [
    { path: '/', component: MainPage },
    { path: '/rooms', component: CatalogRoomsPage },
    { path: '/rooms/:id', component: RoomViewPage },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router