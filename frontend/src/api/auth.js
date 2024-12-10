import {api} from "@/api/api.js";

export const getAuthFromApi = async (email, password) => {
    try {
        const {data} = await api.post('login', {email, password})
        return data.data?.user_token

    } catch (error) {
        console.error(error);
    }
}

export const logoutFromApi = async (token) => {
    try {
        const {data} = await api.get('logout', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        localStorage.removeItem('token')

    } catch (error) {
        console.error(error);
    }
}

export const registerFromApi = async (userData) => {
    try {
        const {data} = await api.post('register', userData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })

        return data

    } catch (error) {
        console.error(error);
    }
}