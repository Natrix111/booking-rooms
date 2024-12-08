import {defineStore} from 'pinia'
import {ref} from 'vue'
import {getAuthFromApi} from "@/api/auth.js";

export const useAuthStore = defineStore('AuthStore', () => {
    const isAuth = ref(localStorage.getItem('token') || false)

    const getAuth = async (email, password) => {
        try {
            isAuth.value = await getAuthFromApi(email, password)
            localStorage.token = isAuth.value
            return true
        } catch (error) {
            console.error(error);
        }
    }
    return {isAuth, getAuth}
})

