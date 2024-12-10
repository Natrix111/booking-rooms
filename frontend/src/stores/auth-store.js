import {defineStore} from 'pinia'
import {computed, ref} from 'vue'
import {getAuthFromApi, logoutFromApi} from "@/api/auth.js";
import {useRouter} from "vue-router";

export const useAuthStore = defineStore('AuthStore', () => {
    const token = ref(localStorage.getItem('token') || null);
    const isAuth = computed(() => !!token.value);
    const router = useRouter()

    const getAuth = async (email, password) => {
        try {
            token.value = await getAuthFromApi(email, password)
            localStorage.setItem('token', token.value)

            return true
        } catch (error) {
            console.error(error);
        }
    }

    const logout = async () => {
        try {
            await logoutFromApi(token.value)

            localStorage.removeItem('token')
            token.value = null

            router.push('/')

        } catch (error) {
            console.error(error);
        }
    }

    return {token, isAuth, getAuth, logout}
})

