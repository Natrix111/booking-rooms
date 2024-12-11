import {defineStore} from 'pinia'
import {computed, ref} from 'vue'
import {getAuthFromApi, logoutFromApi} from "@/api/auth.js";
import {useRouter} from "vue-router";
import {registerFromApi} from "@/api/auth.js";

export const useAuthStore = defineStore('AuthStore', () => {
    const token = ref(localStorage.getItem('token') || null);
    const isAuth = computed(() => !!token.value);
    const user = ref(localStorage.getItem('user') || null)

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

    const register = async (userData) => {
        try {
            const data = await registerFromApi(userData)

            token.value = data.user_token
            localStorage.setItem('token', token.value)

            user.value = data.user
            localStorage.setItem('user', user.value)

            router.push('/profile')


        } catch (error) {
            console.error(error.response.data);
        }
    }

    return {token, user, isAuth, getAuth, logout, register}
})

