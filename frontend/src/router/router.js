import { createWebHistory, createRouter } from 'vue-router'

import MainPage from "@/pages/MainPage.vue";
import CatalogRoomsPage from "@/pages/CatalogRoomsPage.vue";

import AuthorizationPage from "@/pages/AuthorizationPage.vue";
import ProfilePage from "@/pages/ProfilePage.vue";
import RoomViewPage from "@/pages/RoomViewPage.vue";


const routes = [
    { path: '/', component: MainPage },
    { path: '/catalog', component: CatalogRoomsPage },
    { path: '/login', component: AuthorizationPage },
    { path: '/profile', component: ProfilePage },
    { path: '/rooms', component: CatalogRoomsPage },
    { path: '/rooms/:id', component: RoomViewPage },
    { path: '/', component: RoomViewPage },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router