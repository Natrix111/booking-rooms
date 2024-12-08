import { defineStore } from 'pinia'
import {ref, computed} from 'vue'
import axios from "axios";
import {getAuthFromApi} from "@/api/auth.js";


// export const useAuthStore = defineStore('authStore', () => {
//     const token = ref('');
//
//     const isAuth = computed(() => !!token.value);
//
//     const setToken = (newToken) => {
//         token.value = newToken;
//     };
//
//     const clearToken = () => {
//         token.value = '';
//     };
//
//     return {
//         token,
//         isAuth,
//         setToken,
//         clearToken,
//     };
//
//
// })

export const useAuthStore = defineStore('AuthStore', () => {
    const isAuth = ref(localStorage.getItem('token') || false)


    const getAuth = async () => {
        try {
            isAuth.value = await getAuthFromApi()
            console.log(isAuth.value)

        } catch (error) {
            console.error(error);
        }
    }

    // console.log(getAuth)
    return {isAuth, getAuth}
})




// const useLogin = async () => {
//     try {
//         const {data} = await axios.post('http://localhost:8080/api/login', {
//             email: loginData.email,
//             password: loginData.password
//         })
//
//         localStorage.token = data.data.user_token;
//
//         console.log(localStorage.token)
//
//     } catch(error) {
//         console.error(error)
//     }
// }