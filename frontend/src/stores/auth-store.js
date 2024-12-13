import {defineStore} from 'pinia'
import {computed, ref} from 'vue'
import {getAuthFromApi, logoutFromApi} from "@/api/auth.js";
import {useRouter} from "vue-router";
import {registerFromApi} from "@/api/auth.js";
import {toast} from "vue3-toastify";

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
            toast.error('Что то пошло не так. Попробуйте еще раз.')
            console.error(error);
        }
    }

    const logout = async () => {
        try {
            toast.info('Выход из аккаунта. Пожалуйста, подождите.')

            await logoutFromApi(token.value)

            localStorage.removeItem('token')
            token.value = null

            await router.push('/')

            toast.info('Вы вышли из аккаунта')
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

            await router.push('/profile')

            toast.success('Вы успешно зарегистрировались и вошли в аккаунт!')

        } catch (error) {
            toast.error('Что то пошло не так. Попробуйте еще раз.')
            throw error
        }
    }

    return {token, user, isAuth, getAuth, logout, register}
})

