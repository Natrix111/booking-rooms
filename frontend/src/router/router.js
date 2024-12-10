import { createWebHistory, createRouter } from 'vue-router'

import MainPage from "@/pages/MainPage.vue";
import CatalogRoomsPage from "@/pages/CatalogRoomsPage.vue";
import AuthorizationPage from "@/pages/AuthorizationPage.vue";
import ProfilePage from "@/pages/ProfilePage.vue";
import RoomViewPage from "@/pages/RoomViewPage.vue";
import RoomCreatePage from "@/pages/RoomCreatePage.vue";
import RegisterPage from "../pages/RegisterPage.vue";


const routes = [
    { path: '/', component: MainPage },
    { path: '/rooms', component: CatalogRoomsPage },
    { path: '/rooms/:id', component: RoomViewPage },
    { path: '/rooms/create', component: RoomCreatePage },
    { path: '/login', component: AuthorizationPage },
    { path: '/register', component: RegisterPage },
    { path: '/profile', component: ProfilePage },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router